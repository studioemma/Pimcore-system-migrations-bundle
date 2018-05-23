<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate0000000195 extends SystemUpdate
{
    const BUILDNR = 195;

    public function up()
    {
        $this->db->query('ALTER TABLE assets ROW_FORMAT=DYNAMIC;');
        $this->db->query('ALTER TABLE documents ROW_FORMAT=DYNAMIC;');
        $this->db->query('ALTER TABLE objects ROW_FORMAT=DYNAMIC;');
        $this->db->query('ALTER TABLE properties ROW_FORMAT=DYNAMIC;');
        $this->db->query('ALTER TABLE search_backend_data ROW_FORMAT=DYNAMIC;');
        $this->db->query('ALTER TABLE users_workspaces_asset ROW_FORMAT=DYNAMIC;');
        $this->db->query('ALTER TABLE users_workspaces_document ROW_FORMAT=DYNAMIC;');
        $this->db->query('ALTER TABLE users_workspaces_object ROW_FORMAT=DYNAMIC;');
        $this->db->query("ALTER TABLE `assets`
        	CHANGE COLUMN `filename` `filename` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'  NULL DEFAULT ''AFTER `type`,
        	CHANGE COLUMN `path` `path` VARCHAR(765) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL DEFAULT NULL AFTER `filename`;
        ");
        $this->db->query("ALTER TABLE `documents`
        	CHANGE COLUMN `key` `key` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'  NULL DEFAULT ''AFTER `type`,
        	CHANGE COLUMN `path` `path` VARCHAR(765) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL DEFAULT NULL AFTER `key`;
        ");
        $this->db->query("ALTER TABLE `objects`
        	CHANGE COLUMN `o_key` `o_key` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'  NULL DEFAULT ''AFTER `o_type`,
        	CHANGE COLUMN `o_path` `o_path` VARCHAR(765) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL DEFAULT NULL AFTER `o_key`;
        ");
        $this->db->query("ALTER TABLE `properties`
        	CHANGE COLUMN `cpath` `cpath` VARCHAR(765) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'  NULL DEFAULT ''AFTER `ctype`;
        ");
        $this->db->query("ALTER TABLE `search_backend_data`
        	CHANGE COLUMN `fullpath` `fullpath` VARCHAR(765) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'  NULL DEFAULT ''AFTER `id`;
        ");
        $this->db->query("ALTER TABLE `users_workspaces_asset`
        	CHANGE COLUMN `cpath` `cpath` VARCHAR(765) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'  NULL DEFAULT ''AFTER `cid`;
        ");
        $this->db->query("ALTER TABLE `users_workspaces_document`
        	CHANGE COLUMN `cpath` `cpath` VARCHAR(765) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'  NULL DEFAULT ''AFTER `cid`;
        ");
        $this->db->query("ALTER TABLE `users_workspaces_object`
        	CHANGE COLUMN `cpath` `cpath` VARCHAR(765) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'  NULL DEFAULT ''AFTER `cid`;
        ");
        $incompatible = false;
        $largePrefix = $this->db->fetchRow("SHOW GLOBAL VARIABLES LIKE 'innodb\_large\_prefix';");
        if ($largePrefix && $largePrefix['Value'] != 'ON') {
            $incompatible = true;
        }
        $fileFormat = $this->db->fetchRow("SHOW GLOBAL VARIABLES LIKE 'innodb\_file\_format';");
        if ($fileFormat && $fileFormat['Value'] != 'Barracuda') {
            $incompatible = true;
        }
        $fileFilePerTable = $this->db->fetchRow("SHOW GLOBAL VARIABLES LIKE 'innodb\_file\_per\_table';");
        if ($fileFilePerTable && $fileFilePerTable['Value'] != 'ON') {
            $incompatible = true;
        }
        if ($incompatible) {
            echo '<b>Your MySQL/MariaDB Server is incompatible!</b><br />';
            echo 'Please ensure the following MySQL/MariaDB system variables are set accordingly: <br/>';
            echo '<pre>innodb_file_format = Barracuda
        innodb_large_prefix = 1
        innodb_file_per_table = 1</pre>';
            exit;
        }

    }

    public function down()
    {
        throw new \Exception('You should restore a database instead of going down');
    }
}
