<?php

namespace Argil;

use Argil\Api\Workflows;
use Argil\Api\WorkflowRuns;
use Argil\Config\ArgilSdkGlobalConfig;

/**
 * Main class for the Argil SDK.
 * Provides a unified interface to interact with Argil's API services.
 */
class ArgilSdk {
    /**
     * @var Workflows Provides methods to interact with the Workflows service of Argil's API.
     */
    public $workflows;

    /**
     * @var WorkflowRuns Provides methods to interact with the WorkflowRuns service of Argil's API.
     */
    public $workflowRuns;

    /**
     * @var ArgilSdkGlobalConfig The global configuration for the SDK.
     */
    private $config;

    /**
     * Constructs an instance of ArgilSdk.
     * Initializes the global configuration and the API service classes.
     * 
     * @param array $params Optional configuration parameters for the SDK.
     */
    public function __construct($params = []) {
        $this->config = new ArgilSdkGlobalConfig($params);
        $this->workflows = new Workflows($this->config);
        $this->workflowRuns = new WorkflowRuns($this->config);
    }

    /**
     * Updates the global configuration for the SDK and its API service classes.
     * 
     * @param array $params The new configuration parameters for the SDK.
     */
    public function updateConfiguration($params) {
        $this->config = new ArgilSdkGlobalConfig($params);
        $this->workflows->updateGlobalConfig($this->config);
        $this->workflowRuns->updateGlobalConfig($this->config);
    }

    /**
     * Retrieves the current global configuration of the SDK.
     * 
     * @return ArgilSdkGlobalConfig The current global configuration.
     */
    public function getConfiguration() {
        return $this->config;
    }
}
