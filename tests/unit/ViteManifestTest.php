<?php

use Idleberg\ViteManifest\ViteManifest;

class ViteManifestTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $vm;

    protected function _before()
    {
        $baseUrl = "https://idleberg.github.io";
        $manifest = __DIR__ . "/../_data/manifest.json";

        $this->vm = new ViteManifest($manifest, $baseUrl);
    }

    protected function _after()
    {
    }

    // tests
    public function testGetManifest()
    {
        $actual = $this->vm->getManifest();
        $expected = json_decode('{"demo.ts":{"file":"assets/index.deadbeef.js","src":"demo.ts","isEntry":true,"imports":["_vendor.deadbeef.js"],"css":["assets/index.deadbeef.css"]}}', true);

        $this->assertEquals($actual, $expected);
    }
}
