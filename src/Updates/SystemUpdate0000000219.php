<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000219 extends SystemUpdate
{
    const BUILDNR = 219;

    public function up()
    {
        $this->db->query("ALTER TABLE `objects` ADD `o_childrenSortBy` ENUM('key','index') NULL DEFAULT NULL AFTER `o_className`;");
        $this->db->query('ALTER TABLE `objects` ADD INDEX `index` (`o_index`);');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE `objects` DROP INDEX `index`;');
        $this->db->query("ALTER TABLE `objects` DROP `o_childrenSortBy`;");
    }
}
