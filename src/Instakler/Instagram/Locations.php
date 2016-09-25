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
 * Class Locations
 * @package Instakler\Instagram
 */
class Locations
{
    private $http;

    /**
     * Locations constructor.
     *
     * @param HttpClientHelper $httpClientHelper
     */
    public function __construct(HttpClientHelper $httpClientHelper)
    {
        $this->http = $httpClientHelper;
    }

    /**
     * Get information about a location.
     *
     * @scope public_content
     *
     * @param integer $locationId A valid location-id
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function getInformationByLocationId($locationId)
    {
        return $this->http->get('/locations/%s', $locationId);
    }

    /**
     * Get a list of recent media objects from a given location.
     *
     * @scope public_content
     *
     * @param integer $locationId A valid location-id
     * @param integer $maxId      Return media before this min_id.
     * @param integer $minId      Return media after this max_id.
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function getRecentMediaByLocationId($locationId, $maxId = null, $minId = null)
    {
        $args = array();
        if ($maxId !== null) {
            $args['max_id'] = $maxId;
        }

        if ($minId !== null) {
            $args['min_id'] = $minId;
        }

        return $this->http->get('/locations/%s/media/recent', $locationId, $args);
    }

    /**
     * @param double  $lat               	Latitude of the center search coordinate. If used, lng is required.
     * @param double  $lng                  Longitude of the center search coordinate. If used, lat is required.
     * @param integer $distance             Default is 500m (distance=500), max distance is 750.
     * @param integer $facebookPlacesId     Returns a location mapped off of a Facebook places id. If used, lat and lng are not required.
     *
     * @return string
     * @throws \Instakler\Exceptions\InstaklerException
     */
    public function searchByCoordinate($lat, $lng, $distance = 500, $facebookPlacesId = null)
    {
        //TODO: implement a valid constraints of params of this method.
        $args = array(
            'lat' => $lat,
            'lng' => $lng,
            'distance' => $distance,
        );
        if ($facebookPlacesId !== null) {
            $args['facebook_places_id'] = $facebookPlacesId;
        }

        return $this->http->get('/locations/search', '', $args);
    }
}