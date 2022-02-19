<?php

/**
 * Copyright 2022 Jan T. Sott
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 */

namespace Idleberg\ViteManifest;

use Riimu\Kit\PathJoin\Path;

class ViteManifest
{
    private $manifest;
    protected $basePath;

    public function __construct(string $manifestFile, string $basePath = "")
    {
        if (!file_exists($manifestFile)) {
            throw new \Exception("Manifest file does not exist: {$manifestFile}");
        }

        try {
            $this->manifest = json_decode(
                file_get_contents($manifestFile), true
            );
        } catch (\Throwable $th) {
            throw new \Exception("Failed loading manifest: {$th}");
        }

        if ($basePath && !file_exists($basePath)) {
            throw new \Exception("Base path does not exist: {$basePath}");
        }

        $this->basePath = $basePath;
    }

    /**
     * Returns the contents of the manifest file
     *
     * @return array
     */
    public function getManifest(): array
    {
        return $this->manifest;
    }

    /**
     * Returns the entrypoint from the manifest
     *
     * @param string $entry
     * @return array
     */
    public function getEntrypoint(string $entry): array
    {
        return isset($this->manifest[$entry])
            ? [
                "hash" => $this->getFileHash($this->manifest[$entry]["file"]),
                "url"  => $this->getPath($this->manifest[$entry]["file"])
            ] : "";
    }

    /**
     * Returns imports from the manifest
     *
     * @param string $entry
     * @return array
     */
    public function getImports(string $entry): array
    {
        return array_map(function($imports) {
            return [
                "hash" => $this->getFileHash($this->manifest[$imports]["file"]),
                "url"  => $this->getPath($this->manifest[$imports]["file"])
            ];
        }, $this->manifest[$entry]["imports"]);
    }

    /**
     * Returns SHA-256 hash of file
     *
     * @param string $file
     * @return string
     */
    private function getFileHash(string $file): string
    {
        return "sha256-" . base64_encode(
            openssl_digest(
                file_get_contents(
                   $this->getPath($file)
                ), "sha256", true
            )
        );
    }

    /**
     * Prepends the base path to the given path.
     *
     * @param string $file
     * @return string
     */
    private function getPath(string $file): string {
        return Path::join($this->basePath, $file);
    }
}
