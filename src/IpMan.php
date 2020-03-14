<?php

namespace GiviPapava\IPMan;

use GiviPapava\IPMan\components\IP;
use GiviPapava\IPMan\components\IPLocation;
use GiviPapava\IPMan\components\Network;

/**
 * @author GiviPapava <givi.papava12@gmail.com>
 * @link https://github.com/givipapava/php-ipman
 */

class IPMan
{
    /**
     * @Desc checks if ip address is valid
     * @Usage:
     *    @example1: $ipMan->isValidIp('162.168.1.1');
     *    @example2: $ipMan->isValidIp('162.168.1.321')
     * @Result:
     *     @result1: Boolan true;
     *     @result2: Boolan false;
     * @param String $ip,
     * @static
     * @return Boolean, if ip is valid true else false.
     */
    public  function isValidIp($ip)
    {
        return IP::isValidIp($ip);
    }

    /**
     * @Desc It takes an ip address and parses it to hex,bin or long
     * @Usage:
     *    @example1: $ipMan->parse('2130706433','long');
     *    @example2: $ipMan->parse('11000100101010000100000100100001','bin');
     *    @example3:  $ipMan->parse('0b002001','hex');
     * @Result:
     *     @result1: String "127.0.0.1";
     *     @result2: "196.168.65.33";
     *     @result3: "10.0.32.1";
     * @param String $ip,
     * @param String $ipType,
     * @static
     * @return String $ip.
     */
    public static function parse($ip, $ipType)
    {
        return IP::parse($ip, $ipType);
    }

    /**
     * @Desc checks if IP is valid IPv4.
     * @Usage:
     *    @example1: $ipMan->isV4('182.168.1.1');
     *    @example2: $ipMan->isV4('2001:db8:0:1:1:1:1:1')
     * @Result:
     *     @result1: Boolan true;
     *     @result2: Boolan false;
     * @param String $ip IP
     * @static
     * @return Boolean true if ip is valid v4 else false.
     */
    public static function isV4($ip)
    {
        return IP::isV4($ip);
    }

    /**
     * @Desc checks if IP is valid IPv6.
     * @Usage:
     *    @example1: $ipMan->isV4('182.168.1.1');
     *    @example2: $ipMan->isV4('2001:db8:0:1:1:1:1:1')
     * @Result:
     *     @result1: Boolan false;
     *     @result2: Boolan true;
     * @param String $ip IP
     * @static
     * @return Boolean true if ip is valid v6 else false.
     */
    public static function isV6($ip)
    {
        return IP::isV6($ip);
    }

    /**
     * @Desc it parses ip to bin
     * @Usage:
     *    @example: $ipMan->parseBin('11000100101010000100000100100001');
     *    @Result:  String "196.168.65.33";
     * @param String $ip 
     * @static
     * @return String 
     */
    public static function parseBin($ip)
    {
        return IP::parseBin($ip);
    }

    /**
     * @Desc it parses ip to hex
     * @Usage:
     *    @example: $ipMan->parseHex('0a002001');
     *    @Result:  String 10.0.32.1;
     * @param String $ip 
     * @static
     * @return String 
     */
    public static function parseHex($ip)
    {
        return IP::parseHex($ip);
    }

    /**
     * @Desc it parses ip to long
     * @Usage:
     *    @example: $ipMan->parseLong('2130706433');
     *    @Result:  String 127.0.0.1;
     * @param String $ip 
     * @static
     * @return String 
     */
    public static function parseLong($ip)
    {
        return IP::parseLong($ip);
    }


    /**
     * @Desc Get ip version
     * @Usage:
     *    @example1: $ipMan->getIpVersion('182.168.1.1');
     *    @example2: $ipMan->getIpVersion('2001:db8:0:1:1:1:1:1');
     * @Result: 
     *   @result1: String ipv4;
     *   @result2: String ipv6;
     * @param String $ip 
     * @static
     * @return String 
     */
    public static  function getIpVersion($ip)
    {
        return IP::getIpVersion($ip);
    }

    /**
     * @Desc Get max prefix length
     * @Usage:
     *    @example:$ipMan->getMaxPrefixLength('2001:db8:0:1:1:1:1:1');
     *    @result: 128;
     * @param String $ip 
     * @static
     * @return String 
     */
    public function getMaxPrefixLength($ip)
    {
        return IP::getMaxPrefixLength($ip);
    }

