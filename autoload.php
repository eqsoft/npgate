<?php
$items = array();

foreach (glob(realpath(dirname(__FILE__))."/config/*/*.php") as $filename) {
	include_once $filename;
	$id = pathinfo(pathinfo($filename)["dirname"])["basename"];
	$items[$id] = $$id;
}
?>

