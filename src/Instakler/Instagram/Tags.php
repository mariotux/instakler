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
 * Class Tags
 * @package Instakler\Instagram
 */
class Tags
{
    private $http;

    /**
     * Tags constructor.
     *
     * @param HttpClientHelper $httpClientHelper
     */
    public function __construct(HttpClientHelper $httpClientHelper)
    {
        $this->http = $httpClientHelper;
    }

    /**
     * Get information about a tag object.
     *
     * @scope public_content
     *
     * @param string $tagName Name of tag
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function getInformationByTag($tagName)
    {
        return $this->http->get('/tags/%s', $tagName);
    }

    /**
     * Get a list of recently tagged media.
     *
     * @scope public_content
     *
     * @param string  $tagName  Name of tag
     * @param integer $count    Count of tagged media to return.
     * @param integer $minTagId Return media before this min_tag_id.
     * @param integer $maxTagId  	Return media after this max_tag_id.
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function getRecentMediaByTag($tagName, $count = null, $minTagId = null, $maxTagId = null)
    {
        $args = array();
        if ($count !== null) {
            $args['count'] = $count;
        }

        if ($maxTagId !== null) {
            $args['max_tag_id'] = $maxTagId;
        }

        if ($minTagId !== null) {
            $args['min_tag_id'] = $minTagId;
        }

        return $this->http->get('/tags/%s/media/recent', $tagName, $args);
    }

    /**
     * Search for tags by name.
     *
     * @scope public_content
     *
     * @param string $name A valid tag name without a leading #. (eg. snowy, nofilter)
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function searchByName($name)
    {
        $args = array("q" => $name);

        return $this->http->get('/tags/search', '', $args);
    }
}