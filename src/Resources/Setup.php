<?php

namespace Gpswox\Resources;

use Gpswox\Wox;

class Setup
{
    protected $client;

    public function __construct(Wox $client)
    {
        $this->client = $client;
    }

    /**
     * Get data to edit account settings
     * Retrieves comprehensive account setup data including user information,
     * timezone settings, units configuration, and various setup options.
     * 
     * @param string|null $lang Optional language parameter
     * @param array $additionalParams Additional parameters for the request
     * @return array The setup data response containing:
     *   - item: User account information
     *   - timezones: Available timezone options
     *   - units_of_distance: Distance unit options (km, mi)
     *   - units_of_capacity: Capacity unit options (lt, gl)
     *   - units_of_altitude: Altitude unit options (mt, ft)
     *   - groups: User groups
     *   - sms_queue_count: SMS queue count
     *   - request_method_select: SMS gateway request methods
     *   - encoding_select: Encoding options
     *   - authentication_select: Authentication options
     *   - dst_types: Daylight saving time types
     *   - months: Month options
     *   - weekdays: Weekday names
     *   - week_pos: Week position options
     *   - dst_countries: Countries with DST
     *   - status: Response status
     */
    public function getEditSetupData(string $lang = null, array $additionalParams = [])
    {
        $query = $additionalParams;

        if ($lang !== null) {
            $query['lang'] = $lang;
        }

        return $this->client->request('GET', 'api/edit_setup_data', [
            'query' => $query,
        ]);
    }

    /**
     * Update account setup/settings
     * Updates various account settings including user preferences,
     * timezone, units, and SMS gateway configuration.
     * 
     * @param array $data The setup data to update, can include:
     *   - email: User email
     *   - password: User password
     *   - lang: Language preference
     *   - timezone_id: Timezone ID
     *   - unit_of_distance: Distance unit (km, mi)
     *   - unit_of_capacity: Capacity unit (lt, gl)
     *   - unit_of_altitude: Altitude unit (mt, ft)
     *   - map_id: Default map ID
     *   - sms_gateway: SMS gateway setting
     *   - sms_gateway_url: SMS gateway URL
     *   - sms_gateway_params: SMS gateway parameters
     * @return array The response from the update operation
     */
    public function updateSetupData(array $data)
    {
        return $this->client->request('POST', 'api/edit_setup_data', [
            'json' => $data,
        ]);
    }

    /**
     * Get available timezones
     * Retrieves the list of available timezones for account setup.
     * 
     * @return array List of timezones with id and value
     */
    public function getTimezones()
    {
        $response = $this->getEditSetupData();
        return $response['timezones'] ?? [];
    }

    /**
     * Get available distance units
     * Retrieves the list of available distance units.
     * 
     * @return array List of distance units (km, mi)
     */
    public function getDistanceUnits()
    {
        $response = $this->getEditSetupData();
        return $response['units_of_distance'] ?? [];
    }

    /**
     * Get available capacity units
     * Retrieves the list of available capacity units.
     * 
     * @return array List of capacity units (lt, gl)
     */
    public function getCapacityUnits()
    {
        $response = $this->getEditSetupData();
        return $response['units_of_capacity'] ?? [];
    }

    /**
     * Get available altitude units
     * Retrieves the list of available altitude units.
     * 
     * @return array List of altitude units (mt, ft)
     */
    public function getAltitudeUnits()
    {
        $response = $this->getEditSetupData();
        return $response['units_of_altitude'] ?? [];
    }

    /**
     * Get SMS gateway configuration options
     * Retrieves the available SMS gateway configuration options.
     * 
     * @return array SMS gateway configuration data including:
     *   - request_method_select: Available request methods
     *   - encoding_select: Available encoding options
     *   - authentication_select: Authentication options
     */
    public function getSmsGatewayOptions()
    {
        $response = $this->getEditSetupData();
        return [
            'request_methods' => $response['request_method_select'] ?? [],
            'encoding_options' => $response['encoding_select'] ?? [],
            'authentication_options' => $response['authentication_select'] ?? [],
        ];
    }

    /**
     * Get DST (Daylight Saving Time) configuration options
     * Retrieves DST configuration options including types, months, weekdays, etc.
     * 
     * @return array DST configuration data
     */
    public function getDstOptions()
    {
        $response = $this->getEditSetupData();
        return [
            'dst_types' => $response['dst_types'] ?? [],
            'months' => $response['months'] ?? [],
            'weekdays' => $response['weekdays'] ?? [],
            'week_pos' => $response['week_pos'] ?? [],
            'dst_countries' => $response['dst_countries'] ?? [],
        ];
    }

    /**
     * Get user account information
     * Retrieves the current user account information from setup data.
     * 
     * @return array User account information
     */
    public function getUserInfo()
    {
        $response = $this->getEditSetupData();
        return $response['item'] ?? [];
    }

    /**
     * Get current user timezone
     * Retrieves the timezone currently selected by the user, with both id and value.
     * 
     * @return array|null Current timezone with 'id' and 'value', or null if not found
     */
    public function getCurrentTimezone()
    {
        $response = $this->getEditSetupData();

        $userInfo = $response['item'] ?? [];
        $timezones = $response['timezones'] ?? [];

        // Get the user's selected timezone_id
        $userTimezoneId = $userInfo['timezone_id'] ?? null;

        if ($userTimezoneId === null) {
            return null;
        }

        // Find the timezone in the list that matches the user's timezone_id
        foreach ($timezones as $timezone) {
            if (isset($timezone['id']) && (string)$timezone['id'] === (string)$userTimezoneId) {
                return [
                    'id' => $timezone['id'],
                    'value' => $timezone['value']
                ];
            }
        }

        return null;
    }
}
