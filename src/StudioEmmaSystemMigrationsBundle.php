<?php

namespace StudioEmma\SystemMigrationsBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

class StudioEmmaSystemMigrationsBundle extends AbstractPimcoreBundle
{
    public function getInstaller()
    {
        return $this->container->get(Installer::class);
    }
}
