<?php

namespace ArgilSdk\Api;

use ArgilSdk\Helpers;
use ArgilSdk\Error\ArgilError;
use ArgilSdk\Config\ArgilSdkRuntimeConfig;

/**
 * Class responsible for interacting with the Workflows service of the Argil API.
 */
class Workflows extends Base {
    /**
     * Run a workflow with the provided ID and input.
     * 
     * @param string $id The ID of the workflow to run.
     * @param mixed $input The input for the workflow.
     * @param array|null $runtimeConfig A runtime config to override global config at runtime.
     * 
     * @return array The response data.
     * 
     * @throws ArgilError If there's an error during the workflow execution.
     */
    public function run($id, $input, $runtimeConfig = null) {
        // Merge global configuration with runtime configuration
        $runtimeConfigInstance = new ArgilSdkRuntimeConfig($runtimeConfig);
        $config = array_merge($this->globalConfig->toObject(), $runtimeConfigInstance->toObject());
        
        // Determine the timeout based on whether the request is synchronous or asynchronous
        $timeout = $config['synchronous'] ? $config['defaultSyncTimeout'] : $config['defaultAsyncTimeout'];

        // Initiate the workflow run
        $response = $this->request('POST', '/runWorkflow', ['id' => $id, 'input' => $input], $runtimeConfig);

        // If the request is synchronous, poll the API until the workflow completes or times out
        if ($config['synchronous']) {
            $startTime = time();

            // Continue checking the status of the workflow run as long as it's "RUNNING"
            while ($response['status'] === 'QUEUED' || $response['status'] === 'RUNNING') {
                // If the elapsed time exceeds the timeout, throw an error
                if ((time() - $startTime) * 1000 > $timeout) {
                    throw new ArgilError('Workflow execution timed out.', 408);
                }
                
                // Wait for 5 seconds before checking the status again
                usleep(5000 * 1000);
                
                // Fetch the current status of the workflow run
                $response = $this->request('GET', "/getWorkflowRun/{$response['id']}");

                // If the workflow run has failed, throw an error
                if ($response['status'] === 'FAILED') {
                    throw new ArgilError('Workflow execution failed.', 500);
                }
            }
        }

        return $response;
    }
}
