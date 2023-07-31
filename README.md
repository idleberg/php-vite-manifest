# Vite Manifest

> A parser for [Vite](https://vitejs.dev/) v2 manifest files

[![License](https://img.shields.io/packagist/l/idleberg/vite-manifest?style=for-the-badge&color=blue)](https://github.com/idleberg/php-vite-manifest/blob/main/LICENSE)
[![Version](https://img.shields.io/packagist/v/idleberg/vite-manifest?style=for-the-badge)](https://github.com/idleberg/php-vite-manifest/releases)
![PHP Version](https://img.shields.io/packagist/dependency-v/idleberg/vite-manifest/php?style=for-the-badge)
[![Build](https://img.shields.io/github/actions/workflow/status/idleberg/php-vite-manifest/default.yml?style=for-the-badge)](https://github.com/idleberg/php-vite-manifest/actions)

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
new Manifest(string $manifestPath, string $baseUri, string $algorithm = "sha256");
```

**Example**

```php
use Idleberg\ViteManifest\Manifest;

$baseUrl = "https://idleberg.github.io";
$manifest = "path/to/manifest.json";

$vm = new Manifest($manifest, $baseUrl);
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
foreach ($vm->getImports("index.ts", false) as $import) {
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
