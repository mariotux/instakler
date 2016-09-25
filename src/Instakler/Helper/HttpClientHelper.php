<?php
/**
 * The MIT License (MIT)
 * Copyright © 2016 Mario Nunes <instakler@marionunes.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the “Software”), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author Mario Nunes <instakler@marionunes.com>
 * @filesource
 */
namespace Instakler\Helper;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Instakler\Exceptions\ResponseException;
use Instakler\Exceptions\InstaklerException;
use Instakler\Transformer\Headers;
use Instakler\Transformer\Response;

/**
 * Class HttpClientHelper
 * @package Instakler\Helper
 */
class HttpClientHelper
{
    private $httpClient;
    private $httpUrlHelper;


    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->httpUrlHelper->getConfig();
    }
    /**
     * HttpClientHelper constructor.
     *
     * @param Client        $httpClient
     * @param HttpUrlHelper $httpUrlHelper
     */
    public function __construct(Client $httpClient, HttpUrlHelper $httpUrlHelper)
    {
        $this->httpClient = $httpClient;
        $this->httpUrlHelper = $httpUrlHelper;
    }

    /**
     * @param string $endPoint
     * @param string $userId
     * @param null   $args
     *
     * @return string
     * @throws InstaklerException
     */
    public function get($endPoint, $userId = 'self', $args = null)
    {
        if ($args !== null) {
            $params = $args;
        } else {
            $params = [];
        }
        $headers = [];
        $path = $this->httpUrlHelper->formatPath($endPoint, $userId);
        $query = $this->httpUrlHelper->prepare($params);
        $uri = $this->httpUrlHelper->buildPath($path);
        try {
            $response = $this->httpClient->get($uri, [
                'query' => $query,
                'headers' => $headers
            ]);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        } catch (ServerException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new InstaklerException($e->getMessage(), $e->getCode(), $e);
        }
        $contents = $response->getBody()->getContents();

        return new Response($contents, $response, new Headers(), new ResponseException());
    }

    /**
     * @param string $endPoint
     * @param string $userId
     * @param null   $args
     *
     * @return string
     * @throws InstaklerException
     */
    public function post($endPoint, $userId = 'self', $args = null)
    {
        //TODO: write a tested method for send a post to an endpoint of api
        if ($args !== null) {
            $params = $args;
        } else {
            $params = [];
        }
        $headers = [];
        $path = $this->httpUrlHelper->formatPath($endPoint, $userId);
        $query = $this->httpUrlHelper->prepare($params);
        $uri = $this->httpUrlHelper->buildPath($path);
        try {
            $response = $this->httpClient->post($uri, [
                'body' => $query,
                'headers' => $headers
            ]);
        } catch (RequestException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new InstaklerException($e->getMessage(), $e->getCode(), $e);
        }
        $contents = $response->getBody()->getContents();

        return new Response($contents, $response, new Headers(), new ResponseException());
    }

    public function delete($endPoint, $userId = 'self', $args = null)
    {
        //TODO: write a tested method for send a delete to an endpoint of api
        if ($args !== null) {
            $params = $args;
        } else {
            $params = [];
        }
        $headers = [];
        $path = $this->httpUrlHelper->formatPath($endPoint, $userId);
        $query = $this->httpUrlHelper->prepare($params);
        $uri = $this->httpUrlHelper->buildPath($path);
        try {
            $response = $this->httpClient->delete($uri, [
                'body' => $query,
                'headers' => $headers
            ]);
        } catch (RequestException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new InstaklerException($e->getMessage(), $e->getCode(), $e);
        }
        $contents = $response->getBody()->getContents();

        return new Response($contents, $response, new Headers(), new ResponseException());
    }

    /**
     * @param string $endPoint
     * @param array  $data
     *
     * @return Response
     * @throws InstaklerException
     */
    public function auth($endPoint, $data)
    {
        try {
            $response = $this->httpClient->post($endPoint, [
                'form_params' => $data
            ]);
        } catch (RequestException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new InstaklerException($e->getMessage(), $e->getCode(), $e);
        }
        $contents = $response->getBody()->getContents();

        return new Response($contents, $response, new Headers(), new ResponseException());
    }
}

