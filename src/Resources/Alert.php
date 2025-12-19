<?php

namespace Gpswox\Resources;

use Gpswox\Wox;

class Alert
{
    protected $client;

    public function __construct(Wox $client)
    {
        $this->client = $client;
    }

    /**
     * Get protocols
     * Retrieves available device protocols.
     * 
     * @return array List of protocols
     */
    public function getProtocols()
    {
        return $this->client->request('GET', 'api/get_protocols');
    }

    /**
     * Get alerts
     * Retrieves all alerts.
     * 
     * @param array $filters Optional filters
     * @return array List of alerts
     */
    public function getAlerts(array $filters = [])
    {
        return $this->client->request('GET', 'api/get_alerts', ['query' => $filters]);
    }

    /**
     * Get data to add alert
     * Retrieves necessary data for creating a new alert.
     * 
     * @param array $params Optional parameters
     * @return array Alert creation data
     */
    public function addAlertData(array $params = [])
    {
        return $this->client->request('GET', 'api/add_alert_data', ['query' => $params]);
    }

    /**
     * Create alert
     * Creates a new alert.
     * 
     * @param array $data Alert data
     * @return array Created alert response
     */
    public function addAlert(array $data)
    {
        return $this->client->request('POST', 'api/add_alert', ['json' => $data]);
    }

    /**
     * Get data to edit alert
     * Retrieves necessary data for editing an alert.
     * 
     * @param int $alertId Alert ID
     * @param array $params Optional parameters
     * @return array Alert edit data
     */
    public function editAlertData(int $alertId, array $params = [])
    {
        $params['alert_id'] = $alertId;
        return $this->client->request('GET', 'api/edit_alert_data', ['query' => $params]);
    }

    /**
     * Edit alert
     * Updates an existing alert.
     * 
     * @param int $alertId Alert ID
     * @param array $data Alert data to update
     * @return array Updated alert response
     */
    public function editAlert(int $alertId, array $data)
    {
        $data['alert_id'] = $alertId;
        return $this->client->request('POST', 'api/edit_alert', ['json' => $data]);
    }

    /**
     * Delete alert
     * Deletes an alert.
     * 
     * @param int $alertId Alert ID
     * @return array Deletion response
     */
    public function destroyAlert(int $alertId)
    {
        return $this->client->request('GET', 'api/destroy_alert', ['query' => ['alert_id' => $alertId]]);
    }

    /**
     * Change alert active status
     * Toggles the active status of an alert.
     * 
     * @param int $alertId Alert ID
     * @return array Status change response
     */
    public function changeActiveAlert(int $alertId)
    {
        return $this->client->request('GET', 'api/change_active_alert', ['query' => ['alert_id' => $alertId]]);
    }

    /**
     * Get custom events by device
     * Retrieves custom events for a specific device.
     * 
     * @param int $deviceId Device ID
     * @param array $params Optional parameters
     * @return array Custom events
     */
    public function getCustomEventsByDevice(int $deviceId, array $params = [])
    {
        $params['device_id'] = $deviceId;
        return $this->client->request('GET', 'api/get_custom_events_by_device', ['query' => $params]);
    }

    /**
     * Set alert devices
     * Associates devices with an alert.
     * 
     * @param int $alertId Alert ID
     * @param array $deviceIds Array of device IDs
     * @return array Response
     */
    public function setAlertDevices(int $alertId, array $deviceIds)
    {
        return $this->client->request('GET', 'api/set_alert_devices', [
            'query' => [
                'alert_id' => $alertId,
                'device_ids' => $deviceIds
            ]
        ]);
    }

    /**
     * Get device alerts
     * Retrieves alerts for a specific device.
     * 
     * @param int $deviceId Device ID
     * @param array $params Optional parameters
     * @return array Device alerts
     */
    public function getDeviceAlerts(int $deviceId, array $params = [])
    {
        return $this->client->request('GET', "api/devices/{$deviceId}/alerts", ['query' => $params]);
    }

    /**
     * Set alert time period
     * Sets when alerts are active from and/or to.
     * 
     * @param int $deviceId Device ID
     * @param int $alertId Alert ID
     * @param array $data Time period data
     * @return array Response
     */
    public function setAlertTimePeriod(int $deviceId, int $alertId, array $data)
    {
        return $this->client->request('POST', "api/devices/{$deviceId}/alerts/{$alertId}/time_period", [
            'json' => $data
        ]);
    }

    /**
     * Get events by protocol
     * Retrieves events filtered by protocol.
     * 
     * @param string $protocol Protocol identifier
     * @param array $params Optional parameters
     * @return array Events
     */
    public function getEventsByProtocol(string $protocol, array $params = [])
    {
        $params['protocol'] = $protocol;
        return $this->client->request('GET', 'api/get_events_by_protocol', ['query' => $params]);
    }

    /**
     * Get alerts attributes
     * Retrieves alert attributes configuration.
     * 
     * @param array $params Optional parameters
     * @return array Alert attributes
     */
    public function getAlertsAttributes(array $params = [])
    {
        return $this->client->request('GET', 'api/get_alerts_attributes', ['query' => $params]);
    }

    /**
     * Get alerts commands
     * Retrieves available alert commands.
     * 
     * @param array $params Optional parameters
     * @return array Alert commands
     */
    public function getAlertsCommands(array $params = [])
    {
        return $this->client->request('GET', 'api/get_alerts_commands', ['query' => $params]);
    }

    /**
     * Get alerts summary
     * Retrieves summary of alerts.
     * 
     * @param array $params Optional parameters
     * @return array Alerts summary
     */
    public function getAlertsSummary(array $params = [])
    {
        return $this->client->request('GET', 'api/get_alerts_summary', ['query' => $params]);
    }
}
