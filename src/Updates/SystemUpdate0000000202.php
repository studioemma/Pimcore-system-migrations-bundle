<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000202 extends SystemUpdate
{
    const BUILDNR = 202;

    public function up()
    {
        $this->db->insert('users_permission_definitions', ['key' => 'admin_translations']);
        // mark ecommerce install migration as migrated if framework is currently installed
        if (\Pimcore\Bundle\EcommerceFrameworkBundle\PimcoreEcommerceFrameworkBundle::isInstalled()) {
            // create migration table if not exists
            $factory = \Pimcore::getContainer()->get('Pimcore\Migrations\Configuration\ConfigurationFactory');
            $bundle = \Pimcore::getKernel()->getBundle('PimcoreEcommerceFrameworkBundle');
            $config = $factory->getForBundle($bundle, $this->db);
            $config->createMigrationTable();
            $sql = <<<'SQL'
        INSERT IGNORE INTO
            pimcore_migrations (migration_set, version, migrated_at)
        VALUES
            (:migration_set, :version, NOW())
SQL;
            $this->db->executeQuery($sql, [
                'migration_set' => 'PimcoreEcommerceFrameworkBundle',
                'version'       => \Pimcore\Migrations\InstallVersion::INSTALL_VERSION,
            ]);
        }

    }

    public function down()
    {
        $this->db->deleteWhere('users_permission_definitions', "`key` = 'admin_translations'");
    }
}
