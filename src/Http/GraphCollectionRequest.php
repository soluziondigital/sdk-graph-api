<?php 

namespace Microsoft\Graph\Http;

use Microsoft\Graph\Exception\GraphException;
use Microsoft\Graph\Core\GraphConstants;

class GraphCollectionRequest extends GraphRequest
{
    
    protected $pageSize;
    protected $nextLink;
    protected $deltaLink;
    protected $end;
    protected $originalEndpoint;
    protected $originalReturnType;

    public function __construct($requestType, $endpoint, $accessToken, $baseUrl, $apiVersion, $proxyPort = null)
    {
        parent::__construct(
            $requestType,
            $endpoint,
            $accessToken,
            $baseUrl,
            $apiVersion,
            $proxyPort
        );
        $this->end = false;
    }

    public function count()
    {
        $query = '$count=true';
        $request = new GraphRequest(
            $this->requestType, 
            $this->endpoint . $this->getConcatenator() . $query, 
            $this->accessToken, 
            $this->baseUrl, 
            $this->apiVersion,
            $this->proxyPort
        );
        $result = $request->execute()->getBody();

        if (array_key_exists("@odata.count", $result)) {
            return $result['@odata.count'];
        }

        trigger_error('Count unavailable for this collection');
    }

    public function setPageSize($pageSize)
    {
        if ($pageSize > GraphConstants::MAX_PAGE_SIZE) {
            throw new GraphException(GraphConstants::MAX_PAGE_SIZE_ERROR);
        }
        $this->pageSize = $pageSize;
        return $this;
    }

    public function getPage()
    {
        $this->setPageCallInfo();
        $response = $this->execute();

        return $this->processPageCallReturn($response);
    }

    public function setPageCallInfo() 
    {
        $this->originalReturnType = $this->returnType;

        $this->returnType = null;

        if ($this->end) {
            trigger_error('Reached end of collection');
        }

        if ($this->nextLink) {
            $baseLength = strlen($this->baseUrl) + strlen($this->apiVersion);
            $this->endpoint = substr($this->nextLink, $baseLength);
        } else {
            if ($this->pageSize) {
                $this->endpoint .= $this->getConcatenator() . '$top=' . $this->pageSize;
            }
        }
        return $this;
    }

    public function processPageCallReturn($response)
    {
        $this->nextLink = $response->getNextLink();
        $this->deltaLink = $response->getDeltaLink();

        if (!$this->nextLink) {
            $this->end = true;
        }

        $result = $response->getBody();

        if ($this->originalReturnType) {
            $result = $response->getResponseAsObject($this->originalReturnType);
        }

        $this->returnType = $this->originalReturnType;

        return $result;
    }

    public function isEnd()
    {
        return $this->end;
    }

    public function getDeltaLink()
    {
        return $this->deltaLink;
    }
}