<?php

namespace ride\library\mime;

use PHPUnit\Framework\TestCase;

class MimeTypesTest extends TestCase {

    public function testGetExtensionShouldReturnDefaultValue() {
        $mimeTypes = new MimeTypes();

        $this->assertSame('txt', $mimeTypes->getExtension(null, 'txt'));
    }

    public function testSetMediaType() {
        $mimeTypes = new MimeTypes();

        $this->assertEquals(array(), $mimeTypes->getMediaTypes());
        $this->assertEquals(array(), $mimeTypes->getExtensions());

        $mimeTypes->setMediaType('application/word', array('doc', 'docx'));
        $mimeTypes->setMediaType('text/plain', array('txt'));

        $this->assertEquals('text/plain', $mimeTypes->getMediaType('txt'));
        $this->assertEquals('application/word', $mimeTypes->getMediaType('docx'));
        $this->assertEquals('application/word', $mimeTypes->getMediaType('doc'));
        $this->assertEquals(null, $mimeTypes->getMediaType('json'));
        $this->assertEquals('txt', $mimeTypes->getExtension('text/plain'));
        $this->assertEquals('doc', $mimeTypes->getExtension('application/word'));
        $this->assertEquals(array(
                'doc' => 'application/word',
                'docx' => 'application/word',
                'txt' => 'text/plain',
            ),
            $mimeTypes->getExtensions()
        );
        $this->assertEquals(array(
                'application/word' => array(
                    'doc' => 'doc',
                    'docx' => 'docx',
                ),
                'text/plain' => array(
                    'txt' => 'txt',
                ),
            ),
            $mimeTypes->getMediaTypes()
        );
    }

}
