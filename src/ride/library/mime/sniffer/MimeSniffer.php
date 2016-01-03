<?php

namespace ride\library\mime\sniffer;

/**
 * Interface for a MIME sniffer
 */
interface MimeSniffer {

    /**
     * Gets the media type for the provided file
     * @param string $file Path to the file
     * @return string
     */
    public function getMediaTypeForFile($file);

    /**
     * Gets the media type for the provided string
     * @param string $string Contents of a file
     * @return string
     */
    public function getMediaTypeForString($string);

}
