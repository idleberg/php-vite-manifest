# Vite Manifest

> A parser for [Vite](https://bandcamp.com/developer) v2 manifest files

[![Packagist](https://flat.badgen.net/packagist/license/idleberg/vite-manifest)](https://www.npmjs.org/package/idleberg/vite-manifest)
[![Packagist](https://flat.badgen.net/packagist/v/idleberg/vite-manifest)](https://www.npmjs.org/package/idleberg/vite-manifest)

## Installation

`composer require idleberg/vite-manifest`

## Usage

Import and initialize the Bandcamp module

```php
use Idleberg\ViteManifest\ViteManifest;

$vm = new ViteManifest(
    "patch/to/manifest.json"
)
```

### Methods

#### `getManifest()`

Usage: `getManifest()`

Returns the contents of the manifest file as a PHP array

#### `getEntrypoint()`

Usage: `getEntrypoint(fileName)`

Returns the entrypoint from the manifest

<details>
<summary><strong>Example</strong></summary>

```php
$entrypoint = $vm->getEntrypoint("index.ts");

echo "<script type=\"module\" src=\"{$entrypoint['url']}\" crossorigin integrity=\"{$entrypoint['hash']}\"></script>";
```

</details>

#### `getImports()`

Usage: `getImports(fileName)`

Returns imports from the manifest

<details>
<summary><strong>Example</strong></summary>

```php
foreach ($vm->getImports("index.ts") as $import) {
   echo "<link rel=\"modulepreload\" href=\"{$import['url']}\" />";
}
```

## License

This work is licensed under [The MIT License](LICENSE)
