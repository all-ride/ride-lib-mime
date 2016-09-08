<?php

namespace ride\library\mime;

use ride\library\mime\exception\MimeException;

/**
 * Factory to create instances from the MIME library
 */
class MimeFactory {

    /**
     * Creates a MimeTypes instance
     * @return MimeTypes
     */
    public function createMimeTypes() {
        return new MimeTypes();
    }

    /**
     * Creates a MimeTypes instance based on a provided mime.types file
     * @param string $file Path to a mime.types file
     * @return MimeTypes
     */
    public function createMimeTypesFromFile($file) {
        $string = @file_get_contents($file);
        if ($string === false) {
            throw new MimeException('Could not create mime types from file: ' . $file . ' does not exist or cannot be read');
        }

        return $this->createMimeTypesFromString($string);
    }

    /**
     * Creates a MimeTypes instance based on the contents of a mime.types file
     * @param string $string Contents of a mime.types file
     * @return MimeTypes
     */
    public function createMimeTypesFromString($string) {
        $mimeTypes = $this->createMimeTypes();

        $lines = explode("\n", $string);
        foreach ($lines as $line) {
            $line = trim($line);
            if (!$line || substr($line, 0, 1) == '#') {
                continue;
            }

            $tokens = array();

            $tabTokens = explode("\t", $line);
            foreach ($tabTokens as $tabToken) {
                if (!$tabToken) {
                    continue;
                }

                $spaceTokens = explode(" ", $tabToken);
                foreach ($spaceTokens as $spaceToken) {
                    $tokens[] = $spaceToken;
                }
            }

            if (count($tokens) < 2) {
                continue;
            }

            $mediaType = array_shift($tokens);

            $mimeTypes->setMediaType($mediaType, $tokens);
        }

        return $mimeTypes;
    }

    /**
     * Creates a MediaType instance
     * @param string $type Main type of the media type
     * @param string $subtype Subtype of the media type
     * @param array $parameters Key-value pair with parameters of the media type
     * @return MediaType
     */
    public function createMediaType($type, $subtype, array $parameters = null) {
        return new MediaType($type, $subtype, $parameters);
    }

    /**
     * Creates a MediaType instance based on the string representation
     * @param string $mediaType String representation of a media type
     * @return MediaType|null
     */
    public function createMediaTypeFromString($mediaType) {
        if (!$mediaType) {
            return null;
        }

        $parts = array(
            'type' => '',
            'subtype' => '',
            'parameters' => array(),
        );
        $part = 'type';
        $parameter = 0;
        $previousChar = null;
        $isInsideString = false;
        $length = strlen($mediaType);

        for ($i = 0; $i < $length; $i++) {
            $char = substr($mediaType, $i, 1);

            switch ($part) {
                case 'type':
                    if ($char == '/') {
                        $part = 'subtype';
                    } else {
                        $parts[$part] .= $char;
                    }

                    break;
                case 'subtype':
                    if ($char == ';') {
                        $part = 'parameters';
                    } else {
                        $parts[$part] .= $char;
                    }

                    break;
                case 'parameters':
                    if (!$isInsideString && $char == ';') {
                        $part++;

                        break;
                    }

                    if (!isset($parts[$part][$parameter])) {
                        $parts[$part][$parameter] = $char;
                    } else {
                        $parts[$part][$parameter] .= $char;
                    }

                    if ($char == '"' && (!$isInsideString || ($isInsideString && $previousChar != '\\'))) {
                        $isInsideString = !$isInsideString;
                    }

                    break;
            }

            $previousChar = $char;
        }

        if ($parts['parameters']) {
            $parts['parameters'] = $this->parseMediaTypeParameters($parts['parameters']);
        }

        try {
            return $this->createMediaType($parts['type'], $parts['subtype'], $parts['parameters']);
        } catch (MimeException $exception) {
            throw new MimeException('Could not create media type for ' . $mediaType, 0, $exception);
        }
    }

    /**
     * Parses the parameters of a media type
     * @param array $parameters Array with parameter strings
     * @return array Array with parameters as key-value pair
     */
    protected function parseMediaTypeParameters(array $parameters) {
        foreach ($parameters as $index => $string) {
            $this->parseMediaTypeParameter($string, $key, $value);

            $parameters[$key] = $value;
            unset($parameters[$index]);
        }

        return $parameters;
    }

    /**
     * Parses a parameter string of a media type
     * @param string $string String to parse
     * @param string $key Key of the parameter
     * @param string|boolean $value Value of the parameter
     * @return null
     */
    protected function parseMediaTypeParameter($string, &$key, &$value) {
        $string = trim($string);
        if (strpos($string, '=')) {
            list($key, $value) = explode('=', $string, 2);

            if (substr($value, 0, 1) == '"' && substr($value, -1) == '"') {
                $value = substr($value, 1, -1);
            }
        } else {
            $key = $string;
            $value = true;
        }
    }

}
