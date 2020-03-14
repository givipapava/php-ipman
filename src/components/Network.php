<?php 

namespace GiviPapava\IPMan\components;


class Network {


    /**
     * @param Int $number;
	 * Return a netmask string if given an integer between 0 and 32. 
	 * @return String Netmask ip address
	 */
    public static function cidrToMask($number) {
        return long2ip(-1 << (32 - (int)$number));
    }

    /**
     * @param Int $number;
	 * Return a netmask string if given an integer between 0 and 32. 
	 * @return String int number of bits set.
	 */
	public static function countSetbits($number){
		$number = $number & 0xFFFFFFFF;
		$number = ( $number & 0x55555555 ) + ( ( $number >> 1 ) & 0x55555555 ); 
		$number = ( $number & 0x33333333 ) + ( ( $number >> 2 ) & 0x33333333 );
		$number = ( $number & 0x0F0F0F0F ) + ( ( $number >> 4 ) & 0x0F0F0F0F );
		$number = ( $number & 0x00FF00FF ) + ( ( $number >> 8 ) & 0x00FF00FF );
		$number = ( $number & 0x0000FFFF ) + ( ( $number >>16 ) & 0x0000FFFF );
		$number = $number & 0x0000003F;
		return $number;
	}

	/**
     * @param String $netmask   
	 * @return Boolean True if a valid netmask.
	 */
    public static function validNetMask($netmask){
		$netmask = ip2long($netmask);
        if($netmask === false) 
        return false;
		$neg = ((~(int)$netmask) & 0xFFFFFFFF);
		return (($neg + 1) & $neg) === 0;
    }
    
    /**
     * @patam String $netmask
	 * @return Int CIDR number
	 */
    public static function maskToCidr($netmask){
		if(self::validNetMask($netmask)){
			return self::countSetBits(ip2long($netmask));
		}
		else {
			throw new \Exception('Invalid Netmask');
		}
    }
    
        
    /**
     * @patam String $ip,$netmask
	 * @return String 
	 */
    public static function alignedCdr($ip,$netmask){
		$alignedIP = long2ip((ip2long($ip)) & (ip2long($netmask)));
		return "$alignedIP/" . self::maskToCidr($netmask);
	}


}