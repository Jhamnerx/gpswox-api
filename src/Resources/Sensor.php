<?php

namespace Gpswox\Resources;

use Gpswox\Wox;

class Sensor
{
    protected $client;

    public function __construct(Wox $client)
    {
        $this->client = $client;
    }

    /**
     * Get sensors
     * Retrieves all sensors for a device.
     * 
     * @param int $deviceId Device ID
     * @param array $params Optional parameters
     * @return array List of sensors
     */
    public function getSensors(int $deviceId, array $params = [])
    {
        $params['device_id'] = $deviceId;
        return $this->client->request('GET', 'api/get_sensors', ['query' => $params]);
    }

    /**
     * Get data to add sensor
     * Retrieves necessary data for creating a sensor.
     * 
     * @param int $deviceId Device ID
     * @param array $params Optional parameters
     * @return array Sensor creation data
     */
    public function addSensorData(int $deviceId, array $params = [])
    {
        $params['device_id'] = $deviceId;
        return $this->client->request('GET', 'api/add_sensor_data', ['query' => $params]);
    }

    /**
     * Create sensor
     * Creates a new sensor for a device.
     * 
     * @param array $data Sensor data
     * @return array Created sensor response
     */
    public function addSensor(array $data)
    {
        return $this->client->request('POST', 'api/add_sensor', ['json' => $data]);
    }

    /**
     * Get data to edit sensor
     * Retrieves necessary data for editing a sensor.
     * 
     * @param int $sensorId Sensor ID
     * @param array $params Optional parameters
     * @return array Sensor edit data
     */
    public function editSensorData(int $sensorId, array $params = [])
    {
        $params['sensor_id'] = $sensorId;
        return $this->client->request('GET', 'api/edit_sensor_data', ['query' => $params]);
    }

    /**
     * Edit sensor
     * Updates an existing sensor.
     * 
     * @param int $sensorId Sensor ID
     * @param array $data Sensor data to update
     * @return array Updated sensor response
     */
    public function editSensor(int $sensorId, array $data)
    {
        $data['sensor_id'] = $sensorId;
        return $this->client->request('POST', 'api/edit_sensor', ['json' => $data]);
    }

    /**
     * Delete sensor
     * Deletes a sensor.
     * 
     * @param int $sensorId Sensor ID
     * @return array Deletion response
     */
    public function destroySensor(int $sensorId)
    {
        return $this->client->request('GET', 'api/destroy_sensor', ['query' => ['sensor_id' => $sensorId]]);
    }
}
