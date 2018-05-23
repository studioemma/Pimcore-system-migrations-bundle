#!/usr/bin/env php
<?php

/**
 * Ugly code to copy db content of update-scripts in rerunnable update classes
 *
 * This file will put all code found in the preupdate or postupdate files of
 * pimcore inside a class, the classes must be verified for correctness
 * afterwards. For completeness we should manually implement the inverse of
 * up() in down() manually since that is not provided by pimcore.
 */

function check_file_for_db_migrations($file)
{
    $filecontent = preg_split ('/$\R?^/m', file_get_contents($file));
    foreach ($filecontent as $line) {
        if (stristr($line, '\Pimcore\Db')) {
            $migrationVersion = preg_replace(
                '/.*\/([0-9]+)\/(post|pre)update.php$/',
                '$1',
                $file
            );
            return (int) $migrationVersion;
        }
    }
    return 0;
}

function write_migration_file($key, $filecontents)
{
    $version = sprintf("%'.010d", $key);
    $filename = 'SystemUpdate' . $version . '.php';

    if (file_exists($filename)) {
        return;
    }

    $filecontentslines = preg_split('/$\R?^/m', $filecontents);
    $indent = '        ';
    $upcontent = '';
    foreach ($filecontentslines as $line) {
        $line = rtrim($line);
        if (! empty($line)) {
            $upcontent .= $indent . $line . PHP_EOL;
        }
    }
    $php = <<<PHP
<?php

namespace StudioEmma\SystemMigrationsBundle\Updates;

use StudioEmma\SystemMigrationsBundle\SystemUpdate;

class SystemUpdate$version extends SystemUpdate
{
    const BUILDNR = $key;

    public function up()
    {
$upcontent
    }

    public function down()
    {
        // down not implemented
    }
}

PHP;

    file_put_contents($filename, $php);
}

$directoryIterator = new \RecursiveDirectoryIterator(
    './',
    \FileSystemIterator::SKIP_DOTS
);
$recursiveIterator = new \RecursiveIteratorIterator($directoryIterator);
$regexIterator = new \RegexIterator(
    $recursiveIterator,
    '/^.+(preupdate|postupdate)\.php$/i',
    \RecursiveRegexIterator::GET_MATCH
);

$files = [];
foreach ($regexIterator as $file) {
    $files[] = current($file);
}

natsort($files);

$dbmigrations = [];
foreach ($files as $file) {
    $migrationVersion = check_file_for_db_migrations($file);
    if(! empty($migrationVersion)) {
        $dbmigrations[$migrationVersion]['files'][] = file_get_contents($file);
    }
}

chdir(__DIR__ . '/src/Updates');

foreach ($dbmigrations as $key => $filecontentarray) {
    $filecontents = '';
    foreach($filecontentarray['files'] as $filecontent) {
        $filecontent = str_replace('<?php', '', $filecontent);
        $filecontent = str_replace(
            '$db = \Pimcore\Db::get();',
            '',
            $filecontent
        );
        $filecontent = str_replace('$db', '$this->db', $filecontent);
        $filecontents .= $filecontent;
    }
    write_migration_file($key, $filecontents);
}

