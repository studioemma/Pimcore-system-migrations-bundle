<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000168 extends SystemUpdate
{
    const BUILDNR = 168;

    public function up()
    {
        $this->db->query('ALTER TABLE email_log ADD COLUMN `replyTo` VARCHAR(255) DEFAULT NULL AFTER `from`;');
        $this->db->query('ALTER TABLE documents_email ADD COLUMN `replyTo` VARCHAR(255) DEFAULT NULL AFTER `from`;');

    }

    public function down()
    {
        // down not implemented
    }
}
