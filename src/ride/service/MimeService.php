<?php

namespace ride\service;

use ride\library\mime\sniffer\MimeSniffer;
use ride\library\mime\MimeFactory;
use ride\library\mime\MimeTypes;

/**
 * Service around the MIME library
 */
class MimeService {

    /**
     * Factory for media types
     * @var \ride\library\mime\MimeFactory
     */
    protected $mimeFactory;

    /**
     * Map for file extensions and media types
     * @var \ride\library\mime\MimeTypes
     */
    protected $mimeTypes;

    /**
     * MIME sniffer for files and strings
     * @var \ride\library\mime\sniffer\MimeSniffer
     */
    protected $mimeSniffer;

    /**
     * Array with detected media types
     * @var array
     */
    protected $mediaTypes;

    /**
     * Constructs the MIME service
     * @param \ride\library\mime\MimeFactory $mimeFactory
     * @param \ride\library\mime\MimeTypes $mimeTypes
     * @param \ride\library\mime\sniffer\MimeSniffer $mimeSniffer
     */
    public function __construct(MimeFactory $mimeFactory, MimeTypes $mimeTypes, MimeSniffer $mimeSniffer) {
        $this->mimeFactory = $mimeFactory;
        $this->mimeTypes = $mimeTypes;
        $this->mimeSniffer = $mimeSniffer;

        $this->mediaTypes = array();
    }

    /**
     * Gets the map of media types and file extensions
     * @return \ride\library\mime\MimeTypes
     */
    public function getMimeTypes() {
        return $this->mimeTypes;
    }

    /**
     * Gets a media type object for the provided media type string
     * @param string $mediaType Media type eg. text/plain
     * @return \ride\library\mime\MediaType|null
     */
    public function getMediaType($mediaType) {
        if (!$mediaType) {
            return null;
        }

        if (isset($this->mediaTypes[$mediaType])) {
            return $this->mediaTypes[$mediaType];
        }

        $this->mediaTypes[$mediaType] = $this->mimeFactory->createMediaTypeFromString($mediaType);

        return $this->mediaTypes[$mediaType];
    }

    /**
     * Gets a media type object for the provided file
     * @param string $file Path to a file
     * @return \ride\library\mime\MediaType|null Media type of the
     * file if detected, null otherwise
     */
    public function getMediaTypeForFile($file) {
        return $this->getMediaType($this->mimeSniffer->getMediaTypeForFile($file));
    }

    /**
     * Gets a media type object for the provided string
     * @param string $string Contents of a file
     * @return \ride\library\mime\MediaType|null Media type of the
     * string if detected, null otherwise
     */
    public function getMediaTypeForString($string) {
        return $this->getMediaType($this->mimeSniffer->getMediaTypeForString($string));
    }

    /**
     * Gets a media type object for the provided file extension
     * @param string $extension File extension
     * @return \ride\library\mime\MediaType|boolean Media type of the
     * file extension or null when not found
     */
    public function getMediaTypeForExtension($extension) {
        return $this->getMediaType($this->mimeTypes->getMediaType($extension));
    }

    /**
     * Gets a extension for the provided media type
     * @param string $mediaType
     * @return \ride\library\mime\MediaType|null Extension of the provided media
     * type or null when not found
     */
    public function getExtensionForMediaType($mediaType) {
        return $this->mimeTypes->getExtension($mediaType);
    }

}
