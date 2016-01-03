<?php

namespace ride\library\mime;

use ride\library\mime\exception\MimeException;

/**
 * Definition of a MIME media type
 * @see https://en.wikipedia.org/wiki/Media_type
 */
class MediaType {

    /**
     * Application main type
     * @var string
     */
    const TYPE_APPLICATION = 'application';

    /**
     * Audio main type
     * @var string
     */
    const TYPE_AUDIO = 'audio';

    /**
     * Example main type
     * @var string
     */
    const TYPE_EXAMPLE = 'example';

    /**
     * Image main type
     * @var string
     */
    const TYPE_IMAGE = 'image';

    /**
     * Message main type
     * @var string
     */
    const TYPE_MESSAGE = 'message';

    /**
     * Model main type
     * @var string
     */
    const TYPE_MODEL = 'model';

    /**
     * Multipart main type
     * @var string
     */
    const TYPE_MULTIPART = 'multipart';

    /**
     * Text main type
     * @var string
     */
    const TYPE_TEXT = 'text';

    /**
     * Video main type
     * @var string
     */
    const TYPE_VIDEO = 'video';

    /**
     * Main type of the media type
     * @var string
     */
    protected $type;

    /**
     * Subtype of the media type
     * @var string
     */
    protected $subtype;

    /**
     * Parameters of the media type
     * @var array
     */
    protected $parameters;

    /**
     * Constructs a new MIME
     * @param string $type Main type
     * @param string $subtype Subtype
     * @param array $parameters Parameters for the type
     * @throws \InvalidArgumentException when the provided type or subtype is
     * invalid
     */
    public function __construct($type, $subtype, array $parameters = null) {
        $this->setType($type);
        $this->setSubtype($subtype);
        $this->setParameters($parameters);
    }

    /**
     * Gets a string representation of this MIME
     * @return string
     */
    public function __toString() {
        $parameters = '';

        if ($this->parameters) {
            $parameters = array();
            $validChars = array('/', '-', '+');

            foreach ($this->parameters as $key => $value) {
                if (!ctype_alnum(str_replace($validChars, '', $value))) {
                    $parameters[] = $key . '="' . $value . '"';
                } else {
                    $parameters[] = $key . '=' . $value;
                }
            }

            $parameters = '; ' . implode('; ', $parameters);
        }

        return $this->getMimeType() . $parameters;
    }

    /**
     * Sets the main type of thie MIME
     * @param string $type
     * @return null
     * @throws \InvalidArgumentException when the provided type is invalid
     */
    protected function setType($type) {
        if (!is_string($type) || !$type) {
            throw new MimeException('Could not set the type: provided argument is empty or not a string');
        }

        $this->type = $type;
    }

    /**
     * Gets the main type of this MIME
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Sets the subtype of thie MIME
     * @param string $subtype
     * @return null
     * @throws \InvalidArgumentException when the provided subtype is invalid
     */
    protected function setSubtype($subtype) {
        if (!is_string($subtype) || !$subtype) {
            throw new MimeException('Could not set the subtype: provided argument is empty or not a string');
        }

        $this->subtype = $subtype;
    }

    /**
     * Gets the subtype of this MIME
     * @return string
     */
    public function getSubtype() {
        return $this->subtype;
    }

    /**
     * Gets the tree of this MIME
     * @return string
     */
    public function getTree() {
        $position = strpos($this->subtype, '.');
        if (!$position) {
            return null;
        }

        return substr($this->subtype, $position);
    }

    /**
     * Gets the structure suffix of this mime type (xml, json, ...)
     * @return string|null
     */
    public function getSuffix() {
        $position = strpos($this->subtype, '+');
        if (!$position) {
            return null;
        }

        return substr($this->subtype, $position + 1);
    }

    /**
     * Gets the MIME type, the type and subtype without parameters
     * @return string
     */
    public function getMimeType() {
        return $this->type . '/' . $this->subtype;
    }

    /**
     * Sets the parameters of this media type
     * @param array $parameters
     * @return null
     */
    protected function setParameters(array $parameters = null) {
        $this->parameters = array();
        if (!$parameters) {
            return;
        }

        foreach ($parameters as $key => $value) {
            $this->parameters[strtolower($key)] = $value;
        }
    }

    /**
     * Gets all the parameters
     * @return array
     */
    public function getParameters() {
        return $this->parameters;
    }

    /**
     * Gets a single parameter
     * @param string $name Name of the parameter
     * @param mixed $default Default value for when the parameter is not set
     * @return mixed Value for the parameter if set, provided default value
     * otherwise
     */
    public function getParameter($name, $default = null) {
        $name = strtolower($name);

        if (!isset($this->parameters[$name])) {
            return $default;
        }

        return $this->parameters[$name];
    }

    /**
     * Checks if this media has the application main type
     * @return boolean
     */
    public function isApplication() {
        return $this->type == self::TYPE_APPLICATION;
    }

    /**
     * Checks if this media has the audio main type
     * @return boolean
     */
    public function isAudio() {
        return $this->type == self::TYPE_AUDIO;
    }

    /**
     * Checks if this media has the example main type
     * @return boolean
     */
    public function isExample() {
        return $this->type == self::TYPE_EXAMPLE;
    }

    /**
     * Checks if this media has the image main type
     * @return boolean
     */
    public function isImage() {
        return $this->type == self::TYPE_IMAGE;
    }

    /**
     * Checks if this media has the message main type
     * @return boolean
     */
    public function isMessage() {
        return $this->type == self::TYPE_MESSAGE;
    }

    /**
     * Checks if this media has the model main type
     * @return boolean
     */
    public function isModel() {
        return $this->type == self::TYPE_MODEL;
    }

    /**
     * Checks if this media has the multipart main type
     * @return boolean
     */
    public function isMultipart() {
        return $this->type == self::TYPE_MULTIPART;
    }

    /**
     * Checks if this media has the text main type
     * @return boolean
     */
    public function isText() {
        return $this->type == self::TYPE_TEXT;
    }

    /**
     * Checks if this media has the video main type
     * @return boolean
     */
    public function isVideo() {
        return $this->type == self::TYPE_VIDEO;
    }

}
