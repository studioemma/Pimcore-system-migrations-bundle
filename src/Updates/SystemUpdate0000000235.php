<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000235 extends SystemUpdate
{
    const BUILDNR = 235;

    public function up()
    {
        $this->db->query("REPLACE INTO `users_permission_definitions` (`key`) VALUES ('clear_fullpage_cache');");

    }

    public function down()
    {
        // down not implemented
    }
}
