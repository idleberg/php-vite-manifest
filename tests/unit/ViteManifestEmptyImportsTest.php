<?php

use Idleberg\ViteManifest\Manifest;

class ViteManifestEmptyImportsTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $vm;
    protected $baseUrl = __DIR__ . "/../_data/";
    protected $manifest = __DIR__ . "/../_data/manifest-empty-imports.json";

    protected function _before()
    {
        $this->vm = new Manifest($this->manifest, $this->baseUrl);
    }

    protected function _after()
    {
        // The void
    }

    // tests
    public function testGetManifest()
    {
        $actual = $this->vm->getManifest();
        $expected = json_decode('{"demo.ts":{"file":"assets/index.deadbeef.js","src":"demo.ts","isEntry":true,"imports":[],"css":["assets/index.deadbeef.css"]}}', true);

        $this->assertEquals($actual, $expected);
    }

    public function testGetImports()
    {
        $this->assertEquals(count($this->vm->getImports("demo.ts")), 0);
    }
}
