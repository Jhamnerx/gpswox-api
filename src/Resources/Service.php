<?php

namespace Gpswox\Resources;

use Gpswox\Wox;

class Service
{
    protected $client;

    public function __construct(Wox $client)
    {
        $this->client = $client;
    }

    /**
     * Get services
     * Retrieves all services for a device.
     * 
     * @param int $deviceId Device ID
     * @param array $params Optional parameters
     * @return array List of services
     */
    public function getServices(int $deviceId, array $params = [])
    {
        $params['device_id'] = $deviceId;
        return $this->client->request('GET', 'api/get_services', ['query' => $params]);
    }

    /**
     * Get data to add service
     * Retrieves necessary data for creating a service.
     * 
     * @param int $deviceId Device ID
     * @param array $params Optional parameters
     * @return array Service creation data
     */
    public function addServiceData(int $deviceId, array $params = [])
    {
        $params['device_id'] = $deviceId;
        return $this->client->request('GET', 'api/add_service_data', ['query' => $params]);
    }

    /**
     * Create service
     * Creates a new service for a device.
     * 
     * @param array $data Service data
     * @return array Created service response
     */
    public function addService(array $data)
    {
        return $this->client->request('POST', 'api/add_service', ['json' => $data]);
    }

    /**
     * Get data to edit service
     * Retrieves necessary data for editing a service.
     * 
     * @param int $serviceId Service ID
     * @param array $params Optional parameters
     * @return array Service edit data
     */
    public function editServiceData(int $serviceId, array $params = [])
    {
        $params['service_id'] = $serviceId;
        return $this->client->request('GET', 'api/edit_service_data', ['query' => $params]);
    }

    /**
     * Edit service
     * Updates an existing service.
     * 
     * @param int $serviceId Service ID
     * @param array $data Service data to update
     * @return array Updated service response
     */
    public function editService(int $serviceId, array $data)
    {
        $data['service_id'] = $serviceId;
        return $this->client->request('POST', 'api/edit_service', ['json' => $data]);
    }

    /**
     * Delete service
     * Deletes a service.
     * 
     * @param int $serviceId Service ID
     * @return array Deletion response
     */
    public function destroyService(int $serviceId)
    {
        return $this->client->request('GET', 'api/destroy_service', ['query' => ['service_id' => $serviceId]]);
    }
}
