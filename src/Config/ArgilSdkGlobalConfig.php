<?php

namespace ArgilSdk\Config;

use ArgilSdk\Error\ArgilError;
use GuzzleHttp\Client;
use InvalidArgumentException;

/**
 * Class responsible for managing the global configuration of the Argil SDK.
 */
class ArgilSdkGlobalConfig {
    /**
     * @var array Configuration parameters.
     */
    private $config;

    /**
     * @var Client Guzzle HTTP client instance.
     */
    private $client;

    /**
     * Constructs an instance of ArgilSdkGlobalConfig.
     * 
     * @param array $params Optional configuration parameters including the base URL and timeouts.
     */
    public function __construct($params = []) {
        $defaults = [
            'apiUrl' => 'https://api.argil.ai',
            'synchronous' => false,
            'defaultSyncTimeout' => 60000,
            'defaultAsyncTimeout' => 2000,
        ];
        $this->config = array_merge($defaults, $params);
        $this->validate();

        $this->client = new Client([
            'base_uri' => $this->config['apiUrl'],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->config['apiKey']
            ]
        ]);
    }

    /**
     * Validates the configuration parameters.
     * 
     * @throws InvalidArgumentException If any of the configuration parameters are invalid.
     */
    protected function validate() {
        if (empty($this->config['apiKey'])) {
            throw new InvalidArgumentException('API key is required.');
        }

        if (!filter_var($this->config['apiUrl'], FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Invalid API URL provided.');
        }

        if ($this->config['defaultSyncTimeout'] <= 0 || $this->config['defaultAsyncTimeout'] <= 0) {
            throw new InvalidArgumentException('Timeout values must be positive integers.');
        }
    }

    /**
     * Updates the timeout of the Guzzle client instance and returns the updated instance.
     * 
     * @param int $timeout The new timeout in milliseconds.
     * @return Client The updated Guzzle client instance.
     */
    public function updateClientInstance($timeout) {
        $this->client = new Client([
            'base_uri' => $this->config['apiUrl'],
            'timeout' => $timeout / 1000, // Convert to seconds for Guzzle
            'headers' => [
                'Authorization' => 'Bearer ' . $this->config['apiKey']
            ]
        ]);
        return $this->client;
    }

    /**
     * Get the API URL.
     * 
     * @return string The API URL.
     */
    public function getApiUrl() {
        return $this->config['apiUrl'];
    }

    /**
     * Set the API URL.
     * 
     * @param string $url The new API URL.
     */
    public function setApiUrl($url) {
        $this->config['apiUrl'] = $url;
        $this->client->getConfig()['base_uri'] = $url;
    }

    /**
     * Get the default timeout for synchronous requests.
     * 
     * @return int The default timeout for synchronous requests in milliseconds.
     */
    public function getDefaultSyncTimeout() {
        return $this->config['defaultSyncTimeout'];
    }

    /**
     * Set the default timeout for synchronous requests.
     * 
     * @param int $timeout The new default timeout for synchronous requests in milliseconds.
     */
    public function setDefaultSyncTimeout($timeout) {
        if ($timeout <= 0) {
            throw new InvalidArgumentException('Timeout value must be a positive integer.');
        }
        $this->config['defaultSyncTimeout'] = $timeout;
    }

    /**
     * Get the default timeout for asynchronous requests.
     * 
     * @return int The default timeout for asynchronous requests in milliseconds.
     */
    public function getDefaultAsyncTimeout() {
        return $this->config['defaultAsyncTimeout'];
    }

    /**
     * Set the default timeout for asynchronous requests.
     * 
     * @param int $timeout The new default timeout for asynchronous requests in milliseconds.
     */
    public function setDefaultAsyncTimeout($timeout) {
        if ($timeout <= 0) {
            throw new InvalidArgumentException('Timeout value must be a positive integer.');
        }
        $this->config['defaultAsyncTimeout'] = $timeout;
    }
}
