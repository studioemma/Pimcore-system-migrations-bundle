<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000186 extends SystemUpdate
{
    const BUILDNR = 186;

    public function up()
    {
        $websiteSettings = $this->db->fetchAll('SELECT * FROM website_settings');
        if (!$websiteSettings) {
            $websiteSettings = [];
        }
        $file = \Pimcore\Config::locateConfigFile('website-settings.php');
        $table = \Pimcore\Db\PhpArrayFileTable::get($file);
        $table->truncate();
        foreach ($websiteSettings as $websiteSetting) {
            unset($websiteSetting['id']);
            $table->insertOrUpdate($websiteSetting, $websiteSetting['id']);
        }
        $this->db->query('RENAME TABLE `website_settings` TO `PLEASE_DELETE__website_settings`;');

    }

    public function down()
    {
        throw new \Exception('You should restore a database instead of going down');
    }
}
