<?php

namespace Gpswox;

use Gpswox\Exceptions\ApiException;
use GuzzleHttp\Client as HttpClient;
use Gpswox\Exceptions\AuthenticationException;
use Gpswox\Resources\Setup;
use Gpswox\Resources\Device;
use Gpswox\Resources\History;
use Gpswox\Resources\Alert;
use Gpswox\Resources\Sensor;
use Gpswox\Resources\Service;
use Gpswox\Resources\Geofence;
use Gpswox\Resources\Route;
use Gpswox\Resources\Report;
use Gpswox\Resources\MapIcon;
use Gpswox\Resources\Driver;
use Gpswox\Resources\Command;
use Gpswox\Resources\Event;
use Gpswox\Resources\CustomEvent;
use Gpswox\Resources\Task;
use Gpswox\Resources\GprsTemplate;
use Gpswox\Resources\SmsTemplate;
use Gpswox\Resources\Sharing;
use Gpswox\Resources\Address;
use Gpswox\Resources\CallAction;

class Wox
{
    protected $baseUri;
    protected $apiHash;
    protected $httpClient;

    public function __construct(string $baseUri, string $apiHash = null)
    {
        $this->baseUri = $baseUri;
        $this->apiHash = $apiHash;
        $this->httpClient = new HttpClient([
            'base_uri' => $this->baseUri,
            'timeout' => 10,
        ]);
    }

    // public function request(string $method, string $uri, array $options = [])
    // {
    //     $options['query']['user_api_hash'] = $this->apiHash;

    //     try {
    //         $response = $this->httpClient->request($method, $uri, $options);
    //         return json_decode($response->getBody()->getContents(), true);
    //     } catch (\Exception $e) {
    //         throw new ApiException($e->getMessage(), $e->getCode());
    //     }
    // }

    /**
     * Sends a request to the specified URI using the given HTTP method and options.
     *
     * @param string $method The HTTP method to use for the request (e.g., 'GET', 'POST').
     * @param string $uri The URI to send the request to.
     * @param array $options Optional parameters to include in the request (e.g., headers, query parameters).
     * @return mixed The response from the request.
     */
    public function request(string $method, string $uri, array $options = [])
    {
        $options['query']['user_api_hash'] = $this->apiHash;

        try {
            $response = $this->httpClient->request($method, $uri, $options);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\GuzzleHttp\Exception\ClientException $e) {

            $statusCode = $e->getResponse()->getStatusCode();
            $body = json_decode($e->getResponse()->getBody()->getContents(), true);

            if ($statusCode === 400) {
                throw new ApiException('Error', $statusCode);
            } elseif ($statusCode === 401) {
                throw new AuthenticationException($body['message'], $statusCode);
            } else {
                throw new ApiException($e->getMessage(), $statusCode);
            }
        } catch (\GuzzleHttp\Exception\ServerException $e) {
            throw new ApiException('Internal Server Error', 500);
        }
    }

    /**
     * Logs in and retrieves the API hash.
     *
     * @param string $username The username for login.
     * @param string $password The password for login.
     * @return string The API hash.
     * @throws AuthenticationException If the login fails.
     */
    public function login(string $email, string $password): string
    {
        $response = $this->request('POST', 'api/login', [
            'query' => [
                'email' => $email,
                'password' => $password,
            ],
        ]);

        if (isset($response['user_api_hash'])) {
            $this->apiHash = $response['user_api_hash'];
            return $this->apiHash;
        }

        throw new AuthenticationException('Login failed: invalid response from server.');
    }

    /**
     * Get Setup resource instance
     *
     * @return Setup
     */
    public function setup(): Setup
    {
        return new Setup($this);
    }

    /**
     * Get Device resource instance
     *
     * @return Device
     */
    public function device(): Device
    {
        return new Device($this);
    }

    /**
     * Get History resource instance
     *
     * @return History
     */
    public function history(): History
    {
        return new History($this);
    }

    /**
     * Get Alert resource instance
     *
     * @return Alert
     */
    public function alert(): Alert
    {
        return new Alert($this);
    }

    /**
     * Get Sensor resource instance
     *
     * @return Sensor
     */
    public function sensor(): Sensor
    {
        return new Sensor($this);
    }

    /**
     * Get Service resource instance
     *
     * @return Service
     */
    public function service(): Service
    {
        return new Service($this);
    }

    /**
     * Get Geofence resource instance
     *
     * @return Geofence
     */
    public function geofence(): Geofence
    {
        return new Geofence($this);
    }

    /**
     * Get Route resource instance
     *
     * @return Route
     */
    public function route(): Route
    {
        return new Route($this);
    }

    /**
     * Get Report resource instance
     *
     * @return Report
     */
    public function report(): Report
    {
        return new Report($this);
    }

    /**
     * Get MapIcon resource instance
     *
     * @return MapIcon
     */
    public function mapIcon(): MapIcon
    {
        return new MapIcon($this);
    }

    /**
     * Get Driver resource instance
     *
     * @return Driver
     */
    public function driver(): Driver
    {
        return new Driver($this);
    }

    /**
     * Get Command resource instance
     *
     * @return Command
     */
    public function command(): Command
    {
        return new Command($this);
    }

    /**
     * Get Event resource instance
     *
     * @return Event
     */
    public function event(): Event
    {
        return new Event($this);
    }

    /**
     * Get CustomEvent resource instance
     *
     * @return CustomEvent
     */
    public function customEvent(): CustomEvent
    {
        return new CustomEvent($this);
    }

    /**
     * Get Task resource instance
     *
     * @return Task
     */
    public function task(): Task
    {
        return new Task($this);
    }

    /**
     * Get GprsTemplate resource instance
     *
     * @return GprsTemplate
     */
    public function gprsTemplate(): GprsTemplate
    {
        return new GprsTemplate($this);
    }

    /**
     * Get SmsTemplate resource instance
     *
     * @return SmsTemplate
     */
    public function smsTemplate(): SmsTemplate
    {
        return new SmsTemplate($this);
    }

    /**
     * Get Sharing resource instance
     *
     * @return Sharing
     */
    public function sharing(): Sharing
    {
        return new Sharing($this);
    }

    /**
     * Get Address resource instance
     *
     * @return Address
     */
    public function address(): Address
    {
        return new Address($this);
    }

    /**
     * Get CallAction resource instance
     *
     * @return CallAction
     */
    public function callAction(): CallAction
    {
        return new CallAction($this);
    }
}
