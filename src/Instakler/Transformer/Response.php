<?php
namespace Instakler\Transformer;

use Instakler\Exceptions\ResponseException;

/**
 * Class Response
 * @package Instakler\Transformer
 */
class Response
{
    private $guzzleReponse;
    private $headers;
    private $data;
    private $responeException;

    /**
     * @return \GuzzleHttp\Psr7\Response
     */
    public function getGuzzleResponse()
    {
        return $this->guzzleReponse;
    }

    /**
     * @return Headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Response constructor.
     *
     * @param                           $contents
     * @param \GuzzleHttp\Psr7\Response $response
     * @param Headers                   $headers
     * @param ResponseException         $responseException
     */
    public function __construct($contents, \GuzzleHttp\Psr7\Response $response, Headers $headers, ResponseException $responseException)
    {
        $this->contents = $contents;
        $this->responeException = $responseException;
        $this->responeException->check($response);
        $this->guzzleReponse = $response;
        $this->headers = $headers;
        $this->headers->setHeaders($this->guzzleReponse->getHeaders());
        $this->parseResponseBody();
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->guzzleReponse->getStatusCode();
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    private function parseResponseBody()
    {
        $contents = json_decode($this->contents, true);
        if (isset($contents['data'])) {
            $this->data = $contents['data'];
        } else {
            $this->data = $contents;
        }

        unset($contentsJson, $contents);
    }
}
