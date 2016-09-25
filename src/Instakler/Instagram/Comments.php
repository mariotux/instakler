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
 * Class Comments
 * @package Instakler\Instagram
 */
class Comments
{
    private $http;

    /**
     * Comments constructor.
     *
     * @param HttpClientHelper $httpClientHelper
     */
    public function __construct(HttpClientHelper $httpClientHelper)
    {
        $this->http = $httpClientHelper;
    }

    /**
     * Get a list of recent comments on a media object. The
     * public_content permission scope is required to get comments
     * for a media that does not belong to the owner of the access_token.
     *
     * @scope basic, public_content
     *
     * @param integer $mediaId A valid media-id
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function getByMediaId($mediaId)
    {
        return $this->http->get('/media/%s/comments', $mediaId);
    }

    /**
     * Create a comment on a media object with the following rules:
     *    - The total length of the comment cannot exceed 300 characters.
     *    - The comment cannot contain more than 4 hashtags.
     *    - The comment cannot contain more than 1 URL.
     *    - The comment cannot consist of all capital letters.
     * The public_content permission scope is required to create comments
     * on a media that does not belong to the owner of the access_token.
     *
     * @scope comments
     *
     * @param string  $text    Text to post as a comment on the media object as specified in media-id.
     * @param integer $mediaId A valid media-id
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function createInMediaId($text, $mediaId)
    {
        //TODO: validate text with constrains of comment of this method
        $args = array('text' => $text);

        return $this->http->post('/media/%s/comments', $mediaId, $args);
    }

    /**
     * Remove a comment either on the authenticated user's media object
     * or authored by the authenticated user.
     *
     * @scope comments
     *
     * @param integer $commentId a valid comment-id
     * @param integer $mediaId   a valid media-id
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function removeCommentIdInMediaId($commentId, $mediaId)
    {
        return $this->http->delete('/media/%s/comments/'.$mediaId, $commentId);
    }
}