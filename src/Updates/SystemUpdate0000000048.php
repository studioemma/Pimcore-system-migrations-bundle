<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000048 extends SystemUpdate
{
    const BUILDNR = 48;

    public function up()
    {
        $this->db->query('ALTER TABLE `schedule_tasks` ADD INDEX `version` (`version`);');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE `schedule_tasks` DROP INDEX `version`;');
    }
}
