<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000184 extends SystemUpdate
{
    const BUILDNR = 184;

    public function up()
    {
        $this->db->query('ALTER TABLE `versions` DROP COLUMN `binaryDataHash`;');

    }

    public function down()
    {
        $this->db->query('ALTER TABLE `versions` ADD COLUMN `binaryDataHash` VARCHAR(40) NULL DEFAULT NULL;');
    }
}
