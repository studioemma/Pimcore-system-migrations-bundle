<?php

namespace StudioEmma\SystemMigrationsBundle\Service;

final class Updater
{
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
