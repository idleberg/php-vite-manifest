<?php

use Idleberg\ViteManifest\Manifest;

class ViteManifestSriTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $vm;
    protected $baseUrl = 'file://' . __DIR__ . '/../_data/';
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
        $expected = json_decode('{"demo.ts":{"file":"assets/index.deadbeef.js","src":"demo.ts","isEntry":true,"integrity":"sha256-hK5PvH3PaGbMYq5EuedyA6F5uVkfoEwAznLNThffuZ8="},"demo.sha256.ts":{"file":"assets/index.deadbeef.js","src":"demo.sha256.ts","isEntry":true,"integrity":"sha256-hK5PvH3PaGbMYq5EuedyA6F5uVkfoEwAznLNThffuZ8="},"demo.sha384.ts":{"file":"assets/index.deadbeef.js","src":"demo.sha384.ts","isEntry":true,"integrity":"sha384-fWetO954Htoz6cSa6ZLx231UagP8VTXlwaO1g/JisfA9TLZnHPlgPBUwsqrWHjg0"},"demo.sha512.ts":{"file":"assets/index.deadbeef.js","src":"demo.sha512.ts","isEntry":true,"integrity":"sha512-yD2Vb8LCDxC5ingFUTEa50J7EaqoK4xJzwimk2+7PPM9jczPfTDHngkduhYar/pz4dCW7qWIhm0fXFDXm1lL/A=="}}', true);

        $this->assertEquals($actual, $expected);
    }

    public function testGetEntryPoint()
    {
        $entrypoint = $this->vm->getEntrypoint('demo.ts');
        ["url" => $url, "hash" => $hash] = $entrypoint;

        $this->assertFileExists($url);
        $this->assertEquals($hash, "sha256-hK5PvH3PaGbMYq5EuedyA6F5uVkfoEwAznLNThffuZ8=");
    }

    public function testGetEntryPointSHA256()
    {
        $entrypoint = $this->vm->getEntrypoint('demo.sha256.ts');
        ["url" => $url, "hash" => $hash] = $entrypoint;

        $this->assertFileExists($url);
        $this->assertEquals($hash, "sha256-hK5PvH3PaGbMYq5EuedyA6F5uVkfoEwAznLNThffuZ8=");
    }

    public function testGetEntryPointSHA384()
    {
        $entrypoint = $this->vm->getEntrypoint('demo.sha384.ts');
        ["url" => $url, "hash" => $hash] = $entrypoint;

        $this->assertFileExists($url);
        $this->assertEquals($hash, "sha384-fWetO954Htoz6cSa6ZLx231UagP8VTXlwaO1g/JisfA9TLZnHPlgPBUwsqrWHjg0");
    }

    public function testGetEntryPointSHA512()
    {
        $entrypoint = $this->vm->getEntrypoint('demo.sha512.ts');
        ["url" => $url, "hash" => $hash] = $entrypoint;

        $this->assertFileExists($url);
        $this->assertEquals($hash, "sha512-yD2Vb8LCDxC5ingFUTEa50J7EaqoK4xJzwimk2+7PPM9jczPfTDHngkduhYar/pz4dCW7qWIhm0fXFDXm1lL/A==");
    }
}
