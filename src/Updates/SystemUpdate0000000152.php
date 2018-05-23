<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000152 extends SystemUpdate
{
    const BUILDNR = 152;

    public function up()
    {
        $this->db->query('
        CREATE TABLE `importconfigs` (
        	`id` INT(11) NOT NULL AUTO_INCREMENT,
        	`ownerId` INT(11) NULL,
        	`classId` INT(11) NULL,
        	`name` VARCHAR(50) NULL,
        	`config` LONGTEXT NULL,
            `description` LONGTEXT NULL,
        	`creationDate` INT(11) NULL,
        	`modificationDate` INT(11) NULL,
        	`shareGlobally` TINYINT(1) NULL,
        	PRIMARY KEY (`id`),
        	INDEX `ownerId` (`ownerId`),
        	INDEX `classId` (`classId`),
        	INDEX `shareGlobally` (`shareGlobally`)
        )
        DEFAULT CHARSET=utf8mb4;
        ;
        ');
        $this->db->query('
        CREATE TABLE `importconfig_shares` (
        	`importConfigId` INT(11) NOT NULL,
        	`sharedWithUserId` INT(11) NOT NULL,
        	PRIMARY KEY (`importConfigId`, `sharedWithUserId`),
        	INDEX `importConfigId` (`importConfigId`),
        	INDEX `sharedWithUserId` (`sharedWithUserId`)
        )
        DEFAULT CHARSET=utf8mb4;
        ;
        ');
        $this->db->query('
        ALTER TABLE `gridconfigs`
        	ADD COLUMN `shareGlobally` TINYINT(1) NULL DEFAULT NULL AFTER `creationDate`,
        	ADD INDEX `shareGlobally` (`shareGlobally`);
        ;
        ');

    }

    public function down()
    {
        $this->db->query('
        ALTER TABLE `gridconfigs`
        	DROP INDEX `shareGlobally` (`shareGlobally`),
        	DROP COLUMN `shareGlobally`;
        ');

        $this->db->query('DROP TABLE `importconfig_shares`;');
        $this->db->query('DROP TABLE `importconfigs`;');
    }
}
