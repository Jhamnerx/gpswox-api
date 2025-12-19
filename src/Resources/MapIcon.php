<?php

namespace Gpswox\Resources;

use Gpswox\Wox;

class MapIcon
{
    protected $client;

    public function __construct(Wox $client)
    {
        $this->client = $client;
    }

    /**
     * Get user map icons
     * Retrieves user's custom map icons.
     * 
     * @param array $params Optional parameters
     * @return array List of user map icons
     */
    public function getUserMapIcons(array $params = [])
    {
        return $this->client->request('GET', 'api/get_user_map_icons', ['query' => $params]);
    }

    /**
     * Get map icons
     * Retrieves all available map icons.
     * 
     * @param array $params Optional parameters
     * @return array List of map icons
     */
    public function getMapIcons(array $params = [])
    {
        return $this->client->request('GET', 'api/get_map_icons', ['query' => $params]);
    }

    /**
     * Create map icon
     * Creates a new custom map icon.
     * 
     * @param array $data Map icon data (use multipart for file upload)
     * @return array Created map icon response
     */
    public function addMapIcon(array $data)
    {
        return $this->client->request('POST', 'api/add_map_icon', [
            'multipart' => $this->buildMultipartData($data)
        ]);
    }

    /**
     * Edit map icon
     * Updates an existing map icon.
     * 
     * @param int $iconId Icon ID
     * @param array $data Map icon data to update
     * @return array Updated map icon response
     */
    public function editMapIcon(int $iconId, array $data)
    {
        $data['icon_id'] = $iconId;
        return $this->client->request('POST', 'api/edit_map_icon', [
            'multipart' => $this->buildMultipartData($data)
        ]);
    }

    /**
     * Change map icon active status
     * Toggles the active status of a map icon.
     * 
     * @param int $iconId Icon ID
     * @return array Status change response
     */
    public function changeActiveMapIcon(int $iconId)
    {
        return $this->client->request('GET', 'api/change_active_map_icon', ['query' => ['icon_id' => $iconId]]);
    }

    /**
     * Delete map icon
     * Deletes a map icon.
     * 
     * @param int $iconId Icon ID
     * @return array Deletion response
     */
    public function destroyMapIcon(int $iconId)
    {
        return $this->client->request('GET', 'api/destroy_map_icon', ['query' => ['icon_id' => $iconId]]);
    }

    /**
     * Get POI groups
     * Retrieves all POI (Points of Interest) groups.
     * 
     * @param array $params Optional parameters
     * @return array List of POI groups
     */
    public function getPoisGroups(array $params = [])
    {
        return $this->client->request('GET', 'api/pois_groups', ['query' => $params]);
    }

    /**
     * Create POI group
     * Creates a new POI group.
     * 
     * @param array $data Group data
     * @return array Created group response
     */
    public function storePoisGroup(array $data)
    {
        return $this->client->request('POST', 'api/pois_groups/store', ['json' => $data]);
    }

    /**
     * Update POI group
     * Updates an existing POI group.
     * 
     * @param int $groupId Group ID
     * @param array $data Group data to update
     * @return array Updated group response
     */
    public function updatePoisGroup(int $groupId, array $data)
    {
        return $this->client->request('PUT', "api/pois_groups/update/{$groupId}", ['json' => $data]);
    }

    /**
     * Build multipart form data
     * Converts array data to multipart format for file uploads.
     * 
     * @param array $data Data to convert
     * @return array Multipart data
     */
    protected function buildMultipartData(array $data)
    {
        $multipart = [];
        foreach ($data as $key => $value) {
            if ($key === 'icon' && is_resource($value)) {
                $multipart[] = [
                    'name' => $key,
                    'contents' => $value
                ];
            } else {
                $multipart[] = [
                    'name' => $key,
                    'contents' => is_array($value) ? json_encode($value) : $value
                ];
            }
        }
        return $multipart;
    }
}
