<?php

/**
 * menu
 */

$menu_config = true;
$menu_default = "netpoint";

$menuopts = "choose --timeout 5000 --default " . $menu_default . " selected && goto \${selected}";
$menu = "menu Please select Image\n";
foreach ($items as $key => $value) {
$title = $items[$key]["title"];
$item = <<<EOF
item $key $title

EOF;
$menu .= $item;
}
if ($menu_config) {
	$config_item = <<<EOF
item config IPXE Configuration Settings
EOF;
	$menu .= $config_item . "\n";
}
$menu .= $menuopts."\n\n";

/**
 * images
 */
foreach ($items as $key => $value) {
$kernel = $items[$key]["kernel"];
$initrd = $items[$key]["initrd"];
$imgargs = $items[$key]["imgargs"];
$image = <<<EOF
:$key
kernel $kernel
initrd $initrd
imgargs $imgargs
boot
exit 0

EOF;

$menu .= $image . "\n";

}

if ($menu_config) {
        $config_cmd = <<<EOF
:config 
config
EOF;
        $menu .= $config_cmd;
}

?>
