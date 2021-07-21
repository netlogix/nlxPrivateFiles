<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxPrivateFiles;

use nlxPrivateFiles\Bootstrap\Database;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class nlxPrivateFiles extends Plugin
{
    public function install(InstallContext $installContext)
    {
        $database = new Database(
            $this->container->get('models')
        );

        $database->install();
    }

    public function uninstall(UninstallContext $uninstallContext)
    {
        // If the user wants to keep his data we will not delete it while uninstalling the plugin
        if ($uninstallContext->keepUserData()) {
            return;
        }

        $database = new Database(
            $this->container->get('models')
        );
        $database->uninstall();

        $uninstallContext->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
    }
}
