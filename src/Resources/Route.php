<?php

namespace Gpswox\Resources;

use Gpswox\Wox;

class Route
{
    protected $client;

    public function __construct(Wox $client)
    {
        $this->client = $client;
    }

    /**
     * Get routes
     * Retrieves all routes.
     * 
     * @param array $filters Optional filters
     * @return array List of routes
     */
    public function getRoutes(array $filters = [])
    {
        return $this->client->request('GET', 'api/get_routes', ['query' => $filters]);
    }

    /**
     * Create route
     * Creates a new route.
     * 
     * @param array $data Route data
     * @return array Created route response
     */
    public function addRoute(array $data)
    {
        return $this->client->request('POST', 'api/add_route', ['json' => $data]);
    }

    /**
     * Edit route
     * Updates an existing route.
     * 
     * @param int $routeId Route ID
     * @param array $data Route data to update
     * @return array Updated route response
     */
    public function editRoute(int $routeId, array $data)
    {
        $data['route_id'] = $routeId;
        return $this->client->request('POST', 'api/edit_route', ['json' => $data]);
    }

    /**
     * Delete route
     * Deletes a route.
     * 
     * @param int $routeId Route ID
     * @return array Deletion response
     */
    public function destroyRoute(int $routeId)
    {
        return $this->client->request('GET', 'api/destroy_route', ['query' => ['route_id' => $routeId]]);
    }

    /**
     * Change route active status
     * Toggles the active status of a route.
     * 
     * @param int $routeId Route ID
     * @return array Status change response
     */
    public function changeActiveRoute(int $routeId)
    {
        return $this->client->request('GET', 'api/change_active_route', ['query' => ['route_id' => $routeId]]);
    }

    /**
     * Get route groups
     * Retrieves all route groups.
     * 
     * @param array $params Optional parameters
     * @return array List of route groups
     */
    public function getRouteGroups(array $params = [])
    {
        return $this->client->request('GET', 'api/routes_groups', ['query' => $params]);
    }

    /**
     * Create route group
     * Creates a new route group.
     * 
     * @param array $data Group data
     * @return array Created group response
     */
    public function storeRouteGroup(array $data)
    {
        return $this->client->request('POST', 'api/routes_groups/store', ['json' => $data]);
    }

    /**
     * Update route group
     * Updates an existing route group.
     * 
     * @param int $groupId Group ID
     * @param array $data Group data to update
     * @return array Updated group response
     */
    public function updateRouteGroup(int $groupId, array $data)
    {
        return $this->client->request('PUT', "api/routes_groups/update/{$groupId}", ['json' => $data]);
    }
}
