<?php

namespace Gpswox\Resources;

use Gpswox\Wox;

class Sharing
{
    protected $client;

    public function __construct(Wox $client)
    {
        $this->client = $client;
    }

    /**
     * Get all sharing configurations
     * Retrieves all device sharing configurations.
     * 
     * @param array $params Optional parameters
     * @return array List of sharing configurations
     */
    public function getSharing(array $params = [])
    {
        return $this->client->request('GET', 'api/sharing', ['query' => $params]);
    }

    /**
     * Create sharing configuration
     * Creates a new device sharing configuration.
     * 
     * @param array $data Sharing data (devices, users, permissions, etc.)
     * @return array Created sharing configuration
     */
    public function createSharing(array $data)
    {
        return $this->client->request('POST', 'api/sharing', ['json' => $data]);
    }

    /**
     * Get specific sharing configuration
     * Retrieves a specific sharing configuration by ID.
     * 
     * @param int $sharingId Sharing ID
     * @param array $params Optional parameters
     * @return array Sharing configuration details
     */
    public function getSharingById(int $sharingId, array $params = [])
    {
        return $this->client->request('GET', "api/sharing/{$sharingId}", ['query' => $params]);
    }

    /**
     * Update sharing configuration
     * Updates an existing sharing configuration.
     * 
     * @param int $sharingId Sharing ID
     * @param array $data Sharing data to update
     * @return array Updated sharing configuration
     */
    public function updateSharing(int $sharingId, array $data)
    {
        return $this->client->request('PUT', "api/sharing/{$sharingId}", ['json' => $data]);
    }

    /**
     * Delete sharing configuration
     * Deletes a sharing configuration.
     * 
     * @param int $sharingId Sharing ID
     * @return array Deletion response
     */
    public function deleteSharing(int $sharingId)
    {
        return $this->client->request('DELETE', "api/sharing/{$sharingId}");
    }

    /**
     * Update devices in sharing configuration
     * Updates the list of devices associated with a sharing configuration.
     * 
     * @param int $sharingId Sharing ID
     * @param array $data Array with devices to share
     * @return array Update response
     */
    public function updateSharingDevices(int $sharingId, array $data)
    {
        return $this->client->request('PUT', "api/sharing/{$sharingId}/devices", ['json' => $data]);
    }
}
