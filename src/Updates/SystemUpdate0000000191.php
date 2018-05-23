<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000191 extends SystemUpdate
{
    const BUILDNR = 191;

    public function up()
    {
        try {
            $this->db->insert('users_permission_definitions', ['key' => 'asset_metadata']);
        } catch (\Exception $e) {
        }

    }

    public function down()
    {
        $this->db->deleteWhere('users_permission_definitions', "`key` = 'asset_metadata'");
    }
}
