<?php

namespace Gpswox\Resources;

use Gpswox\Wox;

class History
{
    protected $client;

    public function __construct(Wox $client)
    {
        $this->client = $client;
    }

    /**
     * 1. Get History
     * Retrieves the history of a device within a specific date range.
     */
    public function getHistory(
        int $deviceId,
        string $from,
        string $to,
        array $additionalParams = []
    ) {
        $query = array_merge([
            'device_id' => $deviceId,
            'from' => $from,
            'to' => $to,
        ], $additionalParams);

        return $this->client->request('GET', 'api/get_history', [
            'query' => $query,
        ]);
    }

    /**
     * 2. Get History Messages
     * Retrieves historical messages for a device within a specific date range.
     */
    public function getHistoryMessages(
        int $deviceId,
        string $from,
        string $to,
        array $additionalParams = []
    ) {
        $query = array_merge([
            'device_id' => $deviceId,
            'from_date' => explode(' ', $from)[0],
            'from_time' => explode(' ', $from)[1],
            'to_date' => explode(' ', $to)[0],
            'to_time' => explode(' ', $to)[1],
            'limit' => 1000,

        ], $additionalParams);

        return $this->client->request('GET', 'api/get_history_messages', [
            'query' => $query,
        ]);
    }

    /**
     * 3. Delete History Positions
     * Deletes historical positions for a device within a specific date range.
     */
    public function deleteHistoryPositions(
        int $deviceId,
        string $from,
        string $to,
        bool $all = false
    ) {
        return $this->client->request('DELETE', 'api/delete_history_positions', [
            'json' => [
                'device_id' => $deviceId,
                'from' => $from,
                'to' => $to,
                'all' => $all,
            ],
        ]);
    }
}
