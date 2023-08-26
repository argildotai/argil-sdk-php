<?php

namespace Argil\Interfaces;

/**
 * Interface representing a WorkflowRun.
 */
interface WorkflowRun {
    /**
     * Get the unique identifier for the workflow run.
     * 
     * @return string
     */
    public function getId();

    /**
     * Get the status of the workflow run.
     * 
     * @return string
     */
    public function getStatus();

    /**
     * Get the creation date of the workflow run.
     * 
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Get the start date of the workflow run.
     * 
     * @return \DateTime
     */
    public function getDateStarted();

    /**
     * Get the end date of the workflow run.
     * 
     * @return \DateTime
     */
    public function getDateEnded();

    /**
     * Get the logs of the workflow run.
     * 
     * @return string
     */
    public function getLogs();

    /**
     * Get the error logs of the workflow run.
     * 
     * @return string
     */
    public function getErrorLogs();

    /**
     * Get the payload of the workflow run.
     * 
     * @return string
     */
    public function getPayload();
}

/**
 * Interface representing the global configuration parameters for the Argil SDK.
 */
interface ArgilSdkGlobalConfigParams {
    public function getApiKey();
    public function getApiUrl();
    public function isSynchronous();
    public function getDefaultSyncTimeout();
    public function getDefaultAsyncTimeout();
}

/**
 * Interface representing the runtime configuration parameters for the Argil SDK.
 */
interface ArgilSdkRuntimeConfigParams {
    public function getTimeout();
    public function isSynchronous();
}

