<?php

namespace ArgilSdk\Error;

/**
 * Custom exception class for Argil SDK errors.
 * This class extends the base PHP Exception class and provides additional properties
 * for status codes and detailed error information.
 */
class ArgilError extends \Exception {
    /**
     * @var int|null HTTP status code associated with the error.
     */
    protected $statusCode;

    /**
     * @var mixed|null Detailed information about the error.
     */
    protected $details;

    /**
     * Constructs an instance of ArgilError.
     * 
     * @param string $message The error message.
     * @param int|null $statusCode Optional HTTP status code associated with the error.
     * @param mixed|null $details Optional detailed information about the error.
     */
    public function __construct($message, $statusCode = null, $details = null) {
        parent::__construct($message);
        $this->statusCode = $statusCode;
        $this->details = $details;
    }

    /**
     * Converts the exception to a string representation.
     * This includes the base exception message, status code, and detailed error information.
     * 
     * @return string The string representation of the exception.
     */
    public function __toString() {
        $str = parent::__toString();
        if ($this->statusCode) {
            $str .= " (status code: {$this->statusCode})";
        }
        if ($this->details) {
            $str .= " (details: " . json_encode($this->details) . ")";
        }
        return $str;
    }
}

