<?php
$loader =  require __DIR__.'/vendor/autoload.php';
use GiviPapava\IPMan\IPMan;

$ipMan = new IPMan();
// Check if ip is valid

echo  $ipMan->isValidIp('162.168.1.321'); // true, false
echo "\n";
echo $ipMan->isV4('182.168.1.1');
// Get ip versation
echo $ipMan->getIpVersion('182.168.1.1'); // ipv4
echo "\n";
echo $ipMan->getIpVersion('2001:db8:0:1:1:1:1:1'); //  ipv6
// parselong
echo "\n";
echo $ipMan->parseLong('2130706433'); //  127.0.0.1
// parseBin
echo "\n";
 echo $ipMan->parseBin('11000100101010000100000100100001'); // 196.168.65.33
// parseHex
echo "\n";
echo $ipMan->parseHex('0a002001'); // 10.0.32.1
echo "\n";
// parse, combined parseLong,parseBin and parseHex
echo $ipMan->parse('2130706433','long'); //  127.0.0.1
echo "\n";

echo $ipMan->parse('11000100101010000100000100100001','bin'); // 196.168.65.33
echo "\n";

echo $ipMan->parse('0b002001','hex'); // 10.0.32.1
echo "\n";

// ReversePointer 

echo $ipMan->getReversePointer('182.0.2.5'); // 5.2.0.182.in-addr.arpa
echo "\n";


echo $ipMan->getReversePointer('162.128.1.1'); // 1.1.128.162.in-addr.arpa
echo "\n";

// MaxLengthPrefix

echo $ipMan->getMaxPrefixLength('2001:db8:0:1:1:1:1:1'); // 5.2.0.182.in-addr.arpa
echo "\n";

echo $ipMan->getOctetsCount('2001:db8:0:1:1:1:1:1'); // 5.2.0.182.in-addr.arpa
echo "\n";

echo $ipMan->getIpLocation('182.0.2.5');
echo "\n";
echo $ipMan->match('162.128.1.1', '162.128.0.*');
echo "\n";

echo $ipMan->cidrToMask("22");
echo "\n";