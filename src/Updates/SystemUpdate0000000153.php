<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000153 extends SystemUpdate
{
    const BUILDNR = 153;

    public function up()
    {
        $this->db->insert('users_permission_definitions', ['key' => 'share_configurations']);
        $this->db->insert('users_permission_definitions', ['key' => 'gdpr_data_extractor']);

    }

    public function down()
    {
        $this->db->deleteWhere('users_permission_definitions', "`key` = 'gdpr_data_extractor'");
        $this->db->deleteWhere('users_permission_definitions', "`key` = 'share_configurations'");
    }
}
