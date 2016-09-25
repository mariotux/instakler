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

use Instakler\Helper\HttpClientHelper;
use Instakler\Transformer\Response;

/**
 * Class Users
 * @package Instakler\Instagram
 */
class Users
{
    private $http;

    /**
     * Users constructor.
     *
     * @param HttpClientHelper $httpClientHelper
     */
    public function __construct(HttpClientHelper $httpClientHelper)
    {
        $this->http = $httpClientHelper;
    }

    /**
     * Get information about the owner of the access_token.
     *
     * @scope basic
     *
     * @return Response
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function getOwnerInformation()
    {
        return $this->http->get('/users/%s', 'self');
    }

    /**
     * Get information about a user. This endpoint requires the
     * public_content scope if the user-id is not the owner of the access_token.
     *
     * @scope public_content
     *
     * @param $userId
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function getInformationByUserId($userId)
    {
        return $this->http->get('/users/%s', $userId);
    }

    /**
     * Get the most recent media published by the owner of the access_token.
     *
     * @scope basic
     *
     * @param integer $count Count of media to return.
     * @param integer $maxId Return media later than this min_id.
     * @param integer $minId Return media earlier than this max_id.
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function getOwnerRecentMedia($count = null, $maxId = null, $minId = null)
    {
        $args = $this->verifyRecentMediaArguments($count, $maxId, $minId);

        return $this->http->get('/users/%s/media/recent', 'self', $args);
    }

    /**
     * Get the most recent media published by a user.
     * This endpoint requires the public_content scope if the user-id is
     * not the owner of the access_token.
     *
     * @scope public_content
     *
     * @param integer $userId valid user-id
     * @param integer $count  Count of media to return.
     * @param integer $maxId  Return media later than this min_id.
     * @param integer $minId  Return media earlier than this max_id.
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function getRecentMediaByUserId($userId, $count = null, $maxId = null, $minId = null)
    {
        $args = $this->verifyRecentMediaArguments($count, $maxId, $minId);

        return $this->http->get('/users/%s/media/recent', $userId, $args);
    }

    /**
     * Get the list of recent media liked by the owner of the access_token.
     *
     * @scope public_content
     *
     * @param integer $count
     * @param integer $maxLikeId
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function getOwnerMediaLiked($count = null, $maxLikeId = null)
    {
        $args = array();
        if ($count !== null) {
            $args['count'] = $count;
        }
        if ($maxLikeId !== null) {
            $args['max_like_id'] = $maxLikeId;
        }

        return $this->http->get('/users/%s/media/liked', 'self', $args);
    }

    /**
     * Get a list of users matching the query.
     *
     * @scope public_content
     *
     * @param string  $query A query string.
     * @param integer $count Number of users to return.
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function getListOfUsersByString($query, $count = null)
    {
        $args = array();
        $args['q'] = $query;

        if ($count !== null) {
            $args['count'] = $count;
        }

        return $this->http->get('/users/search', '', $args);
    }

    private function verifyRecentMediaArguments($count, $maxId, $minId)
    {
        $args = array();
        if ($count !== null) {
            $args['count'] = $count;
        }

        if ($maxId !== null) {
            $args['max_id'] = $maxId;
        }

        if ($minId !== null) {
            $args['min_id'] = $minId;
        }

        return $args;
    }
}