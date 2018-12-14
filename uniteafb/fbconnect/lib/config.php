<?php

/*   
 *   FACEBOOK CONNECT LIBRARY FUNCTIONS/CLASSES
 */

/*   
 *   FILE INCLUDE PATHS
 *   MAKE SURE THESE PATHS ALL END WITH A FORWARD SLASH
 */

define(CONNECT_APPLICATION_PATH, "fbconnect/");
define(CONNECT_JAVASCRIPT_PATH, "");
define(CONNECT_CSS_PATH, "");
define(CONNECT_IMG_PATH, "");

include_once CONNECT_APPLICATION_PATH.'facebook-client/facebook.php';
include_once CONNECT_APPLICATION_PATH.'lib/fbconnect.php';
include_once CONNECT_APPLICATION_PATH.'lib/core.php';
include_once CONNECT_APPLICATION_PATH.'lib/user.php';
include_once CONNECT_APPLICATION_PATH.'lib/display.php';

/*
 *   FB CONNECT APPLICATION DATA
 */
	

$callback_url    = 'http://www.inscribiteonline.com.ar/uniteafb/';
$api_key         = '245533208842802';
$api_secret      = '8dc4bcd5078aa033753808c4b662ca26';
$base_fb_url     = 'connect.facebook.com';
$feed_bundle_id  = 'your template bundle id';

/*
 *   SAMPLE BUNDLE DATA
 */

$sample_post_title = "FB Connect Demo";
$sample_post_url = "http://pakt.com/scripts/facebook/connect/";
$sample_one_line_story = '{*actor*} posted a comment on <a href="{*post-url*}">{*post-title*}</a> and said {*post*}.';
$sample_template_data = '{"post-url":"http://pakt.com/scripts/facebook/connect/", "post-title":"FB Connect Demo", "post":"This is so easy to use!"}';

?>