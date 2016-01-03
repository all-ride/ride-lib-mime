<?php

namespace ride\library\mime;

use \PHPUnit_Framework_TestCase;

class MimeFactoryTest extends PHPUnit_Framework_TestCase {

    public function testCreateMimeTypesFromString() {
        $mimeFactory = new MimeFactory();

        $mimeTypes = $mimeFactory->createMimeTypesFromString(
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
        $mimeFactory = new MimeFactory();

        $result = $mimeFactory->createMediaTypeFromString($expected);

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
