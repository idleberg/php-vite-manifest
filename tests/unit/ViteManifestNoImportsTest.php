<?php

use Idleberg\ViteManifest\ViteManifest;

class ViteManifestNoImportsTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $vm;
    protected $baseUrl = __DIR__ . "/../_data/";
    protected $manifest = __DIR__ . "/../_data/manifest-no-imports.json";

    protected function _before()
    {
        $this->vm = new ViteManifest($this->manifest, $this->baseUrl);
    }

    protected function _after()
    {
        // The void
    }

    // tests
    public function testGetManifest()
    {
        $actual = $this->vm->getManifest();
        $expected = json_decode('{"demo.ts":{"file":"assets/index.deadbeef.js","src":"demo.ts","isEntry":true,"css":["assets/index.deadbeef.css"]}}', true);

        $this->assertEquals($actual, $expected);
    }

    public function testGetImports()
    {
        foreach ($this->vm->getImports("demo.ts") as $import) {
            ["url" => $url, "hash" => $hash] = $import;

            $this->assertFileExists($url);
            $this->assertEquals($hash, "sha256-8RzdE7SNBGNNmh0BI4cXwi/dIsuCh4RPQQQSNePuVLw=");
        }
    }

    public function testGetImportsSHA256()
    {
        $vm = new ViteManifest($this->manifest, $this->baseUrl, "sha256");

        foreach ($vm->getImports("demo.ts") as $import) {
            ["url" => $url, "hash" => $hash] = $import;

            $this->assertFileExists($url);
            $this->assertEquals($hash, "sha256-8RzdE7SNBGNNmh0BI4cXwi/dIsuCh4RPQQQSNePuVLw=");
        }
    }

    public function testGetImportsSHA384()
    {
        $vm = new ViteManifest($this->manifest, $this->baseUrl, "sha384");

        foreach ($vm->getImports("demo.ts") as $import) {
            ["url" => $url, "hash" => $hash] = $import;

            $this->assertFileExists($url);
            $this->assertEquals($hash, "sha384-9NvRVHsuKY6wwJRWKjFH7zAhjtPFZtPobj1WB8vn5fSXQYZHS2/0FlrRPaayTPB+");
        }
    }

    public function testGetImportsSHA512()
    {
        $vm = new ViteManifest($this->manifest, $this->baseUrl, "sha512");

        foreach ($vm->getImports("demo.ts") as $import) {
            ["url" => $url, "hash" => $hash] = $import;

            $this->assertFileExists($url);
            $this->assertEquals($hash, "sha512-oomLNbDk3bd3YkrFYnnCMe1Y6j8NhPTRLSOvAPIUL6FfEIqE3LkRWISlxXKcAQhfUoaH2M8vQm6oJ9kR0AXi5g==");
        }
    }

    public function testGetImportsWithoutHash()
    {
        foreach ($this->vm->getImports("demo.ts", false) as $import) {
            ["url" => $url, "hash" => $hash] = $import;

            $this->assertFileExists($url);
            $this->assertEquals($hash, null);
        }
    }
}
