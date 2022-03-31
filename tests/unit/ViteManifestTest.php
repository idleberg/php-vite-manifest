<?php

use Idleberg\ViteManifest\ViteManifest;

class ViteManifestTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $baseUrl = "https://idleberg.github.io";
        $manifest = __DIR__ . "/../_data/manifest.json";

        $vm = new ViteManifest($manifest, $baseUrl);
    }
}
