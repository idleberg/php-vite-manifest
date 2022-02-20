# Vite Manifest

> A parser for [Vite](https://vitejs.dev/) v2 manifest files

[![Packagist](https://flat.badgen.net/packagist/license/idleberg/vite-manifest)](https://packagist.org/packages/idleberg/vite-manifest)
[![Packagist](https://flat.badgen.net/packagist/v/idleberg/vite-manifest)](https://packagist.org/packages/idleberg/vite-manifest)

## Installation

`composer require idleberg/vite-manifest`

## Usage

```php
use Idleberg\ViteManifest\ViteManifest;

$vm = new ViteManifest("patch/to/manifest.json");

// Output script tags for entrypoints
$entrypoint = $vm->getEntrypoint("index.ts");
["url" => $url, "hash" => $hash] = $entrypoint;
echo "<script type='module' src='$url' crossorigin integrity='$hash'></script>" . PHP_EOL;

// Output preload tags for imports in entrypoints
foreach ($vm->getImports("index.ts") as $import) {
    ["url" => $url] = $import;
    echo "<link rel='modulepreload' href='$url' />" . PHP_EOL;
}
```

### Methods

#### `getManifest`

Usage: `getManifest()`

Returns the contents of the manifest file as a PHP array

#### `getEntrypoint`

Usage: `getEntrypoint(string $fileName)`

Returns the entrypoint from the manifest

#### `getImports`

Usage: `getImports(string $fileName)`

Returns imports for a file listed in the manifest

## License

This work is licensed under [The MIT License](LICENSE)
