<?php
function check_mac($item) {
	global $cfg;
	$mac_arr = $item["mac"];
	$mac_pattern = '/(' . $cfg->mac . ')(\s*m?)$/i';
    	if ($mac_arr) {
        	foreach ($mac_arr as $mac) {
            		if (preg_match($mac_pattern,$mac,$matches)) {
               			return array("item" => $item, "show_menu" => (preg_match('/m/i',$matches[2])));
                		break;
            		}
		}
	}
	return false;
}

function check_ip($item) {
	global $cfg;
	$ip_arr = $item["ip"];
	$range_pattern = '/^\s*(.*?)\.(\d+)\s*\-\s*(.*?)\.(\d+)(\s*m?)\s*$/i';
	$ip_pattern = '/^\s*(.*?)\.(\d+)\s*$/';
	if ($ip_arr) {
		foreach ($ip_arr as $ip) {
			// check ip
			$curr_ip_pattern = '/^\s*(' . $cfg->ip . ')(\s*m?)$/';
			if (preg_match($curr_ip_pattern,$ip,$matches)) {
				 return array("item" => $item, "show_menu" => (preg_match('/m/i',$matches[2])));
			}
			// check ip range
			if (preg_match($range_pattern,$ip,$matches)) {
                                // valid subnet range?
                                $subnet = $matches[1];
                                if ($matches[1] != $matches[3]) {
                                        // ToDo: log?
                                        continue;
                                }
                                $min = (int)$matches[2];
                                $max = (int)$matches[4];
                                $show_menu = $matches[5];
                                // valid subnet?
                                if (preg_match($ip_pattern,$cfg->ip,$matches)) {
                                        if ($matches[1] == $subnet) {
                                                $val = (int)$matches[2];
                                                if ($val >= $min && $val <= $max) {
                                                         return array("item" => $item, "show_menu" => (preg_match('/m/i',$show_menu)));
                                                }
                                        }
                                }
                        }
		}
	}
	return false;
}

function check_host($item) {
	global $cfg;
	$host_arr = $item["host"];
	$host_pattern = '/^\s*(' . $cfg->host . ')(\s*m?)\s*$/';
	foreach ($host_arr as $host) {
		if (preg_match($host_pattern,$host,$matches)) {
			return array("item" => $item, "show_menu" => (preg_match('/m/i',$matches[2])));
			break;

		}
	}
}

/**
* check if ip exists in netmask p.e. 192.168.18.0/24
* example:
* foreach ( $n as $k=>$v ) {
*  list($net,$mask)=split("/",$k);
*  if (ipInMask($myip,$net,$mask)) {
*      echo $n[$k]."<br />\n"; }
*  }
*/
function ipInMask($ip,$net,$mask) {
    $lnet=ip2long($net);
    $lip=ip2long($ip);
    $binnet=str_pad( decbin($lnet),32,"0","STR_PAD_LEFT" );
    $firstpart=substr($binnet,0,$mask);
    $binip=str_pad( decbin($lip),32,"0","STR_PAD_LEFT" );
    $firstip=substr($binip,0,$mask);
    return(strcmp($firstpart,$firstip)==0);
}

function boot() {
	global $items, $cfg;
	if ($cfg->mac == '' || $cfg->ip == '' || $cfg->host == '') {
        	out_txt("wrong parameter");
    	}
	foreach ($items as $k => $item) {
        	$ret = check_mac($item);
		if ($ret) {
			out($ret["item"],$ret["show_menu"]);
			break;
			return;
		}
		$ret = check_ip($item);
		if ($ret) {
                	out($ret["item"],$ret["show_menu"]);
                	break;
			return;
        	}
        	$ret = check_host($item);
        	if ($ret) {
                	out($ret["item"],$ret["show_menu"]);
                	break;
			return;
        	}
	}
	// ToDo: ipxe message or default image....
	out_txt("no mac/ip/hostname assigned");
}

function out($item,$show_menu) {
	global $menu; 
	$txt = "";
	if ($show_menu) {
		$txt = <<<EOF
#!ipxe

$menu
EOF;
    }
    else {
        $kernel = $item["kernel"];
        $initrd = $item["initrd"];
        $imgargs = $item["imgargs"];
        $txt = <<<EOF
#!ipxe

kernel $kernel
initrd $initrd
imgargs $imgargs
boot
exit 0
EOF;

	}
	out_txt($txt);
}

function out_txt($txt) {
	ob_end_clean();
	header("Content-Type: text/plain");
	echo $txt;
	exit;
}
?>
