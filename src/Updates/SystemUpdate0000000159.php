<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000159 extends SystemUpdate
{
    const BUILDNR = 159;

    public function up()
    {
        $this->db->query('
        ALTER TABLE `redirects`
            ADD COLUMN `type` VARCHAR(100) DEFAULT NULL AFTER `id`,
            ADD COLUMN `regex` TINYINT(1) DEFAULT NULL AFTER `priority`
        ;
        ');
        $this->db->beginTransaction();
        try {
            // existing behaviour was always a regex-match, so update existing rows to do so
            $this->db->query('UPDATE redirects SET regex = 1');
            // update type depending on sourceEntireUrl setting
            $this->db->executeQuery('UPDATE redirects SET type = ? WHERE sourceEntireUrl = 1', [
                \Pimcore\Model\Redirect::TYPE_ENTIRE_URI
            ]);
            $this->db->executeQuery('UPDATE redirects SET type = ? WHERE sourceEntireUrl <> 1 OR sourceEntireUrl IS NULL', [
                \Pimcore\Model\Redirect::TYPE_PATH_QUERY
            ]);
            $this->db->commit();
        } catch (\Throwable $e) {
            $this->db->rollBack();
            \Pimcore\Logger::crit($e);
            throw $e;
        }
        // drop column as it isn't needed anymore
        // unfortunately MySQL does not support transactional DDL
        // so we need to do this after the transaction succeeded
        $this->db->query('ALTER TABLE redirects DROP COLUMN sourceEntireUrl');

    }

    public function down()
    {
        throw new \Exception('You should restore a database instead of going down');
    }
}
