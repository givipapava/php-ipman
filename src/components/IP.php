<?php 

namespace GiviPapava\IPMan\components;

class IP {

    const IP_V4 = 'ipv4';
    const IP_V6 = 'ipv6';

    const BIN = 'bin';
    const HEX = 'hex';
    const LONG = 'long';

	const IPV4_OCTETS = 4;
	const IPV6_OCTETS = 16;

	const IP_V4_MAX_PREFIX_LENGTH = 32;
	const IP_V6_MAX_PREFIX_LENGTH = 128;

	const IP_V4_OCTETS = 4;
	const IP_V6_OCTETS = 16;

    /**
     * Checks if an IP is valid.
     *
     * @param String $ip IP
     * @return Boolean, if ip is valid true else false.
    */
    public static function isValidIp($ip)
    {
        $isValidIp = self::getIpVersion($ip);
        if($isValidIp === false) {
            return false;
        }
        return true;
    }

    /**
	 * @param String $ip, $ipType
	 * @return String
	*/
	public static function parse($ip,$ipType)
	{
        switch ($ipType) {
          case self::BIN:
             return self::parseBin($ip);
          case self::HEX:
              return self::parseHex($ip);
          case self::LONG:
              return self::parseLong($ip);
          default:
          return $ip;   
        }	
	}

     /**
     * Checks if  IP is valid IPv4.
     *
     * @param String $ip IP
     * @return Boolean true if ip is valid true else false.
     */
    public static function isV4($ip)
    {
        $isValidv4 = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        return (bool)$isValidv4;
    }

    /**
     * Checks if an IP is valid IPv4 format.
     *
     * @param String $ip IP
     * @return Boolean true if IP is valid IPv6, otherwise false.
    */
    public static function isV6($ip)
    {
        $isValidV6 = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
        return (bool)$isValidV6;
    }

	/**
	 * @param string $ipBin
	 * @return Boolean
	 */
    private static function isValidBinaryFormat($ipBin) {
        return  !preg_match('/^([0-1]{32}|[0-1]{128})$/', $ipBin);
    }

	/**
	 * @param String $ipBin
	 * @return String
	*/
	public static function parseBin($ipBin)
	{ 
        
		if (strpos($ipBin, '0b') === 0) {
			$ipBin = substr($ipBin, 2);
        }
        
		if (self::isValidBinaryFormat($ipBin)) {
			throw new \Exception("Invalid binary IP address format");
		}

		$address = '';
		foreach (array_map('bindec', str_split($ipBin, 8)) as $char) {
			$address .= pack('C*', $char);
		}

		return inet_ntop($address);
	}

    /**
	 * @param String $ip
     * @return String
	 */
    private static function isValidHexFormat($ip) {
        return !preg_match('/^([0-9a-fA-F]{8}|[0-9a-fA-F]{32})$/', $ip);
    }
    
    /**
	 * @param String $ip
	 * @throws \Exception
	 * @return String
	 */
	public static function parseHex($ipHex)
	{
        if (strpos($ipHex, '0x') === 0) {
			$ipHex = substr($ipHex, 2);
		}
		if (self::isValidHexFormat($ipHex)) {
			throw new \Exception("Invalid hexadecimal IP address");
		}

		return inet_ntop(pack('H*', $ipHex));
	}

	/**
	 * @param String  $longIP
	 * @return String
	 */
	public static function parseLong($longIP, $version=self::IP_V4)
	{
		if ($version === self::IP_V4) {
			$ip = long2ip($longIP);
		} else {
			$binary = array();
			for ($i = 0; $i < self::IPV6_OCTETS; $i++) {
				$binary[] = bcmod($longIP, 256);
				$longIP = bcdiv($longIP, 256, 0);
            }
            
			$ip = inet_ntop(call_user_func_array('pack', array_merge(array('C*'), array_reverse($binary))));
		}

		return $ip;
	}


