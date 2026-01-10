<?php

use Idleberg\ViteManifest\Manifest;

class ViteManifestErrorHandlingTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    protected $baseUrl = 'file://' . __DIR__ . '/../_data/';
    protected $manifest = __DIR__ . "/../_data/manifest.json";

    public function testThrowsExceptionForNonExistentManifest()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Manifest file does not exist");

        new Manifest("/non/existent/manifest.json", $this->baseUrl);
    }

    public function testThrowsExceptionForInvalidBaseUri()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid base URI");

        new Manifest($this->manifest, "not a valid uri ://");
    }

    public function testThrowsExceptionForInvalidAlgorithm()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Unsupported hashing algorithm");

        new Manifest($this->manifest, $this->baseUrl, "md5");
    }

    public function testThrowsExceptionForInvalidJson()
    {
        $invalidJsonFile = __DIR__ . "/../_data/invalid.json";
        file_put_contents($invalidJsonFile, "{ invalid json }");

        try {
            $this->expectException(\RuntimeException::class);
            $this->expectExceptionMessage("Failed to parse manifest JSON");

            new Manifest($invalidJsonFile, $this->baseUrl);
        } finally {
            unlink($invalidJsonFile);
        }
    }

    public function testThrowsExceptionWhenManifestAlgorithmButIntegrityMissing()
    {
        $vm = new Manifest($this->manifest, $this->baseUrl, ":manifest:");

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("missing 'integrity' field");

        // This manifest doesn't have integrity fields, so it should throw
        $vm->getEntrypoint('demo.ts');
    }
}
