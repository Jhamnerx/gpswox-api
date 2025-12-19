<?php

namespace Gpswox\Resources;

use Gpswox\Wox;

class Command
{
    protected $client;

    public function __construct(Wox $client)
    {
        $this->client = $client;
    }

    /**
     * Get command data
     * Retrieves necessary data for creating a GPRS/SMS command.
     * 
     * @param int $deviceId Device ID
     * @param array $params Optional parameters
     * @return array Command creation data
     */
    public function sendCommandData(int $deviceId, array $params = [])
    {
        $params['device_id'] = $deviceId;
        return $this->client->request('GET', 'api/send_command_data', ['query' => $params]);
    }

    /**
     * Send GPRS command
     * Sends a GPRS command to a device.
     * 
     * @param int $deviceId Device ID
     * @param array $data Command data
     * @return array Command response
     */
    public function sendGprsCommand(int $deviceId, array $data)
    {
        $data['device_id'] = $deviceId;
        return $this->client->request('POST', 'api/send_gprs_command', [
            'multipart' => $this->buildMultipartData($data)
        ]);
    }

    /**
     * Send SMS command
     * Sends an SMS command to a device.
     * 
     * @param int $deviceId Device ID
     * @param array $data Command data
     * @return array Command response
     */
    public function sendSmsCommand(int $deviceId, array $data)
    {
        $data['device_id'] = $deviceId;
        return $this->client->request('POST', 'api/send_sms_command', [
            'multipart' => $this->buildMultipartData($data)
        ]);
    }

    /**
     * Get device commands
     * Retrieves commands sent to a device.
     * 
     * @param int $deviceId Device ID
     * @param array $params Optional parameters
     * @return array Device commands
     */
    public function getDeviceCommands(int $deviceId, array $params = [])
    {
        $params['device_id'] = $deviceId;
        return $this->client->request('GET', 'api/get_device_commands', ['query' => $params]);
    }

    /**
     * Build multipart form data
     * Converts array data to multipart format.
     * 
     * @param array $data Data to convert
     * @return array Multipart data
     */
    protected function buildMultipartData(array $data)
    {
        $multipart = [];
        foreach ($data as $key => $value) {
            $multipart[] = [
                'name' => $key,
                'contents' => is_array($value) ? json_encode($value) : $value
            ];
        }
        return $multipart;
    }
}
