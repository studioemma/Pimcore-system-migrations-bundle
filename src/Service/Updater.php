<?php

namespace StudioEmma\SystemMigrationsBundle\Service;

final class Updater
{
    public function init($buildNr)
    {
        $db = \Pimcore\Db::get();

        $db->beginTransaction();

        $truncate = 'TRUNCATE TABLE `plugin_se_system_migrations`;';
        $db->query($truncate);

        $now = new \DateTimeImmutable('now');
        $init = 'INSERT INTO `plugin_se_system_migrations`'
            . ' (`pimcore_build`, `updatedDate`)'
            . ' VALUES(?, ?);';
        $db->query($init, [$buildNr, $now->getTimestamp()]);

        $db->commit();
    }

    public function run()
    {
        $updatesFolder = __DIR__ . '/../Updates';

        $directoryIterator = new \RecursiveDirectoryIterator(
            $updatesFolder,
            \FileSystemIterator::SKIP_DOTS
        );
        $updatesIterator = new \RegexIterator(
            $directoryIterator,
            '/^.+\.php$/i'
        );

        $updateClasses = [];
        foreach ($updatesIterator as $updateFile) {
            $updateFilename = $updateFile->getFilename();
            $updateClassname = preg_replace('/\.php$/', '', $updateFilename);
            $updateClasses[] = "\\StudioEmma\\SystemMigrationsBundle\\Updates\\"
                . $updateClassname;
        }

        natsort($updateClasses);

        foreach ($updateClasses as $updateClass) {
            $update = new $updateClass();
            $update->run();
        }
    }
}
