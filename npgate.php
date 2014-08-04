<?php
/**
 * Netpoint Gate *

 * Is called by embedded chain directive of the customized ipxe.pxe (see http://ipxe.org/scripting)

 * dependencies:

 * /working_dir/ipxe/src/np.ipxe
 * /working_dir/ipxe/src/cacert.pem
 * /working_dir/ipxe/src/config/console.h
 * /working_dir/ipxe/src/config/general.h

 * /nginx_server/fs/images/secure/netpoint/*

 * a server cert signed by cacert.pem:
 * /nginx_server/etc/nginx/ssl/*

 * build ipxe.pxe and deploy it to the tftp server:

 * cd /working_dir/ipxe/src/
 * make bin/ipxe.pxe CERT=cacert.pem TRUST=cacert.pem EMBED=np.ipxe
 * scp bin/ipxe.pxe np-tftp:/tftpboot/

 * for detailled infos see ipxe.org

 */

/**

 * Get User-Agent from request

 * The User-Agent Key is compiled in the ipxe.pxe file and MUST must match with the http-user agent in the secure webfolder of nginx
 * Protects the gate itself which is called by ipxe.pxe embedded chain directive /working_dir/ipxe/src/np.ipxe and the delivery of the filesystem

 * dependencies:

 * working_dir/ipxe/src/net/tcp/httpcore.c (search "User-Agent")

 * working_dir/netpoint/config/includes.chroot/lib/live/boot/9990-mount-http.sh
   (search RTC_AGENT, you need to deploy a new initrd.img not only filesystem.squashfs if you change the key in the customized ipxe.pxe and nginx site!)

 * /nginx_server/etc/nginx/sites-enabled/default

 */
ob_start();

require_once("config.php");
require_once("autoload.php");
require_once("menu.php");
require_once("boot.php");
ob_end_clean();
boot();

?>
