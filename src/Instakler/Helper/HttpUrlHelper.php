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

/**
 * Class HttpUrlHelper
 * @package Instakler\Helper
 */
class HttpUrlHelper
{
    private $clientId;
    private $clientSecret;
    private $accessToken;
    private $clientIp;
    private $config;

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * HttpUrlHelper constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->clientId = $config['client_id'];
        $this->clientSecret = $config['client_secret'];
        $this->accessToken = $config['access_token'];
        $this->clientIp = $config['client_ip'];
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function prepare(array $params)
    {
        $params['client_id'] = $this->clientId;
        if (!empty($this->accessToken)) {
            unset($params['client_id']);
            $params['access_token'] = $this->accessToken;
        }

        foreach ($params as $k => $v) {
            if (!empty($v)) {
                $params[$k] = urlencode($v);
            }
        }

        return $params;
    }

    /**
     * @param $path
     *
     * @return string
     */
    public function formatPath($path)
    {
        $args = func_get_args();
        $path = array_shift($args);
        $args = array_map('urlencode', $args);

        return vsprintf($path, $args);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function buildPath($path)
    {
        $path = sprintf('/%s/', $path);
        $path = preg_replace('/[\/]{2,}/', '/', $path);

        if (!preg_match('/^\/v1/', $path)) {
            $path = '/v1' . $path;
        }

        return rtrim($path, '/');
    }
}

