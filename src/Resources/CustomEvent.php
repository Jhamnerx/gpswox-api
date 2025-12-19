<?php

namespace Gpswox\Resources;

use Gpswox\Wox;

class CustomEvent
{
    protected $client;

    public function __construct(Wox $client)
    {
        $this->client = $client;
    }

    /**
     * Get custom events
     * Retrieves all custom events.
     * 
     * @param array $filters Optional filters
     * @return array List of custom events
     */
    public function getCustomEvents(array $filters = [])
    {
        return $this->client->request('GET', 'api/get_custom_events', ['query' => $filters]);
    }

    /**
     * Get data to add custom event
     * Retrieves necessary data for creating a custom event.
     * 
     * @param array $params Optional parameters
     * @return array Custom event creation data
     */
    public function addCustomEventData(array $params = [])
    {
        return $this->client->request('GET', 'api/add_custom_event_data', ['query' => $params]);
    }

    /**
     * Create custom event
     * Creates a new custom event.
     * 
     * @param array $data Custom event data
     * @return array Created custom event response
     */
    public function addCustomEvent(array $data)
    {
        return $this->client->request('POST', 'api/add_custom_event', ['json' => $data]);
    }

    /**
     * Get data to edit custom event
     * Retrieves necessary data for editing a custom event.
     * 
     * @param int $eventId Event ID
     * @param array $params Optional parameters
     * @return array Custom event edit data
     */
    public function editCustomEventData(int $eventId, array $params = [])
    {
        $params['event_id'] = $eventId;
        return $this->client->request('GET', 'api/edit_custom_event_data', ['query' => $params]);
    }

    /**
     * Edit custom event
     * Updates an existing custom event.
     * 
     * @param int $eventId Event ID
     * @param array $data Custom event data to update
     * @return array Updated custom event response
     */
    public function editCustomEvent(int $eventId, array $data)
    {
        $data['event_id'] = $eventId;
        return $this->client->request('POST', 'api/edit_custom_event', ['json' => $data]);
    }

    /**
     * Delete custom event
     * Deletes a custom event.
     * 
     * @param int $eventId Event ID
     * @return array Deletion response
     */
    public function destroyCustomEvent(int $eventId)
    {
        return $this->client->request('GET', 'api/destroy_custom_event', ['query' => ['event_id' => $eventId]]);
    }
}
