<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000183 extends SystemUpdate
{
    const BUILDNR = 183;

    public function up()
    {
        $this->db->query('ALTER TABLE `versions` ADD COLUMN `binaryDataHash` VARCHAR(40) NULL DEFAULT NULL;');
        $this->db->query('ALTER TABLE `versions` ADD INDEX `binaryDataHash` (`binaryDataHash`);');

    }

    public function down()
    {
        $this->db->query('ALTER TABLE `versions` DROP INDEX `binaryDataHash`;');
        $this->db->query('ALTER TABLE `versions` DROP COLUMN `binaryDataHash`;');
    }
}
