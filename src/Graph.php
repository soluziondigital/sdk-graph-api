<?php 
namespace Microsoft\Graph;

use Microsoft\Graph\Core\GraphConstants;
use Microsoft\Graph\Http\GraphCollectionRequest;
use Microsoft\Graph\Http\GraphRequest;

class Graph
{
   
    private $_accessToken;
    private $_apiVersion;
    private $_baseUrl;
    private $_proxyPort;

    public function __construct()
    {
        $this->_apiVersion = GraphConstants::API_VERSION;
        $this->_baseUrl = GraphConstants::REST_ENDPOINT;
    }

    public function setBaseUrl($baseUrl)
    {
        $this->_baseUrl = $baseUrl;
        return $this;
    }

    public function setApiVersion($apiVersion)
    {
        $this->_apiVersion = $apiVersion;
        return $this;
    }

    public function setAccessToken($accessToken)
    {
        $this->_accessToken = $accessToken;
        return $this;
    }

    public function setProxyPort($port)
    {
        $this->_proxyPort = $port;
        return $this;
    }

    public function createRequest($requestType, $endpoint)
    {
        return new GraphRequest(
            $requestType, 
            $endpoint, 
            $this->_accessToken, 
            $this->_baseUrl, 
            $this->_apiVersion,
            $this->_proxyPort
        );
    }

    public function createCollectionRequest($requestType, $endpoint)
    {
        return new GraphCollectionRequest(
            $requestType, 
            $endpoint, 
            $this->_accessToken, 
            $this->_baseUrl, 
            $this->_apiVersion,
            $this->_proxyPort
        );
    }
}