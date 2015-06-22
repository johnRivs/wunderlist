<?php namespace JohnRivs\Wunderlist;

use GuzzleHttp\Client as HttpClient;

class Wunderlist {

    use Authorization,
        Avatar,
        Lists,
        Subtask,
        Task,
        User,
        Webhook;

    /**
     * Base URL for the Wunderlist API.
     * 
     * @var string
     */
    protected $baseUrl = 'http://a.wunderlist.com/api/v1/';

    /**
     * HTTP status code returned by each request.
     * 
     * @var int
     */
    protected $statusCode;

    /**
     * HTTP Client.
     * 
     * @var Guzzlehttp\Client
     */
    protected $http;

    /**
     * The Wunderlist app client id.
     * 
     * @var string
     */
    public $clientId;

    /**
     * The Wunderlist app client secret.
     * 
     * @var string
     */
    public $clientSecret;

    /**
     * The Wunderlist app access token.
     * 
     * @var string
     */
    protected $accessToken;

    public function __construct(HttpClient $http, $clientId, $clientSecret, $accessToken)
    {
        $this->http         = $http;
        $this->clientId     = $clientId;
        $this->clientSecret = $clientSecret;
        $this->accessToken  = $accessToken;
    }

    public function call($httpMethod, $endpoint, array $parameters = [])
    {
        // Every request to the Wunderlist API
        // must provide the app client id
        // and access token.
        $parameters = array_merge($parameters, [
            'headers' => [
                'X-Client-ID'    => $this->clientId,
                'X-Access-Token' => $this->accessToken
            ]
        ]);

        // We build the request
        // passing any parameter (if any).
        $request = $this->http->createRequest($httpMethod, $this->baseUrl . $endpoint, $parameters);

        // We send the request.
        $response = $this->http->send($request);

        // We store the returned HTTP status code
        // in case it's needed.
        $this->statusCode = $response->getStatusCode();

        // Finally, we return the contents of the response.
        return $response->json();
    }

    /**
     * Get the HTTP status code from the last response.
     * 
     * @return int
     */
    public function getStatusCode()
    {
        if (empty($this->statusCode)) throw new \Exception('An HTTP status code has not been set. Make sure you ask for this AFTER you make a request to the API.');

        return $this->statusCode;
    }
    
}
