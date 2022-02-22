<?php
namespace Test;

class ViteManifestTest extends \Codeception\Test\Unit
{
    private string $manifestPath;
    private string $baseUri;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $vm = new ViteManifest($this->$manifestPath, $this->baseUri);
    }
}
