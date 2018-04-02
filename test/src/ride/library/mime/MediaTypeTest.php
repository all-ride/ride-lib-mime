<?php

namespace ride\library\mime;

use PHPUnit\Framework\TestCase;

class MediaTypeTest extends TestCase {

    /**
     * @dataProvider providerToString
     */
    public function testToString($expected, $type, $subtype, $parameters) {
        $mediaType = new MediaType($type, $subtype, $parameters);

        $this->assertEquals($expected, (string) $mediaType);
    }

    public function providerToString() {
        return array(
            array('application/x-rss+xml', 'application', 'x-rss+xml', null),
            array('text/html; charset=UTF-8', 'text', 'html', array('charset' => 'UTF-8')),
            array('text/plain; charset=ISO-8859-1; format=flowed; delsp=yes', 'text', 'plain', array('charset' => 'ISO-8859-1', 'format' => 'flowed', 'delsp' => 'yes')),
            array('text/plain', 'text', 'plain', null),
            array('multipart/byteranges; boundary=""', 'multipart', 'byteranges', array('boundary' => null)),
        );
    }

    /**
     * @dataProvider providerGetSuffix
     */
    public function testGetSuffix($expected, $type, $subtype, $parameters) {
        $mediaType = new MediaType($type, $subtype, $parameters);

        $this->assertEquals($expected, $mediaType->getSuffix());
    }

    public function providerGetSuffix() {
        return array(
            array('xml', 'application', 'x-rss+xml', null),
            array(null, 'text', 'plain', null),
        );
    }

    /**
     * @expectedException ride\library\mime\exception\MimeException
     */
    public function testSetTypeShouldThrowMimeException() {
        $mediaType = new MediaType(1234, 'json');
    }

    public function testGetType() {
        $mediaType = new MediaType('application', 'json');

        $this->assertSame('application', $mediaType->getType());
    }

    public function testGetSubType() {
        $mediaType = new MediaType('application', 'json');

        $this->assertSame('json', $mediaType->getSubtype());
    }

    public function testGetTreeShouldReturnNull() {
        $mediaType = new MediaType('application', 'json');

        $this->assertNull($mediaType->getTree());
    }

    public function testGetTree() {
        $mediaType = new MediaType('application', '*.json');

        $this->assertSame('.json', $mediaType->getTree());
    }

    public function testGetParameters() {
        $mediaType = new MediaType('text', 'html', array('charset' => 'utf-8'));

        $this->assertSame(array('charset' => 'utf-8'), $mediaType->getParameters());
    }

    public function testGetParameterOnNull() {
        $mediaType = new MediaType('text', 'html', array('charset' => 'utf-8'));

        $this->assertNull($mediaType->getParameter('invalid_key'));
    }

    public function testGetParameter() {
        $mediaType = new MediaType('text', 'html', array('charset' => 'utf-8'));

        $this->assertSame('utf-8', $mediaType->getParameter('charset'));
    }

    public function testIsApplicationShouldReturnFalse() {
        $mediaType = new MediaType('text', 'plain');

        $this->assertFalse($mediaType->isApplication());
    }

    public function testIsApplicationShouldReturnTrue() {
        $mediaType = new MediaType('application', 'json');

        $this->assertTrue($mediaType->isApplication());
    }

    public function testIsAudioShouldReturnTrue() {
        $mediaType = new MediaType('audio', 'ogg');

        $this->assertTrue($mediaType->isAudio());
    }

    public function testIsAudioShouldReturnFalse() {
        $mediaType = new MediaType('text', 'html');

        $this->assertFalse($mediaType->isAudio());
    }

    public function testIsExampleShouldReturnFalse() {
        $mediaType = new MediaType('text', 'html');

        $this->assertFalse($mediaType->isExample());
    }

    public function testIsExampleShouldReturntTrue() {
        $mediaType = new MediaType('example', 'html');

        $this->assertTrue($mediaType->isExample());
    }

    public function testIsImageShouldReturnTrue() {
        $mediaType = new MediaType('image', 'png');

        $this->assertTrue($mediaType->isImage());
    }

    public function testIsImageShouldReturnFalse() {
        $mediaType = new MediaType('text', 'plain');

        $this->assertFalse($mediaType->isImage());
    }

    public function testIsMessageShouldReturnTrue() {
        $mediaType = new MediaType('message', 'msg');

        $this->assertTrue($mediaType->isMessage());
    }

    public function testIsMessageShouldReturnFalse() {
        $mediaType = new MediaType('example', 'html');

        $this->assertFalse($mediaType->isMessage());
    }

    public function testIsModelShouldReturnTrue() {
        $mediaType = new MediaType('model', 'msg');

        $this->assertTrue($mediaType->isModel());
    }

    public function testIsModelShouldReturnFalse() {
        $mediaType = new MediaType('example', 'html');

        $this->assertFalse($mediaType->isModel());
    }

    public function testIsMultipartShouldReturnTrue() {
        $mediaType = new MediaType('multipart', 'byteranges');

        $this->assertTrue($mediaType->isMultipart());
    }

    public function testIsMultipartShouldReturnFalse() {
        $mediaType = new MediaType('example', 'html');

        $this->assertFalse($mediaType->isMultipart());
    }

    public function testIsTextShouldReturnTrue() {
        $mediaType = new MediaType('text', 'plain');

        $this->assertTrue($mediaType->isText());
    }

    public function testIsTextShouldReturnFalse() {
        $mediaType = new MediaType('example', 'html');

        $this->assertFalse($mediaType->isText());
    }

    public function testIsVideoShouldReturnTrue() {
        $mediaType = new MediaType('video', 'mp4');

        $this->assertTrue($mediaType->isVideo());
    }

    public function testIsVideoShouldReturnFalse() {
        $mediaType = new MediaType('example', 'html');

        $this->assertFalse($mediaType->isVideo());
    }

}
