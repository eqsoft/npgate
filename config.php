<?php 
class Config {
	public $user_agent;
	public $rtcagent;

	/**
	 * mac, ip, host for boot switch
	 */

	public $mac;
	public $ip;
	public $host;

	/**
	 * url of http image server
	 */
	public $http;
	public $https;

	/**
	 * filesystem image
	 */
	public $np;
	public $nps;
	public $seb;
	public $sebs;
	public $np_http_img;
	public $np_nfs_img;
	public $seb_http_img;
        public $seb_nfs_img;

	/**
	 * Runtime Key
	 *
	 * The Runtime Key 
	 * Used for assigning the root and npuser password
	 * Used as password for private ssh key id_rsa
	 * Like the rtcagent the rtckey is appended to the kernel parameters
	 */ 
	public $np_rtckey;
	public $seb_rtckey;	
	/** 
	 * Standard Kernel Params
	 */
	public $np_imgargs;
	public $np_kernel;
	public $np_initrd;
        public $seb_imgargs;
        public $seb_kernel;
        public $seb_initrd;
	public $silent;
	/** 
	 * debug
	 * if debug is appended the config log files are not deleted and the kernel parameter /proc/comdline are not protected
	 */
	public $debug;

	/**
	 * The Runtime Configs are FileSystem overlays which are fetched at boottime and can be managed from a git repo (rtcrepo)
	 * p.e. rtcgrp=opac: a named git bracnh "opac" must exist
	 * rtchost=1 will evaluate the hostname and tries to find a matching git branch

	 * if both params are used first the rtcgrp will be fetched and then rtchost.
	 * The fs_overlay folder overlays the root filesystem, so be careful!
	 * Normally it is used for assigning some special firefox configs or scripts
	 */
	public $rtcrepo;
	public $rtchost;
	public $rtcgrp;

	/**
	 * The browser component
	 * dependant on the browser system special config files or browser opts can be used
	 * xbrowsersopts is a comma seperated list of browser params added to the cmdline of the browser start like "-private,-jsconsole,-url,ht$
	 * The commas are replaced with whitespaces
	 */
	public $sebbrowser;
	public $firefox;
	public $xbrowseropts;

	/**
	 * x param to control the desktop and taskbar components
	 */
	public $xterminal;
	public $xpanel;
	public $xscreensaver;
	public $xexit;

	function __construct() {
		$this->user_agent = preg_replace('/^(.*)\s+(\w+)$/','${2}',$_SERVER["HTTP_USER_AGENT"]);
		$this->rtcagent = " rtcagent=".$this->user_agent;
		$this->mac = $_GET["mac"];
		$this->ip = $_GET["ip"];
		$this->host = $_GET["host"];
		$this->http = "http://eqsoft.org";
		$this->https = "https://eqsoft.org";
		$this->np = $this->http . "/netpoint";
		$this->nps = $this->https . "/netpoint";
		$this->seb = $this->http . "/seb";
                $this->sebs = $this->https . "/seb";
		$this->np_http_img = " fetch=" . $this->np . "/filesystem.squashfs";
		$this->np_nfs_img = " netboot=nfs nfsroot=";
		$this->seb_http_img = " fetch=" . $this->seb . "/filesystem.squashfs";
                $this->seb_nfs_img = " netboot=nfs nfsroot=";
		$this->np_rtckey = " rtckey=RTCKEY";
		$this->seb_rtckey = " rtckey=RTCKEY";
		$this->np_imgargs = "vmlinuz boot=live config locales=de_DE.UTF-8 keyboard-layouts=de username=npuser";
		$this->seb_imgargs = "vmlinuz boot=live config locales=de_DE.UTF-8 keyboard-layouts=de username=npuser";
		$this->silent = " console=ttyS0 loglevel=3 quiet";
		$this->np_kernel = $this->np . "/vmlinuz";
		$this->np_initrd = $this->np . "/initrd.img";
		$this->seb_kernel = $this->seb . "/vmlinuz";
                $this->seb_initrd = $this->seb . "/initrd.img";
		$this->debug = " debug";
		$this->rtcrepo = " rtcrepo=git@github.com:eqsoft/nprtc.git";
		$this->rtchost = " rtchost=1";
		$this->rtcgrp = " rtcgrp=netpoint";
		$this->sebbrowser = " xbrowser=seb";
		$this->firefox = " xbrowser=firefox";
		$this->xbrowseropts = "";
		$this->xterminal = " xterminal=1";
		$this->xpanel = " xpanel=1";
		$this->xscreensaver = " xscreensaver=1";
		$this->xexit = " xexit=1";
	}
}
$cfg = new Config();
?>
