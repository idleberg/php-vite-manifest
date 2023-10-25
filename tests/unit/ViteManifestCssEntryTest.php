<?php

use Idleberg\ViteManifest\Manifest;

class ViteManifestCssEntryTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $vm;
    protected $baseUrl = __DIR__ . "/../_data/";
    protected $manifest = __DIR__ . "/../_data/manifest-css-entry.json";

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
        $expected = json_decode('{"src/main.css":{"file": "assets/main-deadbeef.css","isEntry": true,"src": "src/main.css"}}', true);

        $this->assertEquals($actual, $expected);
    }

    public function testGetStyles()
    {
        $this->assertEquals(count($this->vm->getStyles("src/main.css")), 1);
    }
}
