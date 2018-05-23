<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000225 extends SystemUpdate
{
    const BUILDNR = 225;

    public function up()
    {
        $this->db->query('ALTER TABLE `documents_page` CHANGE COLUMN `description` `description` VARCHAR(383) NULL DEFAULT NULL;');
        $this->db->query('ALTER table users ADD COLUMN `lastLogin` int(11) unsigned NULL;');
        $this->db->query('ALTER table email_log ADD FULLTEXT INDEX `fulltext` (`from`, `to`, `cc`, `bcc`, `subject`, `params`);');

    }

    public function down()
    {
        $this->db->query('ALTER table email_log DROP INDEX `fulltext`;');
        $this->db->query('ALTER table users DROP COLUMN `lastLogin`;');
    }
}
