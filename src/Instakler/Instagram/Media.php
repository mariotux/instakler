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
 * Class Media
 * @package Instakler\Instagram
 */
class Media
{
    private $http;

    /**
     * Media constructor.
     *
     * @param HttpClientHelper $httpClientHelper
     */
    public function __construct(HttpClientHelper $httpClientHelper)
    {
        $this->http = $httpClientHelper;
    }

    /**
     * Get information about a media object. Use the type field to differentiate
     * between image and video media in the response. You will also receive the
     * user_has_liked field which tells you whether the owner of the access_token
     * has liked this media. The public_content permission scope is required to
     * get a media that does not belong to the owner of the access_token.
     *
     * @scope basic, public_content
     *
     * @param integer $mediaId A valid media-id
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function getById($mediaId)
    {
        return $this->http->get('/media/%s', $mediaId);
    }

    /**
     * This endpoint returns the same response as GET /media/media-id.
     * A media object's shortcode can be found in its shortlink URL.
     * An example shortlink is http://instagram.com/p/tsxp1hhQTG/.
     * Its corresponding shortcode is tsxp1hhQTG.
     *
     * @scope basic, public_content
     *
     * @param string $shortCode A valid shortcode
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function getByShortcode($shortCode)
    {
        return $this->http->get('/media/%s', $shortCode);
    }

    /**
     * Search for recent media in a given area.
     *
     * @scope public_content
     *
     * @param double $lat      Latitude of the center search coordinate. If used, lng is required.
     * @param double $lng      Longitude of the center search coordinate. If used, lat is required.
     * @param int    $distance Default is 1km (distance=1000), max distance is 5km.
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function search($lat, $lng, $distance = 1000)
    {
        $args = array(
            'lat' => $lat,
            'lng' => $lng,
            'distance' => $distance,
        );

        return $this->http->get('/media/search', '', $args);
    }
}