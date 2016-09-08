# Ride: MIME Library

Library of the PHP Ride framework to work with MIME media types.

## Code Sample

```php
<?php

use ride\library\mime\sniffer\FinfoMimeSniffer;
use ride\library\mime\MimeFactory;

use ride\service\MimeService;

// create needed instances
$mimeFactory = new MimeFactory();
$mimeTypes = $mimeFactory->createMimeTypesFromFile('/etc/mime.types');
$mimeSniffer = new FinfoMimeSniffer();

// let's put them together in the MimeService
$mimeService = new MimeService($mimeFactory, $mimeTypes, $mimeSniffer);

// create an instance of a media type string
$mediaType = $mimeService->getMediaType('image/svg+xml');
$mediaType->isImage(); // true
$mediaType->isVideo(); // false
$mediaType->getType(); // image
$mediaType->getSubtype(); // svg+xml
$mediaType->getSuffix(); // xml

// let's try a more advanced media type string
$mediaType = $mimeService->getMediaType('application/vnd.api+json; ext="ext1,ext2"; supported-ext="ext1,ext2');
$mediaType->getType(); // application
$mediaType->getSubtype(); // vnd.api+json
$mediaType->getTree(); // vnd
$mediaType->getSuffix(); // json
$mediaType->getMimeType(); // application/vnd.api+json
$mediaType->getParameter('ext'); // ext1,ext2
$mediaType->getParameter('supported-ext'); // ext1,ext2
$mediaType->getParameter('foo'); // null
$mediaType->getParameter('bar', 'default'); // default

// detect the media type of a file
$mediaType = $mimeService->getMediaTypeForFile('/path/to/image.png');
$mediaType->isImage(); // true
$mediaType->getType(); // image
$mediaType->getSubtype(); // png
(string) $mediaType; // image/png

// detect the media type of file contents
$mediaType = $mimeService->getMediaTypeForString("<?php\n\nphpinfo();");
$mediaType->isImage(); // false
$mediaType->isText(); // true
$mediaType->getType(); // text
$mediaType->getSubtype(); // x-php
(string) $mediaType; // text/x-php

```

## Installation

You can use [Composer](http://getcomposer.org) to install this library.

```
composer require ride/lib-mime
```
