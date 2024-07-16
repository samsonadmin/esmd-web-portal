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
include '../../global-functions.php';

if (!isset( $_SESSION['admin_user']) )
{
  $error = array (
    "success" => "false",
    "error" => "not login, please login again"
  ) ;
  echo json_encode($error);
  die;
}


$fields_to_display = array(   
  "machine_information.*"
);



$auth_users_indexed = array();
foreach ($auth_users as $user)
{
  $auth_users_indexed[$user['username']] = $user; 
}


$sql_where = array();


$this_user = $auth_users_indexed[$_SESSION['admin_user']];


if ( isset($_REQUEST['debug']))
{
  print_r( $this_user["allowed_client"]);
  print_r($sql_where);
}

//$sql = "SELECT id, serial_no, location, name, remarks, mobile, email FROM machine_information WHERE serial_no IN ( SELECT DISTINCT ai_detections.serial_no FROM ai_detections ) " ;


$sql = "SELECT DISTINCT ai_detections.serial_no, machine_information.name, machine_information.location, machine_information.remarks, machine_information.id, machine_information.mobile, machine_information.email , ai_detections.client FROM ai_detections  LEFT JOIN machine_information ON ai_detections.serial_no = machine_information.serial_no ";


$sql_where[] = " ai_detections.serial_no NOT IN ('', 'fake_serial', '123456789')  ";

if ( isset($this_user["allowed_client"]) )
{
  $sql_where[] = " ai_detections.client IN ( '" . implode( "', '", $this_user["allowed_client"] ) ."' ) ";
}

if ( isset($this_user["serial_no"]) )
{
  $sql_where[] = " ai_detections.serial_no IN ( '" . implode( "', '", $this_user["serial_no"] ) ."' ) ";
}

if ( count( $sql_where ) >1 )
{
  $sql .= " WHERE " . implode (" AND " , $sql_where) . " ";
}
elseif ( count( $sql_where ) == 1 )
{
  $sql .= " WHERE " . $sql_where[0];
}

if ( isset($_REQUEST['debug']))
  echo $sql . "\n";

require_once 'vendor/autoload.php';

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\SQLite;

$path = '../../upload.db';
$dt = new Datatables( new SQLite($path) );

$dt->query($sql);

//$results = $dt->generate()->toJson(); // same as 'echo $dt->generate()';

$results = $dt->generate()->toArray(); // same as 'echo $dt->generate()';

$serial_no_array = array();

$unique_results = array();

foreach ($results['data'] as &$row)
{  
  //$row[3] = message_translations($row[3]);

  
  if (!in_array( strval($row[0]), $serial_no_array ))
  {
    $unique_results[] = $row;
    $serial_no_array[] = strval($row[0]);
    //print_r( strval($row[0]) );
  }

}

$results['data'] = $unique_results;

if ( isset($_REQUEST['debug']))
{
  print_r($serial_no_array);
  print_r($results['data']);
  //print_r($unique_results);

  
}
echo json_encode($results);



?>