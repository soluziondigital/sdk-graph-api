<?php 
namespace Microsoft\Graph\Http;

use Microsoft\Graph\Exception\GraphException;
use Microsoft\Graph\Core\GraphConstants;

class GraphResponse
{
    private $_body;
    private $_decodedBody;
    private $_headers;
    private $_httpStatusCode;

    public function __construct($request, $body = null, $httpStatusCode = null, $headers = null)
    {
        $this->_request = $request;
        $this->_body = $body;
        $this->_httpStatusCode = $httpStatusCode;
        $this->_headers = $headers;
        $this->_decodedBody = $this->_decodeBody();
    }

    private function _decodeBody()
    {
        $decodedBody = json_decode($this->_body, true);
        if ($decodedBody === null) {
            $decodedBody = array();
        }
        return $decodedBody;
    }

    public function getBody()
    {
        return $this->_decodedBody;
    }

    public function getRawBody()
    {
        return $this->_body;
    }

    public function getStatus()
    {
        return $this->_httpStatusCode;
    }

    public function getHeaders()
    {
        return $this->_headers;
    }

    public function getResponseAsObject($returnType)
    {
        $class = $returnType;
        $result = $this->getBody();

        if ($returnType == "GuzzleHttp\Psr7\Stream") {
              return $this->_body;  
        }

        if (array_key_exists('value', $result)) {
            $objArray = array();
            $values = $result['value'];

            if ($values && is_array($values)) {
                foreach ($values as $obj) {
                    $objArray[] = new $class($obj);
                }
            } else {
                return new $class($result);
            }
            return $objArray;
        } else {
            return new $class($result);
        }
    }

    public function getNextLink()
    {
        if (array_key_exists("@odata.nextLink", $this->getBody())) {
            $nextLink = $this->getBody()['@odata.nextLink'];
            return $nextLink;
        }
        return null;
    }
    
    public function getDeltaLink()
    {
        if (array_key_exists("@odata.deltaLink", $this->getBody())) {
            $deltaLink = $this->getBody()['@odata.deltaLink'];
            return $deltaLink;
        }
        return null;
    }
}