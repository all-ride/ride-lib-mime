<?php

namespace ride\service;

use ride\library\mime\sniffer\FinfoMimeSniffer;
use ride\library\mime\MediaType;
use ride\library\mime\MimeFactory;

use \PHPUnit_Framework_TestCase;

class MimeServiceTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $mimeFactory = new MimeFactory();
        $mimeTypes = $mimeFactory->createMimeTypesFromFile(__DIR__ . '/../../../config/mime.types');
        $mimeSniffer = new FinfoMimeSniffer();

        $this->mimeService = new MimeService($mimeFactory, $mimeTypes, $mimeSniffer);
    }

    public function testGetMediaType() {
        $mediaType = $this->mimeService->getMediaType('text/plain');

        $this->assertTrue($mediaType instanceof MediaType);
        $this->assertEquals('text/plain', $mediaType->getMimeType());
        $this->assertTrue($mediaType === $this->mimeService->getMediaType('text/plain'));
    }

    public function testGetMediaTypeForFile() {
        $mediaType = $this->mimeService->getMediaTypeForFile(__FILE__);

        $this->assertTrue($mediaType instanceof MediaType);
        $this->assertEquals('text/x-php', $mediaType->getMimeType());
    }

    public function testGetMediaTypeForString() {
        $mediaType = $this->mimeService->getMediaTypeForString("<?php\nphpinfo();");

        $this->assertTrue($mediaType instanceof MediaType);
        $this->assertEquals('text/x-php', $mediaType->getMimeType());
    }

    public function testGetMediaTypeForExtension() {
        $mediaType = $this->mimeService->getMediaTypeForExtension('csv');

        $this->assertTrue($mediaType instanceof MediaType);
        $this->assertEquals('text/csv', $mediaType->getMimeType());
    }

    public function testGetExtensionForMediaType() {
        $this->assertEquals('csv', $this->mimeService->getExtensionForMediaType('text/csv'));
    }

}
