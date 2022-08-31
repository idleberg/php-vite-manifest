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

use League\Uri\Http;
use League\Uri\UriResolver;

class ViteManifest
{
    private array $manifest;
    private string $baseUri;
    private string $algorithm;

    public function __construct(string $manifestFile, string $baseUri, string $algorithm = "sha256")
    {
        if (!file_exists(realpath($manifestFile))) {
            throw new \Exception("Manifest file does not exist: $manifestFile");
        }

        try {
            $this->manifest = json_decode(
                file_get_contents($manifestFile),
                true
            );
        } catch (\Throwable $errorMessage) {
            throw new \Exception("Failed loading manifest: $errorMessage");
        }

        if (!parse_url($baseUri)) {
            throw new \Exception("Failed to parse URL: $baseUri");
        }

        $this->baseUri = $baseUri;

        if (!in_array($algorithm, ["sha256", "sha384", "sha512"])) {
            throw new \Exception("Unsupported hashing algorithm: $algorithm");
        }

        $this->algorithm = $algorithm;
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
     * @param string $entrypoint
     * @param bool $hash
     * @return array
     */
    public function getEntrypoint(string $entrypoint, bool $hash = true): array
    {
        return isset($this->manifest[$entrypoint]) ? [
            "hash" => $hash ? $this->getFileHash($this->manifest[$entrypoint]["file"]) : null,
            "url"  => $this->getPath($this->manifest[$entrypoint]["file"])
        ] : [];
    }

    /**
     * Returns imports for a file listed in the manifest
     *
     * @param string $entrypoint
     * @param bool $hash
     * @return array
     */
    public function getImports(string $entrypoint, bool $hash = true): array
    {
        // TODO: Refactor for PHP 8.x
        if (!(isset($this->manifest[$entrypoint]) && isset($this->manifest[$entrypoint]["imports"]) && is_array($this->manifest[$entrypoint]["imports"])))
        {
            return [];
        }

        return array_filter(
            array_map(function ($import, $hash) {
                return isset($this->manifest[$import]["file"]) ? [
                    "hash" => $hash ? $this->getFileHash($this->manifest[$import]["file"]) : null,
                    "url"  => $this->getPath($this->manifest[$import]["file"])
                ] : [];
            }, $this->manifest[$entrypoint]["imports"], [$hash])
        );
    }

    /**
     * Returns stylesheets for a file listed in the manifest
     *
     * @param string $entrypoint
     * @param bool $hash
     * @return array
     */
    public function getStyles(string $entrypoint, bool $hash = true): array
    {
        // TODO: Refactor for PHP 8.x
        if (!(isset($this->manifest[$entrypoint]) && isset($this->manifest[$entrypoint]["css"]) && is_array($this->manifest[$entrypoint]["css"])))
        {
            return [];
        }

        return array_filter(
            array_map(function ($style, $hash) {
                return isset($style) ? [
                    "hash" => $hash ? $this->getFileHash($style) : null,
                    "url"  => $this->getPath($style)
                ] : [];
            }, $this->manifest[$entrypoint]["css"], [$hash])
        );
    }

    /**
     * Returns hash of file
     *
     * @param string $file
     * @return string
     */
    private function getFileHash(string $file): string
    {
        return "{$this->algorithm}-" . base64_encode(
            openssl_digest(
                file_get_contents(
                    $this->getPath($file)
                ),
                $this->algorithm,
                true
            )
        );
    }

    /**
     * Resolves URL for a given file path
     *
     * @param string $relativePath
     * @return string
     */
    private function getPath(string $relativePath): string
    {
        $baseUri = Http::createFromString($this->baseUri);
        $relativeUri = Http::createFromString($relativePath);

        return UriResolver::resolve($relativeUri, $baseUri);
    }
}
