# yii2 PDF version converter 
PHP library for converting the version of PDF files (for compatibility purposes).

## Requirements

- PHP 5.3+
- Ghostscript (gs command on Linux or iis/windows)

## Installation

Run `php composer.phar require wimrademaker/pdf-version-converter dev-master` or add the follow lines to composer and run `composer install`:

```
{
    "require": {
        "wimrademaker/pdf-version-converter": "dev-master"
    }
}
```

## Usage

Guessing a version of PDF File:

```php
<?php
// import the namespaces
use wimrademaker\PDFVersionConverter\Guesser\RegexGuesser;
// [..]

$guesser = new RegexGuesser();
echo $guesser->guess('/path/to/my/file.pdf'); // will print something like '1.4'
```

Converting file to a new PDF version:

```php
<?php
// import the namespaces
use wimrademaker\PDFVersionConverter\Converter\GhostscriptConverterCommand,
    wimrademaker\PDFVersionConverter\Converter\GhostscriptConverter
;

// [..]

$command = new GhostscriptConverterCommand();
$filesystem = new Filesystem();

$converter = new GhostscriptConverter($command, $filesystem);
$converter->convert('/path/to/my/file.pdf', '1.4');
```

## This script is based on the PDF version converter used in symfony from xthiago 
The symfony implementation can be found here https://github.com/xthiago/pdf-version-converter
