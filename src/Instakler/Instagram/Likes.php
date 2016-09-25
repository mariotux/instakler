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

/**
 * Class Likes
 * @package Instakler\Instagram
 */
class Likes
{
    private $http;

    /**
     * Likes constructor.
     *
     * @param HttpClientHelper $httpClientHelper
     */
    public function __construct(HttpClientHelper $httpClientHelper)
    {
        $this->http = $httpClientHelper;
    }

    /**
     * Get a list of users who have liked this media
     *
     * @scope basic, public_content
     *
     * @param integer $mediaId A valid media-id
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function getUsersByMediaId($mediaId)
    {
        return $this->http->get('/media/%s/comments', $mediaId);
    }

    /**
     * Set a like on this media by the currently authenticated user.
     * The public_content permission scope is required to create likes
     * on a media that does not belong to the owner of the access_token.
     *
     * @scope likes
     *
     * @param integer $mediaId A valid media-id
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function addToMediaId($mediaId)
    {
        return $this->http->post('/media/%s/likes', $mediaId);
    }

    /**
     * Remove a like on this media by the currently authenticated user.
     * The public_content permission scope is required to delete likes on
     * a media that does not belong to the owner of the access_token.
     *
     * @scope likes
     *
     * @param integer $mediaId A valid media-id
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function removeFromMediaId($mediaId)
    {
        return $this->http->delete('/media/%s/likes'.$mediaId);
    }
}