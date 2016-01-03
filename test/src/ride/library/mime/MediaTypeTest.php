<?php

namespace ride\library\mime;

use \PHPUnit_Framework_TestCase;

class MediaTypeTest extends PHPUnit_Framework_TestCase {

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

}
