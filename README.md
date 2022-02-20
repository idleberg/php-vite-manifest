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

["url" => $url, "hash" => $hash] = $entrypoint;
echo "<script type=\"module\" src=\"$url\" crossorigin integrity=\"$hash\"></script>" . PHP_EOL;
```
</details>

#### `getImports()`

Usage: `getImports(fileName)`

Returns imports from the manifest

<details>
<summary><strong>Example</strong></summary>

```php
foreach ($vm->getImports("index.ts") as $import) {
    ["url" => $url] = $entrypoint;
    echo "<link rel=\"modulepreload\" href=\"{$import['url']}\" />" . PHP_EOL;
}
```
</details>

## License

This work is licensed under [The MIT License](LICENSE)
