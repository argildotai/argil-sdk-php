<?php

namespace ArgilSdk\Api;

use ArgilSdk\Config\ArgilSdkGlobalConfig;
use ArgilSdk\Config\ArgilSdkRuntimeConfig;
use ArgilSdk\Error\ArgilError;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Base class for API interactions.
 * Provides common methods for making requests to the Argil API.
 */
abstract class Base {
    /**
     * @var ArgilSdkGlobalConfig The global configuration for the SDK.
     */
    protected $globalConfig;

    /**
     * Constructor.
     *
     * @param ArgilSdkGlobalConfig $globalConfig The global configuration for the SDK.
     */
    public function __construct($globalConfig) {
        $this->globalConfig = $globalConfig;
    }

    /**
     * Update the global configuration.
     *
     * @param ArgilSdkGlobalConfig $globalConfig The new global configuration for the SDK.
     */
    public function updateGlobalConfig($globalConfig) {
        $this->globalConfig = $globalConfig;
    }

    /**
     * Make a request to the Argil API.
     *
     * @param string $method The HTTP method (e.g., GET, POST).
     * @param string $url The endpoint URL.
     * @param array $data The request data.
     * @param ArgilSdkRuntimeConfig|null $runtimeConfig Optional runtime configuration.
     *
     * @return array The response data.
     *
     * @throws ArgilError If the request fails.
     */
    protected function request($method, $url, $data = [], $runtimeConfig = null) {
        $runtimeConfigInstance = new ArgilSdkRuntimeConfig($runtimeConfig);
        $config = array_merge($this->globalConfig->toObject(), $runtimeConfigInstance->toObject());

        // Determine the timeout based on the configuration.
        if (isset($config['timeout'])) {
            $timeout = $config['timeout'];
        } else {
            $timeout = $config['defaultSyncTimeout'];
        }

        // Update the client instance with the determined timeout.
        $client = $this->globalConfig->updateClientInstance($timeout);

        $options = [];
        if (!empty($data)) {
            $options['json'] = $data;
        }

        // Make the request and handle potential exceptions.
        try {
            $response = $client->request($method, $url, $options);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            throw new ArgilError($e->getMessage(), $e->getCode());
        }
    }
}
