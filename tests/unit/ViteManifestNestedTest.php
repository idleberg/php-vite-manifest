<?php

use Idleberg\ViteManifest\Manifest;

class ViteManifestNestedTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $vm;
    protected $baseUrl = 'https://example.com/';
    protected $manifest = __DIR__ . "/../_data/manifest-nested.json";

    protected function _before()
    {
        $this->vm = new Manifest($this->manifest, $this->baseUrl);
    }

    // tests
    public function testGetImportsRecursively()
    {
        $actual = array_map(fn($item) => $item["url"], $this->vm->getImports("demo.ts", false));
        $expected = [
            "https://example.com/assets/shared.deadbeef.js",
            "https://example.com/assets/vendor.deadbeef.js"
        ];

        $this->assertSame($expected, $actual);
    }

    public function testGetEntrypointWithoutFile()
    {
        $this->assertSame([], $this->vm->getEntrypoint("_missing.js", false));
    }

    public function testGetStylesRecursively()
    {
        $actual = array_map(fn($item) => $item["url"], $this->vm->getStyles("demo.ts", false));
        $expected = [
            "https://example.com/assets/index.deadbeef.css",
            "https://example.com/assets/shared.deadbeef.css"
        ];

        $this->assertSame($expected, $actual);
    }
}
