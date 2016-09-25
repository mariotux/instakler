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
namespace Instakler;

use GuzzleHttp\Client;
use Instakler\Exceptions\InstaklerException;
use Instakler\Exceptions\InvalidEndpointException;
use Instakler\Instagram\Users;
use Instakler\Instagram\Relationships;
use Instakler\Instagram\Media;
use Instakler\Instagram\Comments;
use Instakler\Instagram\Likes;
use Instakler\Instagram\Tags;
use Instakler\Instagram\Locations;
use Instakler\Instagram\Authorization;
use Instakler\Helper\HttpClientHelper;
use Instakler\Helper\HttpUrlHelper;
use Instakler\Transformer\ResponseException;
use Monolog\Logger;

/**
 * Class Instakler
 *
 * @method Users            getUsers
 * @method Relationships    getRelationships
 * @method Media            getMedia
 * @method Comments         getComments
 * @method Likes            getLikes
 * @method Tags             getTags
 * @method Locations        getLocations
 * @method Authorization    getAuthorization
 *
 * @package Instakler
 */
class Instakler
{
    private static $endPoints;
    private static $availableEndPoints = ["users", "relationships", "media", "comments", "likes", "tags", "locations", "authorization"];
    private $config;

    public function __construct(array $config = [])
    {
        $ua = sprintf('Instakler/1.0; cURL/%s; (+http://instakler.com)', curl_version()['version']);
        $defaults = [
            'client_id'	=> '',
            'client_secret' => '',
            'access_token' => '',
            'redirect_uri' => '',
            'client_ip' => '',
            'scope' => 'comments+relationships+likes',
            'http_useragent' => $ua,
            'http_timeout' => 6,
            'http_connect_timeout' => 2,
            'verify' => true,
            'debug' => false
        ];
        $this->config = array_merge($defaults, $config);

        if(empty($this->config['client_id'])) {
            throw new InstaklerException('Invalid client id');
        }
    }

    /**
     * @return bool
     */
    public function isAuthorized()
    {
        return !empty($this->config['access_token']);
    }

    /**
     * @param string $endPoint
     * @param mixed  $arguments
     * @return object
     * @throws InvalidEndpointException
     */
    public function __call($endPoint, $arguments = null)
    {
        $endPoint = strtolower(substr($endPoint, 3, strlen($endPoint)));
        $className = ucfirst($endPoint);
        if (in_array($endPoint, static::$availableEndPoints, true)) {
            if ($this->dontExistsInstanceOfEndPoint($endPoint)) {
                $httpClient = new Client([
                    'base_uri' => 'https://api.instagram.com',
                    'defaults' => [
                        'timeout' => $this->config['http_timeout'],
                        'connect_timeout' => $this->config['http_connect_timeout'],
                        'headers' => [ 'User-Agent' => $this->config['http_useragent'] ],
                        'verify' => $this->config['verify'],
                        'exceptions' => false,
                        'cookies' => true,
                    ]
                ]);
                $httpUrlHelper = new HttpUrlHelper($this->config);
                $httpClientHelper = new HttpClientHelper($httpClient, $httpUrlHelper);
                $reflectionClass = new \ReflectionClass('Instakler\\Instagram\\' . $className);
                $object = $reflectionClass->newInstanceArgs([$httpClientHelper]);
                static::$endPoints[$endPoint] = $object;
            }

            return static::$endPoints[$endPoint];
        }
        throw new InvalidEndpointException("{$endPoint} is not a valid endpoint");
    }

    private function dontExistsInstanceOfEndPoint($endPoint)
    {
        return !(in_array(strtolower($endPoint), static::$availableEndPoints, true) && isset(static::$endPoints[strtolower($endPoint)])); //&& static::$endPoints[$endPoint] instanceof Instagram\Instagram;
    }

}
