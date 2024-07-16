<?php
header('Pragma: no-cache');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Accept-Encoding: gzip;q=0,deflate,sdch');
header('Content-type: application/json');
header('X-Content-Type-Options: nosniff');
header('Access-Control-Allow-Origin: *');

if ( isset($_REQUEST['debug']))
{
  
  error_reporting(E_ALL | E_STRICT);
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
}


//$db = new TinySQLite('../../upload.db');


include '../../cms_auth.php';

include_once "../../global-functions.php";

if ($_SESSION['access'] !== "admin")
{
  $error = array (
    "success" => "false",
    "error" => "not login, please login again"
  ) ;
  echo json_encode($error);
  die;
}

$file_path = '../../serial_no_receiving_alerts.json';

// Read the JSON file
$json_string = file_get_contents($file_path);

// Decode the JSON string into a PHP array
$serial_no_receiving_alerts = json_decode($json_string, true);

// Check if decoding was successful
if ($serial_no_receiving_alerts === null) 
{
    $serial_no_receiving_alerts = array();
}
else
{
    // Use $serial_no_receiving_alerts as your PHP array
    //print_r($serial_no_receiving_alerts);
}

if (isset ($_REQUEST['serial_no']))
    $serial_no = sanitize( $_REQUEST['serial_no'] );
else
    $serial_no = false;

if (isset ($_REQUEST['new_val']))
{
    if ( strtolower ( trim($_REQUEST['new_val']) ) == "true"  )
        $new_val = true;

    if ( strtolower ( trim($_REQUEST['new_val']) ) == "false"  )
        $new_val = false;
}
else
{
    echo '{"function":"update","status":"failed", "error":"no new_val"}';
    die;
}

if ( $new_val == false)
{
    if ( isset ($serial_no) )
    {
        $key = array_search($serial_no, $serial_no_receiving_alerts);

        // If the serial number exists, remove the element from the array
        if ($key !== false) {
            unset($serial_no_receiving_alerts[$key]);
            $serial_no_receiving_alerts = array_values($serial_no_receiving_alerts);
        }        
    }    
}
elseif($new_val == true)
{
    if ( isset ($serial_no) )
    {
        $key = array_search($serial_no, $serial_no_receiving_alerts);

        // If the serial number exists, remove the element from the array
        if ($key == false) {
            $serial_no_receiving_alerts[] = $serial_no;
        }        
    }    
}


// Convert the array to JSON format with pretty print
$json_data = json_encode($serial_no_receiving_alerts, JSON_PRETTY_PRINT);

//print_r($json_data);

// Save JSON data to file
$status = file_put_contents($file_path, $json_data);

// Check if file was saved successfully
if ($status !== false)
{  
    
    echo '{"function":"update","status":"success"}';
}
else
{
    echo '{"function":"update","status":"failed", "error":"file save error."}';
}

//print_r($serial_no_receiving_alerts);

?>