<?php

namespace Gpswox\Resources;

use Gpswox\Wox;

class Geofence
{
    protected $client;

    public function __construct(Wox $client)
    {
        $this->client = $client;
    }

    /**
     * Get geofences
     * Retrieves all geofences.
     * 
     * @param array $filters Optional filters
     * @return array List of geofences
     */
    public function getGeofences(array $filters = [])
    {
        return $this->client->request('GET', 'api/get_geofences', ['query' => $filters]);
    }

    /**
     * Create geofence
     * Creates a new geofence.
     * 
     * @param array $data Geofence data
     * @return array Created geofence response
     */
    public function addGeofence(array $data)
    {
        return $this->client->request('POST', 'api/add_geofence', ['json' => $data]);
    }

    /**
     * Edit geofence
     * Updates an existing geofence.
     * 
     * @param int $geofenceId Geofence ID
     * @param array $data Geofence data to update
     * @return array Updated geofence response
     */
    public function editGeofence(int $geofenceId, array $data)
    {
        $data['geofence_id'] = $geofenceId;
        return $this->client->request('POST', 'api/edit_geofence', ['json' => $data]);
    }

    /**
     * Delete geofence
     * Deletes a geofence.
     * 
     * @param int $geofenceId Geofence ID
     * @return array Deletion response
     */
    public function destroyGeofence(int $geofenceId)
    {
        return $this->client->request('GET', 'api/destroy_geofence', ['query' => ['geofence_id' => $geofenceId]]);
    }

    /**
     * Change geofence active status
     * Toggles the active status of a geofence.
     * 
     * @param int $geofenceId Geofence ID
     * @return array Status change response
     */
    public function changeActiveGeofence(int $geofenceId)
    {
        return $this->client->request('GET', 'api/change_active_geofence', ['query' => ['geofence_id' => $geofenceId]]);
    }

    /**
     * Check point in geofences
     * Checks if a point (latitude, longitude) is within any geofences.
     * 
     * @param float $latitude Latitude
     * @param float $longitude Longitude
     * @param array $params Optional parameters
     * @return array Geofences containing the point
     */
    public function pointInGeofences(float $latitude, float $longitude, array $params = [])
    {
        $params['latitude'] = $latitude;
        $params['longitude'] = $longitude;
        return $this->client->request('GET', 'api/point_in_geofences', ['query' => $params]);
    }

    /**
     * Get geofence groups
     * Retrieves all geofence groups.
     * 
     * @param array $params Optional parameters
     * @return array List of geofence groups
     */
    public function getGeofenceGroups(array $params = [])
    {
        return $this->client->request('GET', 'api/geofences_groups', ['query' => $params]);
    }

    /**
     * Create geofence group
     * Creates a new geofence group.
     * 
     * @param array $data Group data
     * @return array Created group response
     */
    public function storeGeofenceGroup(array $data)
    {
        return $this->client->request('POST', 'api/geofences_groups/store', ['json' => $data]);
    }

    /**
     * Update geofence group
     * Updates an existing geofence group.
     * 
     * @param int $groupId Group ID
     * @param array $data Group data to update
     * @return array Updated group response
     */
    public function updateGeofenceGroup(int $groupId, array $data)
    {
        return $this->client->request('PUT', "api/geofences_groups/update/{$groupId}", ['json' => $data]);
    }
}
