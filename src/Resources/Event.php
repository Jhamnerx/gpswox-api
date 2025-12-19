<?php

namespace Gpswox\Resources;

use Gpswox\Wox;

class Event
{
    protected $client;

    public function __construct(Wox $client)
    {
        $this->client = $client;
    }

    /**
     * Get events
     * Retrieves events for devices.
     * 
     * @param array $params Parameters including device_id, from, to, etc.
     * @return array List of events
     */
    public function getEvents(array $params = [])
    {
        return $this->client->request('GET', 'api/get_events', ['query' => $params]);
    }

    /**
     * Delete events
     * Deletes events for a device.
     * 
     * @param int $deviceId Device ID
     * @param array $params Optional parameters
     * @return array Deletion response
     */
    public function destroyEvents(int $deviceId, array $params = [])
    {
        $params['device_id'] = $deviceId;
        return $this->client->request('GET', 'api/destroy_events', ['query' => $params]);
    }
}
