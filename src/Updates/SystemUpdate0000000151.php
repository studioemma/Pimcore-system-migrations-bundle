<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000151 extends SystemUpdate
{
    const BUILDNR = 151;

    public function up()
    {
        $this->db->query("UPDATE users_permission_definitions SET `key`='tags_configuration' WHERE `key`=\"tags_config\"");

    }

    public function down()
    {
        $this->db->query("UPDATE users_permission_definitions SET `key`='tags_config' WHERE `key`=\"tags_configuration\"");
    }
}
