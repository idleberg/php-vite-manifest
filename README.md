# Vite Manifest

> A parser for [Vite](https://vitejs.dev/) v2 manifest files

[![Packagist](https://flat.badgen.net/packagist/license/idleberg/vite-manifest)](https://packagist.org/packages/idleberg/vite-manifest)
[![Packagist](https://flat.badgen.net/packagist/v/idleberg/vite-manifest)](https://packagist.org/packages/idleberg/vite-manifest)
[![Packagist](https://flat.badgen.net/packagist/php/idleberg/vite-manifest)](https://packagist.org/packages/idleberg/vite-manifest)
[![CI](https://img.shields.io/github/actions/workflow/status/idleberg/php-vite-manifest/default.yml?style=flat-square)](https://github.com/idleberg/php-vite-manifest/actions)

**Table of contents**

- [Installation](#installation)
- [Usage](#usage)
- [Methods](#methods)
  - [`getManifest()`](#getmanifest)
  - [`getEntrypoint()`](#getentrypoint)
  - [`getImports()`](#getimports)
  - [`getStyles()`](#getstyles)
- [License](#license)

## Installation

`composer require idleberg/vite-manifest`

## Usage

To get you going, first instantiate the class exposed by this library

```php
new ViteManifest(string $manifestPath, string $baseUri, string $algorithm = "sha256");
```

**Example**

```php
use Idleberg\ViteManifest\ViteManifest;

$baseUrl = "https://idleberg.github.io";
$manifest = "path/to/manifest.json";

$vm = new ViteManifest($manifest, $baseUrl);
```

### Methods

#### `getManifest()`

Usage: `getManifest()`

Returns the contents of the manifest file as a PHP array

#### `getEntrypoint()`

Usage: `getEntrypoint(string $entrypoint, bool $hash = true)`

**Example**

```php
$entrypoint = $vm->getEntrypoint("index.ts");

if ($entrypoint) {
    ["url" => $url, "hash" => $hash] = $entrypoint;
    echo "<script type='module' src='$url' crossorigin integrity='$hash'></script>" . PHP_EOL;
}
```

Returns the entrypoint from the manifest

#### `getImports()`

Usage: `getImports(string $entrypoint, bool $hash = true)`

Returns imports for a file listed in the manifest

**Example**

```php
foreach ($vm->getImports("index.ts") as $import) {
    ["url" => $url] = $import;
    echo "<link rel='modulepreload' href='$url' />" . PHP_EOL;
}
```

#### `getStyles()`

Usage: `getStyles(string $entrypoint, bool $hash = true)`

Returns stylesheets for a file listed in the manifest

**Example**

```php
foreach ($vm->getStyles("index.ts") as $style) {
    ["url" => $url, "hash" => $hash] = $style;
    echo "<link rel='stylesheet' href='$url' crossorigin integrity='$hash' />" . PHP_EOL;
}
```

## License

This work is licensed under [The MIT License](LICENSE)
