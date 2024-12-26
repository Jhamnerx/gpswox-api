<?php

namespace Gpswox;

use Gpswox\Exceptions\ApiException;
use GuzzleHttp\Client as HttpClient;
use Gpswox\Exceptions\AuthenticationException;

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
}
