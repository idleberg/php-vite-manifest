<?php

use Idleberg\ViteManifest\Manifest;

class ViteManifestEmptyCssTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $vm;
    protected $baseUrl = 'file://' . __DIR__ . '/../_data/';
    protected $manifest = __DIR__ . "/../_data/manifest-empty-css.json";

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
        $expected = json_decode('{"demo.ts":{"file":"assets/index.deadbeef.js","src":"demo.ts","isEntry":true,"imports":["vendor.deadbeef.js"],"css":[]},"vendor.deadbeef.js":{"file":"assets/vendor.deadbeef.js"}}', true);

        $this->assertEquals($actual, $expected);
    }

    public function testGetStyles()
    {
        $this->assertEquals(count($this->vm->getStyles("demo.ts")), 0);
    }
}
