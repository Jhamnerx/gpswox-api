<?php

namespace Gpswox\Resources;

use Gpswox\Wox;

class Address
{
    protected $client;

    public function __construct(Wox $client)
    {
        $this->client = $client;
    }

    /**
     * Get address
     * Retrieves address information or geofence data.
     * 
     * @param array $params Parameters (latitude, longitude, etc.)
     * @return array Address information
     */
    public function getAddress(array $params = [])
    {
        return $this->client->request('GET', 'api/address', ['query' => $params]);
    }

    /**
     * Autocomplete address
     * Provides autocomplete suggestions for addresses.
     * 
     * @param string $query Search query
     * @param array $params Additional parameters
     * @return array Autocomplete suggestions
     */
    public function autocomplete(string $query, array $params = [])
    {
        $params['query'] = $query;
        return $this->client->request('GET', 'api/address/autocomplete', ['query' => $params]);
    }

    /**
     * Reverse geocoding
     * Converts coordinates (latitude, longitude) to an address.
     * 
     * @param float $latitude Latitude
     * @param float $longitude Longitude
     * @param array $params Additional parameters
     * @return array Address information
     */
    public function reverse(float $latitude, float $longitude, array $params = [])
    {
        $params['latitude'] = $latitude;
        $params['longitude'] = $longitude;
        return $this->client->request('GET', 'api/address/reverse', ['query' => $params]);
    }

    /**
     * Search address
     * Searches for addresses matching a query.
     * 
     * @param string $query Search query
     * @param array $params Additional parameters
     * @return array Search results
     */
    public function search(string $query, array $params = [])
    {
        $params['query'] = $query;
        return $this->client->request('GET', 'api/address/search', ['query' => $params]);
    }
}
