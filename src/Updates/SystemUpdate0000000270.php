<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000270 extends SystemUpdate
{
    const BUILDNR = 270;

    public function up()
    {
        $this->db->query('ALTER TABLE `classes`
        	ALTER `id` DROP DEFAULT;
        ');
        $this->db->query('ALTER TABLE `classes`
        	CHANGE COLUMN `id` `id` VARCHAR(50) NOT NULL FIRST;');
        $this->db->query('ALTER TABLE `objects`
        	CHANGE COLUMN `o_classId` `o_classId` VARCHAR(50) NULL DEFAULT NULL AFTER `o_userModification`;');
        $this->db->query('ALTER TABLE `gridconfigs`
        	CHANGE COLUMN `classId` `classId` VARCHAR(50) NULL DEFAULT NULL AFTER `ownerId`;
        ');
        $this->db->query('ALTER TABLE `gridconfig_favourites`
        	ALTER `classId` DROP DEFAULT;');
        $this->db->query('ALTER TABLE `gridconfig_favourites`
        	CHANGE COLUMN `classId` `classId` VARCHAR(50) NOT NULL AFTER `ownerId`;');
        $this->db->query('ALTER TABLE `importconfigs`
        	CHANGE COLUMN `classId` `classId` VARCHAR(50) NULL DEFAULT NULL AFTER `ownerId`;
        ');
        $this->db->query('ALTER TABLE `custom_layouts`
        	ALTER `classId` DROP DEFAULT;
        ');
        $this->db->query('ALTER TABLE `custom_layouts`
        	CHANGE COLUMN `classId` `classId` VARCHAR(50) NOT NULL AFTER `id`;');

    }

    public function down()
    {
        $this->db->query('ALTER TABLE `classes`
        	ALTER `id` DROP DEFAULT;
        ');
        $this->db->query('ALTER TABLE `classes`
        	CHANGE COLUMN `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;');

        $this->db->query('ALTER TABLE `objects`
        	CHANGE COLUMN `o_classId` `o_classId` INT(11) DEFAULT NULL AFTER `o_userModification`;');

        $this->db->query('ALTER TABLE `gridconfigs`
        	CHANGE COLUMN `classId` `classId` INT(11) DEFAULT NULL AFTER `ownerId`;
        ');

        $this->db->query('ALTER TABLE `gridconfig_favourites`
        	ALTER `classId` DROP DEFAULT;');
        $this->db->query('ALTER TABLE `gridconfig_favourites`
        	CHANGE COLUMN `classId` `classId` INT(11) NOT NULL AFTER `ownerId`;');

        $this->db->query('ALTER TABLE `importconfigs`
        	CHANGE COLUMN `classId` `classId` INT(11) DEFAULT NULL AFTER `ownerId`;
        ');

        $this->db->query('ALTER TABLE `custom_layouts`
        	ALTER `classId` DROP DEFAULT;
        ');
        $this->db->query('ALTER TABLE `custom_layouts`
        	CHANGE COLUMN `classId` `classId` INT(11) NOT NULL AFTER `id`;');
    }
}