	/**
     * @param String $ip
	 * @return String
	 */
	public static  function getIpVersion($ip)
	{
		$ipVersion = false;

		if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
			$ipVersion = self::IP_V4;
		} elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
			$ipVersion = self::IP_V6;
		}

		return $ipVersion;
	}

	/**
     * @param String $ip
	 * @return Int
	 */
	public static function getMaxPrefixLength($ip)
	{
		return self::getIpVersion($ip) === self::IP_V4
			? self::IP_V4_MAX_PREFIX_LENGTH
			: self::IP_V6_MAX_PREFIX_LENGTH;
	}


	/**
     * @param String $ip
	 * @return Int
	 */
	public static function getOctetsCount($ip)
	{
		return self::getIpVersion($ip) === self::IP_V4
			? self::IP_V4_OCTETS
			: self::IP_V6_OCTETS;
    }
    
    /**
     * @param String $ip
	 * @return Boolean
	 */
    public static  function match($ip, $ranges)
    {
        if (is_array($ranges)) {
            foreach ($ranges as $range) {
                $match = self::compare($ip, $range);
                if ($match) {
                    return true;
                }
            }
        } else {
            return self::compare($ip, $ranges);
        }
        return false;
    }

    /**
     * @param String $ip,$range
	 * @return Boolean
	 */
    private static function compare($ip, $range)
    {
        if (!self::isValidIp($ip)) {
            throw new \InvalidArgumentException('IP "'.$ip.'" is invalid!');
        }

        $status = false;
        if (strpos($range, '/') !== false) {
            $status = self::slashProcessing($ip,$range);
        } else if (strpos($range, '*') !== false) {
            $status = self::asteriskProcessing($ip,$range);
        } else if (strpos($range, '-') !== false) {
            $status = self::minusProcessing($ip,$range);
        } else {
            $status = ($ip === $range);
        }
        return $status;
    }

    /**
     * Gets IP long representation
     *
     * @param String $ip IPv4 or IPv6
     * @return long If IP is valid returns IP long representation, otherwise Boolean  false.
     */
    public static function ip2long($ip)
    {
        $long = false;
        if (self::isV6($ip)) {
            if (!function_exists('bcadd')) {
                throw new \RuntimeException('BCMATH extension not installed!');
            }

            $ip_n = inet_pton($ip);
            $bin = '';
            for ($bit = strlen($ip_n) - 1; $bit >= 0; $bit--) {
                $bin = sprintf('%08b', ord($ip_n[$bit])) . $bin;
            }

            $dec = '0';
            for ($i = 0; $i < strlen($bin); $i++) {
                $dec = bcmul($dec, '2', 0);
                $dec = bcadd($dec, $bin[$i], 0);
            }
            $long = $dec;
        } else if (self::isV4($ip)) {
            $long = ip2long($ip);
        }
        return $long;
    }



    /**
     * @param String $ip IPv4 or IPv6, $range
     * @return Boolean
    */
    private static function slashProcessing($ip, $range)
    {
        list($range, $netmask) = explode('/', $range, 2);

        if (self::getIpVersion($ip) === self::IP_V6) {
            if (strpos($netmask, ':') !== false) {
                $netmask     = str_replace('*', '0', $netmask);
                $netmask_dec = self::parseLong($netmask);
                return ((self::ip2long($ip) & $netmask_dec) == (self::ip2long($range) & $netmask_dec));
            } else {
                $x = explode(':', $range);
                while (count($x) < 8) {
                    $x[] = '0';
                }

                list($a, $b, $c, $d, $e, $f, $g, $h) = $x;
                $range = sprintf(
                    "%u:%u:%u:%u:%u:%u:%u:%u",
                    empty($a) ? '0' : $a,
                    empty($b) ? '0' : $b,
                    empty($c) ? '0' : $c,
                    empty($d) ? '0' : $d,
                    empty($e) ? '0' : $e,
                    empty($f) ? '0' : $f,
                    empty($g) ? '0' : $g,
                    empty($h) ? '0' : $h
                );
                $range_dec           = self::ip2long($range);
                $ip_dec              = self::ip2long($ip);
                $wildcard_dec        = pow(2, (32 - $netmask)) - 1;
                $netmask_dec         = ~$wildcard_dec;

                return (($ip_dec & $netmask_dec) == ($range_dec & $netmask_dec));
            }
        } else {
            if (strpos($netmask, '.') !== false) {
                $netmask     = str_replace('*', '0', $netmask);
                $netmask_dec = self::ip2long($netmask);
                return ((self::ip2long($ip) & $netmask_dec) == (self::ip2long($range) & $netmask_dec));
            } else {
                $x = explode('.', $range);
                while (count($x) < 4) {
                    $x[] = '0';
                }

                list($a, $b, $c, $d) = $x;
                $range               = sprintf("%u.%u.%u.%u", empty($a) ? '0' : $a, empty($b) ? '0' : $b, empty($c) ? '0' : $c, empty($d) ? '0' : $d);
                $range_dec           = self::ip2long($range);
                $ip_dec              = self::ip2long($ip);
                $wildcard_dec        = pow(2, (32 - $netmask)) - 1;
                $netmask_dec         = ~$wildcard_dec;

                return (($ip_dec & $netmask_dec) == ($range_dec & $netmask_dec));
            }
        }

        return false;
    }


    /**
     * @param String $ip IPv4 or IPv6, $range
     * @return Boolean
    */
    private static function asteriskProcessing($ip,$range)
    {
        if (strpos($range, '*') !== false) {
            if (self::getIpVersion($ip) === self::IP_V6) {
                $lower = str_replace('*', '0000', $range);
                $upper = str_replace('*', 'ffff', $range);
            } else {
                $lower = str_replace('*', '0', $range);
                $upper = str_replace('*', '255', $range);
            }
            $range = $lower . '-' . $upper;
        }
        if (strpos($range, '-') !== false) {
            return self::minusProcessing($ip,$range);
        }
        return false;
    }

        /**
     * @param String $ip IPv4 or IPv6, $range
     * @return Boolean
    */
     private static function minusProcessing($ip,$range)
    {
        list($lower, $upper) = explode('-', $range, 2);
        $lower_dec           = self::ip2long($lower);
        $upper_dec           = self::ip2long($upper);
        $ip_dec              = self::ip2long($ip);

        return (($ip_dec >= $lower_dec) && ($ip_dec <= $upper_dec));
    }

	/**
     * @param String $ip
	 * @return String
	 */
	public static function getReversePointer($ip)
	{
		if (self::getIpVersion($ip) === self::IP_V4) {
			$reverseOctets = array_reverse(explode('.',$ip));
			$reversePointer = implode('.', $reverseOctets) . '.in-addr.arpa';
		} else {
			$unpacked = unpack('H*hex', $ip);
			$reverseOctets = array_reverse(str_split($unpacked['hex']));
			$reversePointer = implode('.', $reverseOctets) . '.ip6.arpa';
		}

		return $reversePointer;
    }
    
    public static function ipInRange($ip, $range) {
        if ( strpos( $range, '/' ) == false ) {
            $range .= '/32';
        }
        // $range is in IP/CIDR format eg 127.0.0.1/24
        list( $range, $netmask ) = explode( '/', $range, 2 );
        $randgeDecimal = ip2long( $range );
        $ipDecimal = ip2long( $ip );
        $wildcardDecimal = pow( 2, ( 32 - $netmask ) ) - 1;
        $netmaskDecimal = ~ $wildcardDecimal;
        return ( ( $ipDecimal & $netmaskDecimal ) == ( $randgeDecimal & $netmaskDecimal ) );
    }
}