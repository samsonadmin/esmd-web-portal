<?php

header('Pragma: no-cache');
header('Cache-Control: private, no-cache');
header('X-Content-Type-Options: nosniff');
header('Connection: close');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');


// Report all PHP errors
error_reporting(E_ALL);

// Display errors in the HTML output
ini_set('display_errors', 1);

// Optionally, you can also set the display_startup_errors directive to show errors that occur during PHP's startup sequence
ini_set('display_startup_errors', 1);

require 'vendor/autoload.php';
use OTPHP\TOTP;

if (!isset($_REQUEST['debug']) && !isset($_POST))
{
	// Check if the request was served over HTTPS
	$isHttps = false;
	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
	{
		$isHttps = true;
	}
	elseif (isset($_SERVER['HTTP_CF_VISITOR']) && strpos($_SERVER['HTTP_CF_VISITOR'], "https") !== false) 
	{		
		$isHttps = true;
	}
	elseif ( (isset($_SERVER['HTTP_UPGRADE_INSECURE_REQUESTS']) && strpos($_SERVER['HTTP_UPGRADE_INSECURE_REQUESTS'], "1") !== false ))
	{
		$isHttps = true;
	}
	
	if (!$isHttps)
	{
		// Redirect to the HTTPS version of the current page
		// echo "REDIR";
		$httpsUrl = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		header("Location: $httpsUrl");
		exit();
	}

}

else
{
	//print_r( $_SERVER) ;
}




//Set the session timeout for 20 hour
$cookieLifetime = 172800;  // until the browser closes (2days)
$cookiePath = '/';

$domain = $_SERVER['HTTP_HOST'];
//print_r($domain);

$cookieDomain = '.carryai.co'; // Change to your domain name

// Extract the TLD using regular expressions
if (preg_match('/\b(?:[a-z0-9-]+\.)?([a-z0-9-]+\.(?:com|co))\b/i', $domain, $matches)) {
    $extractedDomain = $matches[1];
	if ($extractedDomain == "rec-gt.com")
		$cookieDomain = ".rec-gt.com";
    
}

$cookieSecure = true; // Set to true if using HTTPS
$cookieHttpOnly = true;

// Set the session cookie parameters
session_set_cookie_params($cookieLifetime, $cookiePath, $cookieDomain, $cookieSecure, $cookieHttpOnly);

//print_r($extractedDomain);
//Set the maxlifetime of the session
ini_set( "session.gc_maxlifetime", $cookieLifetime );

//Set the cookie lifetime of the session
ini_set( "session.cookie_lifetime", $cookieLifetime );
ini_set( "session.use_only_cookies", true );
#ini_set( "session.use_only_cookies", $true );


$auth_users = array();

$auth_users[] = array(
	"username" => "carryai-dev",
	"password" => "u2V24TDEhGXqZ4sVqX8o" ,
	"allowed_client" => 
		array(
			"REC_GREEN_TECH",
			"DSD_SIU_HO_WAN",
			"REC_JEC",
			"OFFICE",
		),
	"access"	=> "admin",

);

	

$auth_users[] = array(
	"username" => "REC_GREEN_TECH",
	"password" => "FZ9qYtK2vU4KWgn3" ,
	"allowed_client" => 
		array(
			"REC_GREEN_TECH",
			"DSD_SIU_HO_WAN",
			"REC_JEC",
			"REC_ENGINEERING"
		),
	"access"	=> "admin",

);

$auth_users[] = array(
	"username" => "REC_GREEN_TECH_DEMO",
	"password" => "FZ9qYtK2vU4KWgn3" ,
	"allowed_client" => 
		array(
			"REC_GREEN_TECH",
			"DSD_SIU_HO_WAN",
			"REC_JEC",
			"REC_ENGINEERING"
		),
);

$auth_users[] = array(
	"username" => "YAU_LEE_CWD",
	"password" => "gk11NAHjohGmO" ,
	"auth_code" => "wW1j2AxjiBBW5u4ufuuwktna7rVVBFTVjGj2" ,
	"allowed_client" => 
		array(
			"REC_GREEN_TECH",
			"REC_ENGINEERING"
		),	
	"serial_no" =>
		array(
			"1422921151359",
			"1424321007340"
		),
);


