<?php

namespace ride\library\mime;

use \PHPUnit_Framework_TestCase;

class MimeFactoryTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->mimeFactory = new MimeFactory();
    }

    public function testCreateMimeTypes() {
        $mimeTypes = $this->mimeFactory->createMimeTypes();

        $this->assertNotNull($mimeTypes);
        $this->assertTrue($mimeTypes instanceof MimeTypes);
    }

    /**
     * @expectedException ride\library\mime\exception\MimeException
     */
    public function testCreateMimeTypesFromFileThrowExceptionWhenInvalidFileProvided() {
        $this->mimeFactory->createMimeTypesFromFile('/my/unexistant/file');
    }

    public function testCreateMimeTypesFromString() {
        $mimeTypes = $this->mimeFactory->createMimeTypesFromString(
"# comment
video/3gpp					3gp
video/annodex axv
video/dv					dif dv
video/mpeg mpeg mpg mpe
        ");

        $this->assertEquals($mimeTypes->getExtensions(), array (
            '3gp' => 'video/3gpp',
            'axv' => 'video/annodex',
            'dif' => 'video/dv',
            'dv' => 'video/dv',
            'mpeg' => 'video/mpeg',
            'mpg' => 'video/mpeg',
            'mpe' => 'video/mpeg',
        ));
        $this->assertEquals($mimeTypes->getMediaTypes(),   array (
            'video/3gpp' =>
            array (
              '3gp' => '3gp',
            ),
            'video/annodex' =>
            array (
              'axv' => 'axv',
            ),
            'video/dv' =>
            array (
              'dif' => 'dif',
              'dv' => 'dv',
            ),
            'video/mpeg' =>
            array (
              'mpeg' => 'mpeg',
              'mpg' => 'mpg',
              'mpe' => 'mpe',
            ),
        ));
    }

    /**
     * @dataProvider providerCreateMediaTypeFromString
     */
    public function testCreateMediaTypeFromString($expected) {
        $result = $this->mimeFactory->createMediaTypeFromString($expected);

        $this->assertTrue($result instanceof MediaType);
        $this->assertEquals($expected, (string) $result);
    }

    public function providerCreateMediaTypeFromString() {
        return array(
            array('application/x-rss+xml'),
            array('text/html; charset=UTF-8'),
            array('text/plain'),
        );
    }

}
