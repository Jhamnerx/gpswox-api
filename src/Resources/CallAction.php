<?php

namespace Gpswox\Resources;

use Gpswox\Wox;

class CallAction
{
    protected $client;

    public function __construct(Wox $client)
    {
        $this->client = $client;
    }

    /**
     * Get all call actions
     * Retrieves all call action configurations.
     * 
     * @param array $params Optional parameters
     * @return array List of call actions
     */
    public function getCallActions(array $params = [])
    {
        return $this->client->request('GET', 'api/call_actions', ['query' => $params]);
    }

    /**
     * Get specific call action
     * Retrieves a specific call action by ID.
     * 
     * @param int $actionId Call action ID
     * @param array $params Optional parameters
     * @return array Call action details
     */
    public function getCallAction(int $actionId, array $params = [])
    {
        return $this->client->request('GET', "api/call_actions/{$actionId}", ['query' => $params]);
    }

    /**
     * Create call action
     * Creates a new call action configuration.
     * 
     * @param array $data Call action data
     * @return array Created call action
     */
    public function storeCallAction(array $data)
    {
        return $this->client->request('POST', 'api/call_actions/store', ['json' => $data]);
    }

    /**
     * Update call action
     * Updates an existing call action.
     * 
     * @param int $actionId Call action ID
     * @param array $data Call action data to update
     * @return array Updated call action
     */
    public function updateCallAction(int $actionId, array $data)
    {
        return $this->client->request('PUT', "api/call_actions/update/{$actionId}", ['json' => $data]);
    }

    /**
     * Delete call action
     * Deletes a call action.
     * Note: Endpoint has typo in API (destory instead of destroy)
     * 
     * @param int $actionId Call action ID
     * @return array Deletion response
     */
    public function destroyCallAction(int $actionId)
    {
        return $this->client->request('DELETE', "api/call_actions/destory/{$actionId}");
    }

    /**
     * Get event types
     * Retrieves available event types for call actions.
     * 
     * @param array $params Optional parameters
     * @return array Event types
     */
    public function getEventTypes(array $params = [])
    {
        return $this->client->request('GET', 'api/call_actions/event_types', ['query' => $params]);
    }

    /**
     * Get response types
     * Retrieves available response types for call actions.
     * 
     * @param array $params Optional parameters
     * @return array Response types
     */
    public function getResponseTypes(array $params = [])
    {
        return $this->client->request('GET', 'api/call_actions/response_types', ['query' => $params]);
    }
}
