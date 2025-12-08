<?php

use Idleberg\ViteManifest\Manifest;

class ViteManifestEntrypointsTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $vm;
    protected $baseUrl = 'file://' . __DIR__ . '/../_data/';

    // tests
    public function testEntrypoints()
    {
        $manifest = __DIR__ . "/../_data/manifest-entrypoints.json";
        $vm = new Manifest($manifest, $this->baseUrl);

        $actual = count($vm->getEntrypoints());
        $expected = 1;

        $this->assertEquals($actual, $expected);
    }

    public function testNoEntrypoints()
    {
        $manifest = __DIR__ . "/../_data/manifest-no-entrypoints.json";
        $vm = new Manifest($manifest, $this->baseUrl);

        $actual = count($vm->getEntrypoints());
        $expected = 0;

        $this->assertEquals($actual, $expected);
    }
}
