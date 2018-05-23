<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000074 extends SystemUpdate
{
    const BUILDNR = 74;

    public function up()
    {
        $this->db->query("ALTER TABLE `documents_link`
        	CHANGE COLUMN `internalType` `internalType` ENUM('document','asset','object') NULL DEFAULT NULL AFTER `id`;
        ");
    }

    public function down()
    {
        // down not implemented
    }
}
