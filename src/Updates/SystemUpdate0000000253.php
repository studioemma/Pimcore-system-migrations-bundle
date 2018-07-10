<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000253 extends SystemUpdate
{
    const BUILDNR = 253;

    public function up()
    {
        $this->db->query('ALTER TABLE `users`
        	ADD COLUMN `keyBindings` TEXT NULL AFTER `lastLogin`;
        ');

    }

    public function down()
    {
        $this->db->query('ALTER TABLE `users` DROP COLUMN `keyBindings`;');
    }
}
