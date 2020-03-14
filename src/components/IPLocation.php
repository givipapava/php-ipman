<?php

namespace GiviPapava\IPMan\components;

use GeoIp2\Database\Reader;

class IPLocation
{

    /**
     * @param $ip String
     * @return Object | Boolean
     */
    public static function  getGeoDataLocation($ip)
    {

        $reader = new Reader(dirname(__FILE__) . '../../../data/GeoLite2-City.mmdb');
        $record = $reader->city($ip);
        if ($record) {
            return  json_encode([
                "ip" => $ip,
                "iso_code" => $record->country->isoCode,
                "country" => $record->country->name,
                "city" => $record->city->name,
                "sub_division" => $record->mostSpecificSubdivision->name,
                "latitude" => $record->location->latitude,
                "longitude" => $record->location->longitude,
                "network " => $record->traits->network
            ]);
        }
        return false;
    }


    /**
     * @param $ip String
     * @return Object | Boolean
     */
    public static function  getIPLatitureAndLongitute($ip)
    {

        $reader = new Reader(dirname(__FILE__) . '../../../data/GeoLite2-City.mmdb');
        $record = $reader->city($ip);
        if ($record) {
            return  json_encode([
                "ip" => $ip,
                "longitude" => $record->location->longitude,
                "network " => $record->traits->network
            ]);
        }
        return false;
    }
}
