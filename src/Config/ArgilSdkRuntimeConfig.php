<?php

namespace ArgilSdk\Config;

use ArgilSdk\Error\ArgilError;

/**
 * Class responsible for managing the runtime configuration of the Argil SDK.
 * This includes settings like whether requests should be synchronous and their timeout values.
 */
class ArgilSdkRuntimeConfig {
    /**
     * @var array Configuration parameters.
     */
    private $config;

    /**
     * Constructs an instance of ArgilSdkRuntimeConfig.
     * 
     * @param array $params Optional configuration parameters.
     */
    public function __construct($params = null) {
        $defaults = [
            'synchronous' => false,
        ];
        $params = is_array($params) ? $params : [];
        $this->config = array_merge($defaults, $params);
        $this->validate();
    }

    /**
     * Validates the configuration parameters.
     * 
     * @throws ArgilError If any of the configuration parameters are invalid.
     */
    protected function validate() {
        if (isset($this->config['timeout']) && $this->config['timeout'] <= 0) {
            throw new ArgilError('Invalid timeout: It should be a positive integer representing milliseconds', 400);
        }
    }

    /**
     * Get the timeout value from the configuration.
     * 
     * @return int The timeout value in milliseconds.
     */
    public function getTimeout() {
        return $this->config['timeout'];
    }

    /**
     * Set the timeout value in the configuration.
     * 
     * @param int $value The timeout value in milliseconds.
     */
    public function setTimeout($value) {
        $this->config['timeout'] = $value;
    }

    /**
     * Check if the configuration is set to synchronous.
     * 
     * @return bool True if synchronous, false otherwise.
     */
    public function isSynchronous() {
        return $this->config['synchronous'];
    }

    /**
     * Set the synchronous flag in the configuration.
     * 
     * @param bool $value The value to set for the synchronous flag.
     */
    public function setSynchronous($value) {
        $this->config['synchronous'] = $value;
    }

    /**
     * Convert the configuration to an associative array.
     * 
     * @return array The configuration as an associative array.
     */
    public function toObject() {
        return $this->config;
    }
}
