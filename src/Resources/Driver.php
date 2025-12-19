<?php

namespace Gpswox\Resources;

use Gpswox\Wox;

class Driver
{
    protected $client;

    public function __construct(Wox $client)
    {
        $this->client = $client;
    }

    /**
     * Get user drivers
     * Retrieves all drivers for the user.
     * 
     * @param array $filters Optional filters
     * @return array List of drivers
     */
    public function getUserDrivers(array $filters = [])
    {
        return $this->client->request('GET', 'api/get_user_drivers', ['query' => $filters]);
    }

    /**
     * Get data to add driver
     * Retrieves necessary data for creating a driver.
     * 
     * @param array $params Optional parameters
     * @return array Driver creation data
     */
    public function addUserDriverData(array $params = [])
    {
        return $this->client->request('GET', 'api/add_user_driver_data', ['query' => $params]);
    }

    /**
     * Create driver
     * Creates a new driver.
     * 
     * @param array $data Driver data
     * @return array Created driver response
     */
    public function addUserDriver(array $data)
    {
        return $this->client->request('POST', 'api/add_user_driver', ['json' => $data]);
    }

    /**
     * Get data to edit driver
     * Retrieves necessary data for editing a driver.
     * 
     * @param int $driverId Driver ID
     * @param array $params Optional parameters
     * @return array Driver edit data
     */
    public function editUserDriverData(int $driverId, array $params = [])
    {
        $params['driver_id'] = $driverId;
        return $this->client->request('GET', 'api/edit_user_driver_data', ['query' => $params]);
    }

    /**
     * Edit driver
     * Updates an existing driver.
     * 
     * @param int $driverId Driver ID
     * @param array $data Driver data to update
     * @return array Updated driver response
     */
    public function editUserDriver(int $driverId, array $data)
    {
        $data['driver_id'] = $driverId;
        return $this->client->request('POST', 'api/edit_user_driver', ['json' => $data]);
    }

    /**
     * Delete driver
     * Deletes a driver.
     * 
     * @param int $driverId Driver ID
     * @return array Deletion response
     */
    public function destroyUserDriver(int $driverId)
    {
        return $this->client->request('GET', 'api/destroy_user_driver', ['query' => ['driver_id' => $driverId]]);
    }
}
