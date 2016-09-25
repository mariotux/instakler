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
 * Class Relationships
 * @package Instakler\Instagram
 */
class Relationships
{
    private $http;

    /**
     * Relationships constructor.
     *
     * @param HttpClientHelper $httpClientHelper
     */
    public function __construct(HttpClientHelper $httpClientHelper)
    {
        $this->http = $httpClientHelper;
    }

    /**
     * Get the list of users this user follows.
     *
     * @scope follower_list
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function getOwnerFollows()
    {
        return $this->http->get('/users/%s/follows', 'self');
    }

    /**
     * Get the list of users this user is followed by.
     *
     * @scope follower_list
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function getOwnerFollowedBy()
    {
        return $this->http->get('/users/%s/followed-by', 'self');
    }

    /**
     * List the users who have requested this user's permission to follow.
     *
     * @scope follower_list
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function getOwnerRequestedBy()
    {
        return $this->http->get('/users/%s/requested-by', 'self');
    }

    /**
     * Get information about a relationship to another user.
     * Relationships are expressed using the following terms in the response:
     *  - outgoing_status: Your relationship to the user. Can be 'follows', 'requested', 'none'.
     *  - incoming_status: A user's relationship to you. Can be 'followed_by', 'requested_by', 'blocked_by_you', 'none'.
     *
     * @scope follower_list
     *
     * @param integer $userId a valid user Id
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function getRelationshipByUserId($userId)
    {
        return $this->http->get('/users/%s/relationship', $userId);
    }

    /**
     * Modify the relationship between the current user and the target user.
     *
     * @param integer $userId a valid user id
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function doOwnerFollowTo($userId)
    {
        return $this->ownerRelationshipByAction($userId, 'follow');
    }

    /**
     * Modify the relationship between the current user and the target user.
     *
     * @param integer $userId a valid user id
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function doOwnerUnfollowTo($userId)
    {
        return $this->ownerRelationshipByAction($userId, 'unfollow');
    }

    /**
     * Modify the relationship between the current user and the target user.
     *
     * @param integer $userId a valid user id
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function doOwnerApproveTo($userId)
    {
        return $this->ownerRelationshipByAction($userId, 'approve');
    }

    /**
     * Modify the relationship between the current user and the target user.
     *
     * @param integer $userId a valid user id
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function doOwnerIgnoreTo($userId)
    {
        return $this->ownerRelationshipByAction($userId, 'ignore');
    }


    /**
     * Modify the relationship between the current user and the target user.
     * You need to include an action parameter to specify the relationship
     * action you want to perform. Valid actions are: 'follow', 'unfollow'
     * 'approve' or 'ignore'. Relationships are expressed using the following
     * terms in the response:
     *  - outgoing_status: Your relationship to the user. Can be 'follows', 'requested', 'none'.
     *  - incoming_status: A user's relationship to you. Can be 'followed_by', 'requested_by', 'blocked_by_you', 'none'.
     *
     * @param integer $userId a valid user id
     * @param string  $action follow | unfollow | approve | ignore
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    private function ownerRelationshipByAction($userId, $action)
    {
        $args = array('action' => $action);

        return $this->http->post('/users/%s/relationship', $userId, $args);
    }
}
