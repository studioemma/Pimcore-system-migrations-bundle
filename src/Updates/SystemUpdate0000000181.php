<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000181 extends SystemUpdate
{
    const BUILDNR = 181;

    public function up()
    {
        $this->db->query('ALTER TABLE `email_log` ADD INDEX `sentDate` (`sentDate`, `id`);');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE `email_log` DROP INDEX `sentDate`;');
    }
}