$auth_users[] = array(
	"username" => "REC_JEC",
	"password" => "b5hlU9j5q0eg" ,
	"allowed_client" => 
		array(
			"REC_JEC"
		),
	"access"	=> "admin"

);

$auth_users[] = array(
	"username" => "RGT_hungshuikiu",
	"password" => "VDR9zI7X4w" ,
	"allowed_client" => 
		array(
			"REC_GREEN_TECH"
		),	
	"serial_no" =>
		array(
			"1421621055084",
		),
	"datetime_start" => "2022-12-10 15:10:56"	

);


$auth_users[] = array(
	"username" => "RGT_kwutung",
	"password" => "ShF0B9myEPVIVM3" ,
	"allowed_client" => 
		array(
			"REC_GREEN_TECH"
		),	
	"serial_no" =>
		array(
			"1421621053134",
		),
	"datetime_start" => "2023-11-10 15:10:56"	

);


$auth_users[] = array( 
	"username" => "RGT_tungchung",
	"password" => "e4folxalbrypn" ,
	"auth_code" => "UvaeV5HKL0CFY2gikOLcWkF4zYbc9o725Y9GKpSzE0kVZhUxPY" ,
	"allowed_client" => 
		array(
			"REC_GREEN_TECH"
		),	
	"serial_no" =>
		array(
			"1425022003303"
		),
	"datetime_start" => "2022-08-18 17:59:56"	
);

$auth_users[] = array( 
	"username" => "HAdashboard",
	"password" => "20200468" ,
	"allowed_client" => 
		array(
			"REC_GREEN_TECH"
		),	
	"serial_no" =>
		array(
			"1420822032829"
		),
	"datetime_start" => "2022-08-18 17:59:56"	
);

$auth_users[] = array( 
	"username" => "RGT_cheungshawan",
	"password" => "g0Ro5k2hEY" ,
	"allowed_client" => 
		array(
			"REC_GREEN_TECH"
		),	
	"serial_no" =>
		array(
			"1421621053802",
			"1421621055527",
			"1421621053134"
		),
	"datetime_start" => "2022-06-04 17:59:56"	
);


$auth_users[] = array( 
	"username" => "RGT_fanling",
	"password" => "wj09Uzl4GgN" ,
	"allowed_client" => 
		array(
			"REC_GREEN_TECH"
		),	
	"serial_no" =>
		array(
			"1425022001875",
			"1425022000683"
		),
	"datetime_start" => "2024-01-01 17:59:56"	
);

$auth_users[] = array( 
	"username" => "RGT_wanchai",
	"password" => "120V6Bc1mB2x" ,
	"allowed_client" => 
		array(
			"REC_GREEN_TECH"
		),	
	"serial_no" =>
		array(
			"1421621053802",
			"1421621052904"
		),
	"datetime_start" => "2024-01-08 17:10:56"	
);

$auth_users[] = array( 
	"username" => "dsd-admin",
	"password" => "f7TaXAUfF" ,
	"allowed_client" => 
		array(
			"DSD_SIU_HO_WAN"
		)
);

$auth_users[] = array(
	"username" => "samsonli",
	"password" => "ET7m2K5dkuAXNWAY" ,
	"2fa_secret" => "YPT3WOZVTIYC3DEBHYV7PYFRAPTZ6FNBCH7EMS7XNPMCMW6U3XKG73GVSNZY6QU5645ATUAWOCR4WYYAVOFVP5KYQ4E6BARGDABQAFY",
	"access" => "admin",
);


$auth_users[] = array(
	"username" => "sms_gateway",
	"password" => "7zGysv8e2hp%" 
);

$errors = array();

// var_dump($_SESSION);

if (!session_id() ){
	if (ini_get('session.use_cookies'))
	{
		
		$p = session_get_cookie_params();
		//var_dump(session_name());
		//setcookie(session_name(), '', time() + $p['lifetime'], $p['path'], $p['domain'], $p['secure'], $p['httponly']);
	 }	
	session_start();
	//session_write_close();

	//var_dump($_SESSION);
}

