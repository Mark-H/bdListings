<?php
/**
 * bdListings
 *
 * Copyright 2011 by Mark Hamstra <hello@markhamstra.com>
 *
 * This file is part of bdListings, a real estate property listings component
 * for MODX Revolution.
 *
 * bdListings is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * bdListings is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * bdListings; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
*/
class bdlListing extends xPDOSimpleObject {
    /**
    * Gets lat/long values from Google Maps Geocoding API.
    *
    * @return bool
    */
    function getLatLong () {
        /* Verify we at least have some data to work with */
        if (!(
            ($this->get('address') || $this->get('zip')) &&
            ($this->get('city'))
        )) {
            $this->xpdo->log(xPDO::LOG_LEVEL_ERROR,'[bdListings] Not enough data to request latlng from Google Maps for listing "' . $this->get('title') . '". Need at least an address or zip as well as the city.');
            return false;
        }

        /* Google Maps Geocoding URL */
        $apiurl = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false';

        /* Prepare address to send to Google Maps */
        $address = $this->get('address') . ' ' . $this->get('zip') . ' ' . $this->get('city') . ' ' . $this->get('country');
        $address = trim(str_replace('  ',' ',$address));

        $apiurl .= '&address='.urlencode($address);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = $this->xpdo->fromJSON($result);
        if (!is_array($result)) {
            $this->xpdo->log(xPDO::LOG_LEVEL_ERROR,'[bdListings] Error retrieving latlng data from Google Maps for listing "' . $this->get('title') . '": response invalid. Used URL: '.$apiurl);
            return false;
        }

        if ($result['status'] != 'OK') {
            $this->xpdo->log(xPDO::LOG_LEVEL_ERROR,'[bdListings] Error retrieving latlng data from Google Maps for listing "' . $this->get('title') . '": '.$result['status'].' Used URL: '.$apiurl);
            return false;
        }

        $result = $result['results'][0];

        if (isset($result['geometry']) && isset($result['geometry']['location'])) {
            $lat = $result['geometry']['location']['lat'];
            $long = $result['geometry']['location']['lng'];

            $this->set('latitude',$lat);
            $this->set('longitude',$long);
            return true;
        } else {
            $this->xpdo->log(xPDO::LOG_LEVEL_ERROR,'[bdListings] Error retrieving latlng data from Google Maps for listing "' . $this->get('title') . '": no lat/long variables found in response. Used URL: '.$apiurl);
            return false;
        }
    }
}
?>