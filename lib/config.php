<?php
error_reporting(0);
ini_set('display_errors', 0);

session_start();

//Version
define("SYS_VERSION", "1.0");

//DB
// Server
// define("DB_HOSTNAME", "ls-d161fdd5a2639438a6498fc7da147d5df8fa72e8.c1mslvpwhocw.ap-southeast-1.rds.amazonaws.com");
// define("DB_USERNAME", "dbmasteruser");
// define("DB_PASSWORD", "$O[:;<b2nf(:BBNY-KcD]>O29o&a,og`");
// define("DB_DATABASE", "Database-1");
// define("ROOTPATH", "/htdocs/");

define("DB_HOSTNAME", "127.0.0.1");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "root");
define("DB_DATABASE", "lms");
define("DB_PORT", "3357");
define("ROOTPATH", "/lms");

// define("DB_HOSTNAME", "localhost");
// define("DB_USERNAME", "root");
// define("DB_PASSWORD", "");
// define("DB_DATABASE", "lms");
// define("ROOTPATH", "/lms/");

//PREFIX
define("BACKEND_PREFIX", "BACK_");
define("WEBSITE_PREFIX", "WEB_");

require_once('lib/class/db.php');
require_once('lib/class/pagination.php');
require_once('lib/class/image.php');
require_once('lib/class/sendmail.php');
//require_once('class/fbsdk.php');
//require_once('class/user.php');
//require_once('exifer/exif.php');
//require_once('captcha/captcha.php');

foreach (glob(dirname(__FILE__) . '/class/*.php') as $file) {
    require_once($file);   
}

foreach (glob(dirname(__FILE__) . '/function/*.php') as $file) {
    require_once($file);   
}

$db = new db(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$admin = new admin($db);
$cms = new cms($db, $admin);
$post = new post($cms);

define("SITE_NAME", $cms->settings['site_name']);

//Session
$_SESSION[WEBSITE_PREFIX.'LOGIN_ATTEMPT'] = !empty($_SESSION[WEBSITE_PREFIX.'LOGIN_ATTEMPT']) ? $_SESSION[WEBSITE_PREFIX.'LOGIN_ATTEMPT'] : 0;
$_SESSION[BACKEND_PREFIX.'ADMIN_ID'] = (empty($_SESSION[BACKEND_PREFIX.'ADMIN_ID'])) ? '' : $_SESSION[BACKEND_PREFIX.'ADMIN_ID'];
$_SESSION[WEBSITE_PREFIX.'GUEST']['id'] = !empty($_SESSION[WEBSITE_PREFIX.'GUEST']['id']) ? $_SESSION[WEBSITE_PREFIX.'GUEST']['id'] : base64_encode(time() . '-' . rand(0,9999999));

?>
