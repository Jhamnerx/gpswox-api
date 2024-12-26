<?php

namespace Gpswox\Resources;

use Gpswox\Wox;
use Gpswox\Exceptions\ApiException;
use Gpswox\Exceptions\AuthenticationException;

class Device
{
    protected $client;

    public function __construct(Wox $client)
    {
        $this->client = $client;
    }

    // 1. List Get Devices
    public function listDevices(array $filters = [])
    {
        try {
            return $this->client->request('GET', 'api/get_devices', ['query' => $filters]);
        } catch (AuthenticationException $e) {
            // Manejar error de autenticación
            throw $e;
        } catch (ApiException $e) {
            // Manejar otros errores de API
            throw $e;
        }
    }

    // 2. Get a Get Devices Latest
    public function getDevicesLatest()
    {
        return $this->client->request('GET', 'api/get_devices_latest');
    }

    // 3. List Add Device Data
    public function listAddDeviceData()
    {
        return $this->client->request('GET', 'api/add_device_data');
    }

    // 4. Create a Add Device
    public function createDevice(array $data)
    {
        return $this->client->request('POST', 'api/add_device', ['json' => $data]);
    }

    // 5. List Edit Device Data
    public function listEditDeviceData(int $deviceId)
    {
        return $this->client->request('GET', 'api/edit_device_data', ['query' => ['device_id' => $deviceId]]);
    }

    // 6. Create a Edit Device
    public function editDevice(int $deviceId, array $data)
    {
        return $this->client->request('POST', 'api/edit_device', [
            'query' => ['device_id' => $deviceId],
            'json' => $data,
        ]);
    }

    // 7. Get a Destroy Device
    public function destroyDevice(int $deviceId)
    {
        return $this->client->request('GET', 'api/destroy_device', ['query' => ['device_id' => $deviceId]]);
    }

    // 8. Get a Change Active Device
    public function changeActiveDevice(int $deviceId)
    {
        return $this->client->request('GET', 'api/change_active_device', ['query' => ['device_id' => $deviceId]]);
    }

    // 9. Get device groups list
    public function listDeviceGroups()
    {
        return $this->client->request('GET', 'api/device_groups_list');
    }

    // 10. Create device group
    public function createDeviceGroup(array $data)
    {
        return $this->client->request('POST', 'api/create_device_group', ['json' => $data]);
    }

    // 11. Update device group
    public function updateDeviceGroup(int $groupId, array $data)
    {
        return $this->client->request('PUT', 'api/update_device_group', [
            'query' => ['group_id' => $groupId],
            'json' => $data,
        ]);
    }
}
