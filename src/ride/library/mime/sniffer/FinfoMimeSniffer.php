<?php

namespace ride\library\mime\sniffer;

use ride\library\mime\exception\MimeException;

/**
 * Fileinfo implementation of a MIME sniffer
 */
class FinfoMimeSniffer implements MimeSniffer {

    /**
     * Constructs a new MIME sniffer
     */
    public function __construct() {
        if (!function_exists('finfo_open')) {
            throw new MimeException('Could not create the Fileinfo MIME Sniffer: finfo_ functions are not available');
        }

        $this->finfo = finfo_open(FILEINFO_MIME_TYPE);
    }

    /**
     * Destructs the MIME sniffer
     */
    public function __descruct() {
        finfo_close($this->finfo);
    }

    /**
     * Gets the media type for the provided file
     * @param string $file Path to the file
     * @return string
     */
    public function getMediaTypeForFile($file) {
        return finfo_file($this->finfo, $file);
    }

    /**
     * Gets the media type for the provided string
     * @param string $string Contents of a file
     * @return string
     */
    public function getMediaTypeForString($string) {
        return finfo_buffer($this->finfo, $string);
    }

}
