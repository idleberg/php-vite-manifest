<?php

use Idleberg\ViteManifest\Manifest;

class ViteManifestSriTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $vm;
    protected $baseUrl = __DIR__ . "/../_data/";
    protected $manifest = __DIR__ . "/../_data/manifest-sri.json";

    protected function _before()
    {
        $this->vm = new Manifest($this->manifest, $this->baseUrl, ":manifest:");
    }

    protected function _after()
    {
        // The void
    }

    // tests
    public function testGetManifest()
    {
        $actual = $this->vm->getManifest();
        $expected = json_decode('{"demo.ts":{"file":"assets/index.deadbeef.js","src":"demo.ts","isEntry":true,"integrity":"sha256-hK5PvH3PaGbMYq5EuedyA6F5uVkfoEwAznLNThffuZ8="}}', true);

        $this->assertEquals($actual, $expected);
    }

    public function testGetEntryPoint()
    {
        $entrypoint = $this->vm->getEntrypoint('demo.ts');
        ["url" => $url, "hash" => $hash] = $entrypoint;

        $this->assertFileExists($url);
        $this->assertEquals($hash, "sha256-hK5PvH3PaGbMYq5EuedyA6F5uVkfoEwAznLNThffuZ8=");
    }
}
