<?php

use Idleberg\ViteManifest\Manifest;

class ViteManifestTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $vm;
    protected $baseUrl = 'file://' . __DIR__ . '/../_data/';
    protected $manifest = __DIR__ . "/../_data/manifest.json";

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
        $expected = json_decode('{"demo.ts":{"file":"assets/index.deadbeef.js","src":"demo.ts","isEntry":true,"imports":["vendor.deadbeef.js"],"css":["assets/index.deadbeef.css"]},"vendor.deadbeef.js":{"file":"assets/vendor.deadbeef.js"}}', true);

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
        $vm = new Manifest($this->manifest, $this->baseUrl, "sha256");

        $entrypoint = $vm->getEntrypoint('demo.ts');
        ["url" => $url, "hash" => $hash] = $entrypoint;

        $this->assertFileExists($url);
        $this->assertEquals($hash, "sha256-hK5PvH3PaGbMYq5EuedyA6F5uVkfoEwAznLNThffuZ8=");
    }

    public function testGetEntryPointSHA384()
    {
        $vm = new Manifest($this->manifest, $this->baseUrl, "sha384");

        $entrypoint = $vm->getEntrypoint('demo.ts');
        ["url" => $url, "hash" => $hash] = $entrypoint;

        $this->assertFileExists($url);
        $this->assertEquals($hash, "sha384-fWetO954Htoz6cSa6ZLx231UagP8VTXlwaO1g/JisfA9TLZnHPlgPBUwsqrWHjg0");
    }

    public function testGetEntryPointSHA512()
    {
        $vm = new Manifest($this->manifest, $this->baseUrl, "sha512");

        $entrypoint = $vm->getEntrypoint('demo.ts');
        ["url" => $url, "hash" => $hash] = $entrypoint;

        $this->assertFileExists($url);
        $this->assertEquals($hash, "sha512-yD2Vb8LCDxC5ingFUTEa50J7EaqoK4xJzwimk2+7PPM9jczPfTDHngkduhYar/pz4dCW7qWIhm0fXFDXm1lL/A==");
    }

    public function testGetEntryPointWithoutHash()
    {
        $entrypoint = $this->vm->getEntrypoint('demo.ts', false);
        ["url" => $url, "hash" => $hash] = $entrypoint;

        $this->assertFileExists($url);
        $this->assertEquals($hash, null);
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
        $vm = new Manifest($this->manifest, $this->baseUrl, "sha256");

        foreach ($vm->getImports("demo.ts") as $import) {
            ["url" => $url, "hash" => $hash] = $import;

            $this->assertFileExists($url);
            $this->assertEquals($hash, "sha256-8RzdE7SNBGNNmh0BI4cXwi/dIsuCh4RPQQQSNePuVLw=");
        }
    }

    public function testGetImportsSHA384()
    {
        $vm = new Manifest($this->manifest, $this->baseUrl, "sha384");

        foreach ($vm->getImports("demo.ts") as $import) {
            ["url" => $url, "hash" => $hash] = $import;

            $this->assertFileExists($url);
            $this->assertEquals($hash, "sha384-9NvRVHsuKY6wwJRWKjFH7zAhjtPFZtPobj1WB8vn5fSXQYZHS2/0FlrRPaayTPB+");
        }
    }

    public function testGetImportsSHA512()
    {
        $vm = new Manifest($this->manifest, $this->baseUrl, "sha512");

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

    public function testGetStyles()
    {
        foreach ($this->vm->getStyles("demo.ts") as $style) {
            ["url" => $url, "hash" => $hash] = $style;

            $this->assertFileExists($url);
            $this->assertEquals($hash, "sha256-EEEKapOxnF8qZUxsx0ksgdBVnEB+8dXUJvH75TwCWvU=");
        }
    }

    public function testGetStylesSHA256()
    {
        $vm = new Manifest($this->manifest, $this->baseUrl, "sha256");

        foreach ($vm->getStyles("demo.ts") as $style) {
            ["url" => $url, "hash" => $hash] = $style;

            $this->assertFileExists($url);
            $this->assertEquals($hash, "sha256-EEEKapOxnF8qZUxsx0ksgdBVnEB+8dXUJvH75TwCWvU=");
        }
    }

    public function testGetStylesSHA384()
    {
        $vm = new Manifest($this->manifest, $this->baseUrl, "sha384");

        foreach ($vm->getStyles("demo.ts") as $style) {
            ["url" => $url, "hash" => $hash] = $style;

            $this->assertFileExists($url);
            $this->assertEquals($hash, "sha384-hRJLv1qN+U3dkKJIw8ANFbwPS/ED0NHZfZU96sK3vRe3evsIbIxjnkoFcJeryuVC");
        }
    }

    public function testGetStylesSHA512()
    {
        $vm = new Manifest($this->manifest, $this->baseUrl, "sha512");

        foreach ($vm->getStyles("demo.ts") as $style) {
            ["url" => $url, "hash" => $hash] = $style;

            $this->assertFileExists($url);
            $this->assertEquals($hash, "sha512-vmI3y876ZfoogL2eJuRJy4ToOnrfwPVE7T9yMlhJp5lpSGHZ3ejDNqd7A0QYFlk0/SOugOwB1x0FCWqO95pz4Q==");
        }
    }

    public function testGetStylesWithoutHash()
    {
        foreach ($this->vm->getStyles("demo.ts", false) as $style) {
            ["url" => $url, "hash" => $hash] = $style;

            $this->assertFileExists($url);
            $this->assertEquals($hash, null);
        }
    }
}
