<?php

/**
 * see config.php for predefined variables
 */
$id = pathinfo(__DIR__)["basename"];

$$id = array(
	"mac" => 	file(__DIR__."/mac.txt"),
	"ip" => 	file(__DIR__."/ip.txt"),
	"host" => 	file(__DIR__."/host.txt"),
	"id" => 	$id,
	"title" => 	"Netpoint (HTTP)",
	"kernel" => 	$cfg->np_kernel,
	"initrd" => 	$cfg->np_initrd,
	"imgargs" => 	$cfg->np_imgargs . 
			$cfg->debug .
			$cfg->firefox . 
			$cfg->xpanel . 
			$cfg->xexit . 
			$cfg->xscreensaver .
			$cfg->rtcagent .
			$cfg->np_rtckey . 
			$cfg->np_http_img
	);
?>
