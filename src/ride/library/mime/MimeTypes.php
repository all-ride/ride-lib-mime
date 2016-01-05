<?php

namespace ride\library\mime;

/**
 * Map for file extensions and media types
 * @see https://en.wikipedia.org/wiki/Mailcap#mime.types
 */
class MimeTypes {

    /**
     * Map of the media types with their extensions
     * @var array
     */
    private $mediaTypes = array();

    /**
     * Map of the extensions with their media type
     * @var array
     */
    private $extensions = array();

    /**
     * Sets the extensions for a media type
     * @param string $mediaType A MIME media type
     * @param array $extensions Array with the extensions of the provided media
     * type
     * @return null
     */
    public function setMediaType($mediaType, array $extensions) {
        foreach ($extensions as $index => $extension) {
            unset($extensions[$index]);
            $extensions[$extension] = $extension;

            $this->extensions[$extension] = $mediaType;
        }

        $this->mediaTypes[$mediaType] = $extensions;
    }

    /**
     * Gets the media type for the provided extension
     * @param string $extension
     * @param mixed $default
     * @return mixed Media type for the extension if found, provided default
     * value otherwise
     */
    public function getMediaType($extension, $default = null) {
        if (!isset($this->extensions[$extension])) {
            return $default;
        }

        return $this->extensions[$extension];
    }

    /**
     * Gets the extensions
     * @return array Array with the media type as key and an array of extensions
     * as value
     */
    public function getMediaTypes() {
        return $this->mediaTypes;
    }


    /**
     * Gets the extension for the provided media type
     * @param string $mediaType
     * @param mixed $default
     * @return mixed Extension for the media type if found, provided default
     * value otherwise
     */
    public function getExtension($mediaType, $default = null) {
        if (!isset($this->mediaTypes[$mediaType])) {
            return $default;
        }

        $extension = $this->mediaTypes[$mediaType];
        $extension = array_shift($extension);

        return $extension;
    }

    /**
     * Gets the extensions
     * @return array Array with the extension as key and the media type as value
     */
    public function getExtensions() {
        return $this->extensions;
    }

}
