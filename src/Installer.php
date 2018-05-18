<?php

namespace StudioEmma\SystemMigrationsBundle;

use Doctrine\DBAL\Migrations\Version;
use Doctrine\DBAL\Schema\Schema;
use Pimcore\Db;
use Pimcore\Extension\Bundle\Installer\MigrationInstaller;
use Pimcore\Logger;

class Installer extends MigrationInstaller
{
    public function migrateInstall(Schema $schema, Version $version)
    {
        $this->installDatabaseTables();
        return true;
    }

    public function migrateUninstall(Schema $schema, Version $version)
    {
        Db::get()->query(
            'DROP TABLE IF EXISTS `plugin_se_system_migrations`'
        );
    }

    public function installDatabaseTables()
    {
        Db::get()->query(
            'CREATE TABLE IF NOT EXISTS `plugin_se_system_migrations` (
              `pimcore_build` int(11) unsigned NOT NULL,
              `updatedDate` bigint(20) unsigned DEFAULT NULL,
              PRIMARY KEY (`pimcore_build`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8'
        );
        $now = new \DateTimeImmutable('now');
        Db::get()->query(
            'INSERT INTO `plugin_se_system_migrations`
            (`pimcore_build`, `updatedDate`)
            VALUES (?, ?)',
            [\Pimcore\Version::getRevision(), $now->getTimestamp()]
        );
    }
}