if ( isset ($_REQUEST['auth_code']) )
{
	$get_user = test_authcode ($auth_users, $_REQUEST['auth_code']);

	if ( $get_user == false) 
	{
		echo "Auth code error";
		exit();
	}
	else
	{
		$_SESSION['admin_user'] = $get_user;
		header( "Location: /", true, 303 );
		exit();	
	}
}
//Test with https://yolo.carryai.co/?auth_code=UvaeV5HKL0CFY2gikOLcWkF4zYbc9o725Y9GKpSzE0kVZhUxPY
if ( isset ($_POST['username']) && isset ($_POST['password']) )
{
	list( $access_level, $two_fa_code ) = test_login( $auth_users,  sanitize($_POST['username']), sanitize($_POST['password']) );

	if (isset($_REQUEST['debug']) )
	{
		print_r($_REQUEST);
		var_dump( $access_level);
	}

    if ( $access_level != false )
	{
        $_SESSION['admin_user'] = sanitize($_POST['username']);
		$_SESSION['access'] = $access_level;
		$_SESSION['2fa_secret'] = $two_fa_code;
		// Redirect to this page.
		header( "Location: {$_SERVER['REQUEST_URI']}", true, 303 );
		exit();		
	}
    else
	{
		$errors[] = "Username // Password Error";
        unset ( $_SESSION['admin_user'] );
		unset ( $_SESSION['access'] );
		unset ( $_SESSION['2fa_secret'] );
	}
		
}

if ( isset ($_SESSION['admin_user']) && isset ($_SESSION['2fa_secret']) && isset ($_POST['2fa_code']) )
{
	$two_fa_code = sanitize($_POST['2fa_code']);
	
	$otp = TOTP::createFromSecret($_SESSION['2fa_secret']); // create TOTP object from the secret.
	//$otp->verify($two_fa_code); // Returns true if the input is verified, otherwise false.

	if ($otp->verify($two_fa_code)) {
		//';
		$_SESSION['2fa_verified'] = 1;
		// Clear session data
		// session_unset();
		// session_destroy();
	} else {
		//echo 'Invalid 2FA code';
		$errors[] = "Invalid 2FA code";
	}
}	

if ( isset ($_REQUEST['logout']))
{
	if ( $_REQUEST['logout'] != "")
	{
		logout();
	}
}


function test_login($user_db, $username, $password)
{

	if ( $username == "" || $password == "" )
		return false;


    for( $i=0; $i<=count($user_db); $i++)
    {

        if ( isset( $user_db[$i]) && ( $username == $user_db[$i]['username'] ) && ( $password == $user_db[$i]['password'] ) )
		{

			$two_fa_code = false;
			if ( isset( $user_db[$i]['2fa_secret'] ) )  
				$two_fa_code = $user_db[$i]['2fa_secret'];

			if ( isset( $user_db[$i]['access'] ) ) 
			{
				return array( $user_db[$i]['access'], $two_fa_code );
			}
            return array(true, $two_fa_code);
		}
			
    }
    return false;
}

function test_authcode($user_db, $authcode)
{
    for( $i=0; $i<=count($user_db); $i++)
    {

        if (  $authcode == $user_db[$i]['auth_code'] ) 
            return $user_db[$i]['username'];
			
    }
    return false;
}


function logout()
{
	session_unset();
	session_destroy();

	header( "Location: /", true, 303 );
	exit();		
}

function display_login_form(){
	global $cookieDomain;
	if (!isset( $_SESSION['admin_user']) )
	{
		include_once 'templates/login.php';
		die;
	}
	else
	{
		//2fa_skip is for logined but need to setup 2fa// && isset( $_SESSION['2fa_skip']) 
		if (isset( $_SESSION['2fa_secret']) && $_SESSION['2fa_secret'] && !isset( $_SESSION['2fa_verified']) )
		{
			include_once 'templates/2fa-verify.php';
			//echo "2fa";
			die;
		}	
		
	}

}

function display_2fa_setup_form()
{
	global $cookieDomain;
	if (!isset( $_SESSION['admin_user']) )
	{
		include_once 'templates/2fa-setup.php';
		die;
	}
	else
	{
		//echo "login";
	}
}

function api_check_login(){	
	if (!isset( $_SESSION['admin_user']) )
	{
        echo json_encode( array(
            "success" => 0,
            "error"   => "login error"
        ));
		die;
	}
}

function display_errors(){
	global $errors;

	for($i=0;$i<count($errors); $i++){
		echo '<b style="color: red;">' . $errors[$i] . '</b><br />';
	}
}


?>
