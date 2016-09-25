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
namespace Instakler\Instagram;

use Instakler\Exceptions\InstaklerException;
use Instakler\Helper\HttpClientHelper;

/**
 * Class Authorization
 * @package Instakler\Instagram
 */
class Authorization
{
    private $http;
    private $config;
    private $accessToken;
    private $user;

    /**
     * @return array | null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string | null
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return sprintf('https://api.instagram.com/oauth/authorize/?client_id=%s&redirect_uri=%s&scope=%s&response_type=code',
            $this->config['client_id'],
            urlencode($this->config['redirect_uri']),
            $this->config['scope']);
    }

    /**
     * Authorization constructor.
     *
     * @param HttpClientHelper $httpClientHelper
     */
    public function __construct(HttpClientHelper $httpClientHelper)
    {
        $this->http = $httpClientHelper;
        $this->config = $httpClientHelper->getConfig();
        $this->accessToken = null;
        $this->user = null;
    }

    /**
     * @param string $code
     *
     * @return string
     * @throws InstaklerException
     */
    public function ask($code)
    {
        $data = [
            'client_id' => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'redirect_uri' => $this->config['redirect_uri'],
            'grant_type' => 'authorization_code',
            'code' => $code
        ];

        $response = $this->http->auth('/oauth/access_token', $data);

        if ($response->getStatusCode() === 200) {
            $data = $response->getData();
            if (isset($data['access_token'])) {
                $this->accessToken = $data['access_token'];
                $this->user = ['user'];
                return true;
            }
        }
        return false;
    }


}