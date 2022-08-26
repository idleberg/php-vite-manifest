<?php

use Idleberg\ViteManifest\ViteManifest;

class ViteManifestNoCssTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $vm;
    protected $baseUrl = __DIR__ . "/../_data/";
    protected $manifest = __DIR__ . "/../_data/manifest-no-css.json";

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
        $expected = json_decode('{"demo.ts":{"file":"assets/index.deadbeef.js","src":"demo.ts","isEntry":true,"imports":["vendor.deadbeef.js"]},"vendor.deadbeef.js":{"file":"assets/vendor.deadbeef.js"}}', true);

        $this->assertEquals($actual, $expected);
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
        $vm = new ViteManifest($this->manifest, $this->baseUrl, "sha256");

        foreach ($vm->getStyles("demo.ts") as $style) {
            ["url" => $url, "hash" => $hash] = $style;

            $this->assertFileExists($url);
            $this->assertEquals($hash, "sha256-EEEKapOxnF8qZUxsx0ksgdBVnEB+8dXUJvH75TwCWvU=");
        }
    }

    public function testGetStylesSHA384()
    {
        $vm = new ViteManifest($this->manifest, $this->baseUrl, "sha384");

        foreach ($vm->getStyles("demo.ts") as $style) {
            ["url" => $url, "hash" => $hash] = $style;

            $this->assertFileExists($url);
            $this->assertEquals($hash, "sha384-hRJLv1qN+U3dkKJIw8ANFbwPS/ED0NHZfZU96sK3vRe3evsIbIxjnkoFcJeryuVC");
        }
    }

    public function testGetStylesSHA512()
    {
        $vm = new ViteManifest($this->manifest, $this->baseUrl, "sha512");

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