    /**
     * @Desc Get  octets count
     * @Usage:
     *    @example:$ipMan->getOctetsCount('2001:db8:0:1:1:1:1:1');
     *    @result: 16;
     * @param String $ip 
     * @static
     * @return String 
     */
    public function getOctetsCount($ip)
    {
        return IP::getOctetsCount($ip);
    }

    /**
     * @Desc Checks if an IP is part of an IP range
     * @Usage:
     *    @example1: $ipMan->match('162.128.1.1', '162.128.1.*');
     *    @example2: $ipMan->match('162.128.1.1', '162.128.0.*'); 
     * @Result:
     *   @result1: true
     *   @result2: false
     * @param String $ip 
     * @param String $ranges 
     * @static
     * @return String 
     */
    public  function match($ip, $ranges)
    {
        return IP::match($ip, $ranges);
    }


    /**
     * @Usage:
     *    @example:$ipMan->getReversePointer('162.128.1.1');
     *    @result: 1.1.128.162.in-addr.arpa
     * @param String $ip 
     * @static
     * @return String 
     */
    public function getReversePointer($ip)
    {
        return IP::getReversePointer($ip);
    }

    /**
     * @Desc Check if a given ip is in a network
     * @param  String $ip    IP to check in IPV4 format eg. 127.0.0.1
     * @param  String $range IP/CIDR netmask eg. 127.0.0.0/24, also 127.0.0.1 is accepted and /32 assumed
     * @return Boolean true if the ip is in this range / false if not.
     */
    public function ipInRange($ip, $range)
    {
        return IP::ipInRange($ip, $range);
    }

    /**
     * @desc Get location info by ip
     * @example $ipMan->getIpLocation($ip)
     * @result  [
                "ip" => $ip,
                "iso_code" =>  $iso_code,
                "country"=> $country,
                "city" => $city,
                "sub_division" => $sub_division,
                "latitude" => $latitude,
                "longitude" =>  $longitude,
                "network" => $network
    ];
     * @param String $ip
     * @return String | Object
     */
    public function getIpLocation($ip)
    {
        return IPLocation::getGeoDataLocation($ip);
    }

    /**
     * @desc Get location info by ip
     * @example $ipMan->getIpLocation($ip)
     * @result  [
                "latitude" => $latitude,
                "longitude" =>  $longitude,
    ];
     * @param String $ip
     * @return String | Object
     */
    public function getIPLatitureAndLongitute($ip)
    {
        return IPLocation::getIPLatitureAndLongitute($ip);
    }

    /**
     * 	@Usage:
     *     @example $ipMan->cidrToMask(22);
     *     @result string(13) "255.255.252.0"
     * @param Int $number;
     * Return a netmask string if given an integer between 0 and 32. 
     * @return String Netmask ip address
     */
    public function cidrToMask($number)
    {
        return Network::cidrToMask($number);
    }

    /**
     * 
     * @Usage:
     *     $ipMan->countSetBits(ip2long('255.255.252.0'));
     * @Result:
     *     int(22)
     * @param Int $number;
     * Return a netmask string if given an integer between 0 and 32. 
     * @return String int number of bits set.
     */
    public function countSetbits($number)
    {
        return Network::countSetbits($number);
    }

    /**
     *   Usage:
     *    $ipMan->validNetMask('255.255.252.0');
     *    $ipMan->validNetMask('127.0.0.1');
     * Result:
     *     bool(true)
     *     bool(false)
     * @param String $netmask   
     * @return Boolean True if a valid netmask.
     */
    public static function validNetMask($netmask)
    {
        return Network::validNetMask($netmask);
    }

    /**
     *   Usage:
     *    $ipMan->maskToCidr('255.255.252.0');
     * Result:
     *     int(22)
     * @patam String $netmask
     * @return Int CIDR number
     */
    public static function  maskToCidr($netmask)
    {
        return Network::maskToCidr($netmask);
    }

    /**
     * method alignedCIDR.
     * It takes an ip address and a netmask and returns a valid CIDR
     * block.
     * Usage:
     *     $ipMan->alignedCIDR('127.0.0.1','255.255.252.0');
     * Result:
     *     string(12) "127.0.0.0/22"
     * @param $ip String a IPv4 formatted ip address.
     * @param $netmask String a 1pv4 formatted ip address.
     * @static
     * @return String CIDR block.
     */
    public static function alignedCIDR($ip, $netmask)
    {
        return Network::alignedCdr($ip, $netmask);
    }
}
