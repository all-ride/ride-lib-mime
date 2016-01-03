<?php

namespace ride\library\mime\sniffer;

use \PHPUnit_Framework_TestCase;

abstract class AbstractMimeSnifferTest extends PHPUnit_Framework_TestCase {

    abstract protected function getMimeSniffer();

    /**
     * @dataProvider providerGetMediaTypeForFile
     */
    public function testGetMediaTypeForFile($expected, $file) {
        $mimeSniffer = $this->getMimeSniffer();

        $result = $mimeSniffer->getMediaTypeForFile($file);

        $this->assertEquals($expected, $result);
    }

    public function providerGetMediaTypeForFile() {
        return array(
            array('image/jpeg', __DIR__ . '/../../../../../data/lake.jpg'),
            array('text/x-php', __DIR__ . '/../../../../../data/test.pdf'),
        );
    }

    /**
     * @dataProvider providerGetMediaTypeForString
     */
    public function testGetMediaTypeForString($expected, $string) {
        $mimeSniffer = $this->getMimeSniffer();

        $result = $mimeSniffer->getMediaTypeForString($string);

        $this->assertEquals($expected, $result);
    }

    public function providerGetMediaTypeForString() {
        return array(
            array('text/x-php', "<?php\n\nphpinfo();"),
        );
    }

}
