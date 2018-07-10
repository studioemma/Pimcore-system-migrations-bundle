<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000256 extends SystemUpdate
{
    const BUILDNR = 256;

    public function up()
    {
        $this->db->query('ALTER TABLE `users` ADD COLUMN `twoFactorAuthentication` VARCHAR(255) AFTER `apiKey`');

    }

    public function down()
    {
        $this->db->query('AFTER TABLE `users` DROP COLUMN `twoFactorAuthentication`;');
    }
}
