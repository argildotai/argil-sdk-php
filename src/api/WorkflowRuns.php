<?php

namespace ArgilSdk\Api;

/**
 * Class responsible for interacting with the WorkflowRuns service of the Argil API.
 */
class WorkflowRuns extends Base {
    /**
     * Retrieve a list of all workflow runs.
     *
     * @return array The list of workflow runs.
     */
    public function list() {
        return $this->request('GET', '/getWorkflowRuns');
    }

    /**
     * Retrieve a specific workflow run by its ID.
     *
     * @param string $id The ID of the workflow run to retrieve.
     *
     * @return array The details of the specified workflow run.
     */
    public function get($id) {
        return $this->request('GET', "/getWorkflowRun/{$id}");
    }
}
