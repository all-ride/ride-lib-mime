# Ride: MIME Library

Library of the PHP Ride framework to work with MIME media types.

## Code Sample

```php
<?php

use ride\library\mime\sniffer\FinfoMimeSniffer;
use ride\library\mime\MimeFactory;

use ride\service\MimeService;

$mimeFactory = new MimeFactory();
$mimeTypes = $mimeFactory->createMimeTypesFromFile('/etc/mime.types');
$mimeSniffer = new FinfoMimeSniffer();
$mimeService = new MimeService($mimeFactory, $mimeTypes, $mimeSniffer);

$mediaType = $mimeService->getMediaType('image/svg+xml');
$mediaType->isImage(); // true
$mediaType->isVideo(); // false
$mediaType->getType(); // image
$mediaType->getSubtype(); // svg+xml
$mediaType->getSuffix(); // xml

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

$mediaType = $mimeService->getMediaTypeForFile('/path/to/image.png');
$mediaType->isImage(); // true
$mediaType->getType(); // image
$mediaType->getSubtype(); // png
(string) $mediaType; // image/png

$mediaType = $mimeService->getMediaTypeForString("<?php\n\nphpinfo();");
$mediaType->isImage(); // false
$mediaType->isText(); // true
$mediaType->getType(); // text
$mediaType->getSubtype(); // x-php
(string) $mediaType; // text/x-php


```
