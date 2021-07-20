<?php

namespace nlxPrivateFiles\Tests;

use nlxPrivateFiles\nlxPrivateFiles as Plugin;
use Shopware\Components\Test\Plugin\TestCase;

class PluginTest extends TestCase
{
    protected static $ensureLoadedPlugins = [
        'nlxPrivateFiles' => []
    ];

    public function testCanCreateInstance()
    {
        /** @var Plugin $plugin */
        $plugin = Shopware()->Container()->get('kernel')->getPlugins()['nlxPrivateFiles'];

        $this->assertInstanceOf(Plugin::class, $plugin);
    }
}
