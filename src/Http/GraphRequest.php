<?php 

namespace Microsoft\Graph\Http;

use GuzzleHttp\Client;
use Microsoft\Graph\Core\GraphConstants;
use Microsoft\Graph\Exception\GraphException;

class GraphRequest
{
    protected $accessToken;
    protected $apiVersion;
    protected $baseUrl;
    protected $endpoint;
    protected $guzzleClient;
    protected $headers;
    protected $requestBody;
    protected $requestType;
    protected $returnsStream;
    protected $returnType;
    protected $timeout;
    protected $proxyPort;

    public function __construct($requestType, $endpoint, $accessToken, $baseUrl, $apiVersion, $proxyPort = null)
    {
        $this->requestType = $requestType;
        $this->endpoint = $endpoint;
        $this->accessToken = $accessToken;

        if (!$this->accessToken) {
            throw new GraphException(GraphConstants::NO_ACCESS_TOKEN);
        }

        $this->baseUrl = $baseUrl;
        $this->apiVersion = $apiVersion;
        $this->timeout = 0;
        $this->headers = $this->_getDefaultHeaders();
        $this->proxyPort = $proxyPort;
    }

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        $this->headers['Authorization'] = 'Bearer ' . $this->accessToken;
        return $this;
    }

    public function setReturnType($returnClass)
    {
        $this->returnType = $returnClass;
        if ($this->returnType == "GuzzleHttp\Psr7\Stream") {
            $this->returnsStream  = true;
        } else {
            $this->returnsStream = false;
        }
        return $this;
    }

    public function addHeaders($headers)
    {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function attachBody($obj)
    {
        if (is_string($obj) || is_a($obj, 'GuzzleHttp\\Psr7\\Stream')) {
            $this->requestBody = $obj;
        }
        else {
            $this->requestBody = json_encode($obj);
        }
        return $this;
    }

    public function getBody()
    {
        return $this->requestBody;
    }

    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    public function execute($client = null)
    {
        if (is_null($client)) {
            $client = $this->createGuzzleClient($this->proxyPort);
        }

        $result = $client->request(
            $this->requestType, 
            $this->_getRequestUrl(), 
            [
                'body' => $this->requestBody,
                'stream' =>  $this->returnsStream,
                'timeout' => $this->timeout
            ]
        );

        $response = new GraphResponse(
            $this, 
            $result->getBody(), 
            $result->getStatusCode(), 
            $result->getHeaders()
        );

        $returnObj = $response;

        if ($this->returnType) {
            $returnObj = $response->getResponseAsObject($this->returnType);
        }
        return $returnObj; 
    }

    public function executeAsync($client = null)
    {
        if (is_null($client)) {
            $client = $this->createGuzzleClient($this->proxyPort);
        }

        $promise = $client->requestAsync(
            $this->requestType,
            $this->_getRequestUrl(),
            [
                'body' => $this->requestBody,
                'stream' => $this->returnsStream,
                'timeout' => $this->timeout
            ]
        )->then(
            function ($result) {
                $response = new GraphResponse(
                    $this, 
                    $result->getBody(), 
                    $result->getStatusCode(), 
                    $result->getHeaders()
                );
                $returnObject = $response;
                if ($this->returnType) {
                    $returnObject = $response->getResponseAsObject(
                        $this->returnType
                    );
                }
                return $returnObject;
            },
            function ($reason) {
                trigger_error("Async call failed: " . $reason->getMessage());
                return null;
            }
        );
        return $promise;
    }

    public function download($path, $client = null)
    {
        if (is_null($client)) {
            $client = $this->createGuzzleClient();
        }
        try {
            $file = fopen($path, 'w');
            if (!$file) {
                throw new GraphException(GraphConstants::INVALID_FILE);
            }

            $client->request(
                $this->requestType, 
                $this->_getRequestUrl(), 
                [
                    'body' => $this->requestBody,
                    'sink' => $file
                ]
            );
            if(is_resource($file)){
                fclose($file);
            }
            
        } catch(GraphException $e) {
            throw new GraphException(GraphConstants::INVALID_FILE);
        }

        return null;
    }

    public function upload($path, $client = null)
    {
        if (is_null($client)) {
            $client = $this->createGuzzleClient();
        }
        try {
            if (file_exists($path) && is_readable($path)) {
                $file = fopen($path, 'r');
                $stream = \GuzzleHttp\Psr7\stream_for($file);
                $this->requestBody = $stream;
                return $this->execute($client);
            } else {
                throw new GraphException(GraphConstants::INVALID_FILE);
            }
        } catch(GraphException $e) {
            throw new GraphException(GraphConstants::INVALID_FILE);
        }
    }

    private function _getDefaultHeaders()
    {
        $headers = [
            'Host' => $this->baseUrl,
            'Content-Type' => 'application/json',
            'SdkVersion' => 'Graph-php-' . GraphConstants::SDK_VERSION,
            'Authorization' => 'Bearer ' . $this->accessToken
        ];
        return $headers;
    }

    private function _getRequestUrl()
    {
        if (stripos($this->endpoint, "http") === 0) {
            return $this->endpoint;
        }

        return $this->apiVersion . $this->endpoint;
    }

    protected function getConcatenator()
    {
        if (stripos($this->endpoint, "?") === false) {
            return "?";
        }
        return "&";
    }

    protected function createGuzzleClient($proxyPort = null)
    { 
        $clientSettings = [
            'base_uri' => $this->baseUrl,
            'headers' => $this->headers
        ];
        if ($proxyPort != null) {
            $clientSettings['verify'] = false;
            $clientSettings['proxy'] = $proxyPort;
        } 
        $client = new Client($clientSettings);
        
        return $client;
    }
}
