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
        $baseUrl = __DIR__ . "/../_data/";
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

    public function testGetEntryPoint()
    {
        $entrypoint = $this->vm->getEntrypoint('demo.ts');
        ["url" => $url, "hash" => $hash] = $entrypoint;

        $this->assertFileExists($url);
        $this->assertEquals($hash, "sha256-hK5PvH3PaGbMYq5EuedyA6F5uVkfoEwAznLNThffuZ8=");
    }

    public function testGetImports()
    {
        foreach ($this->vm->getImports("demo.ts") as $import) {
            ["url" => $url] = $import;

            $this->assertFileExists($url);
        }
    }

    public function testGetStyles()
    {
        foreach ($this->vm->getStyles("demo.ts") as $style) {
            ["url" => $url, "hash" => $hash] = $style;

            $this->assertFileExists($url);
            $this->assertEquals($hash, "sha256-EEEKapOxnF8qZUxsx0ksgdBVnEB+8dXUJvH75TwCWvU=");
        }
    }
}
