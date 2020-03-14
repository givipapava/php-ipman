# php-ipman
Useful IP tools for php
# Permissions

Created By: Givi Papava   
Version: 1.0 <br>
Language: PHP <br>

### Change Log

| Name | Version | Description | Date |
| :---: | --- | --- | --- |
| PHP ip tools | 1.0.0 | In development | 03-14-2020|

## Usage
### IP
```php
$loader =  require __DIR__.'/vendor/autoload.php';
use GiviPapava\IPMan\IPMan;

$ipMan = new IPMan();
// Check if ip is valid
echo  $ipMan->isValidIp('162.168.1.321'); // true, false

// parse, combined parseLong,parseBin and parseHex
echo $ipMan->parse('2130706433','long'); //  127.0.0.1
 
echo $ipMan->parse('11000100101010000100000100100001','bin'); // 196.168.65.33
 
echo $ipMan->parse('0b002001','hex'); // 10.0.32.1

// checks if IP is valid IPv4.
echo $ipMan->isV4('182.168.1.1'); //true

// checks if IP is valid IPv6.
echo $ipMan->isV6('2001:db8:0:1:1:1:1:1'); //true

// parselong
echo $ipMan->parseLong('2130706433'); //  127.0.0.1

// parseBin
 echo $ipMan->parseBin('11000100101010000100000100100001'); // 196.168.65.33

// parseHex
echo $ipMan->parseHex('0a002001'); // 10.0.32.1

// Get ip version
echo $ipMan->getIpVersion('182.168.1.1'); // ipv4
echo $ipMan->getIpVersion('2001:db8:0:1:1:1:1:1'); //  ipv6
 
// ReversePointer 

echo $ipMan->getReversePointer('182.0.2.5'); // 5.2.0.182.in-addr.arpa
 
echo $ipMan->getReversePointer('162.128.1.1'); // 1.1.128.162.in-addr.arpa
 

// MaxLengthPrefix

echo $ipMan->getMaxPrefixLength('2001:db8:0:1:1:1:1:1'); // 128

 //  octetsCount
echo $ipMan->getOctetsCount('2001:db8:0:1:1:1:1:1'); // 16
 
// Match
 
echo  $ipMan->match('162.128.1.1', '162.128.1.*'); // true
echo  $ipMan->match('162.128.1.1', '162.128.0.*');  // false
 
 // Ip in Randge
 echo $ipMan->ipInRange('127.0.0.1','127.0.0.0/24'); // true
```
 ## Location
```php


 // Get generic location based on ip
echo $ipMan->getIpLocation('182.0.2.5');

    {
       "ip": "182.0.2.5",
       "iso_code": "ID",
       "country": "Indonesia",
       "city": "Bali",
       "sub_division":"Sumatra",
       "latitude": "-6.175",
       "longitude":106.8286,
       "network ":"182.0.0.0\/17"
    }

// Get generic latitue,longitute based on ip
echo $ipMan->getIPLatitureAndLongitute('182.0.2.5');
 {
    "latitude":-6.175,
    "longitude":106.8286
 }
``` 
### Network
```php
echo $ipMan->cidrToMask('182.0.2.5'); // "255.255.252.0"

echo $ipMan->countSetbits($number) // int(22)

echo  $ipMan->validNetMask('255.255.252.0'); // true

echo $ipMan->validNetMask('127.0.0.1'); // false
    
echo $ipMan->maskToCidr('255.255.252.0'); // int(22)

echo $ipMan->alignedCIDR('127.0.0.1','255.255.252.0'); //string(12) "127.0.0.0/22"

```

 