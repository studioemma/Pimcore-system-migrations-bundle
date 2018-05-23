<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000141 extends SystemUpdate
{
    const BUILDNR = 141;

    public function up()
    {
        $this->db->insert('users_permission_definitions', ['key' => 'piwik_settings']);
        $this->db->insert('users_permission_definitions', ['key' => 'piwik_reports']);

    }

    public function down()
    {
        $this->db->deleteWhere('users_permission_definitions', "`key` = 'piwik_settings'");
        $this->db->deleteWhere('users_permission_definitions', "`key` = 'piwik_reports'");
    }
}
