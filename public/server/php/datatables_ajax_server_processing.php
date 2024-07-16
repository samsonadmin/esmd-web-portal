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
  "id",
  "datetime",
  "thumbnail",
  "url",        
  "detections",    
  "extracted_detection_classes",
  "client",
  "remarks"  
);


if ($_SESSION['access'] === "admin")
{
  $fields_to_display = array(
    "id",
    "datetime",
    "thumbnail",
    "url",        
    "detections",    
    "extracted_detection_classes",
    "client",
    "remarks" 
    );
}

$auth_users_indexed = array();
foreach ($auth_users as $user)
{
  $auth_users_indexed[$user['username']] = $user; 
}


$sql_where = array();

$this_user = $auth_users_indexed[$_SESSION['admin_user']];

if ( isset($this_user["allowed_client"]) )
{
  $sql_where[] = " client IN ( '" . implode( "', '", $this_user["allowed_client"] ) ."' ) ";
}

if ( isset($this_user["serial_no"]) )
{
  $sql_where[] = " ai_detections.serial_no IN ( '" . implode( "', '", $this_user["serial_no"] ) ."' ) ";
}

if ( isset($this_user["datetime_start"]) )
{
  $sql_where[] = " datetime >= '". $this_user["datetime_start"]. "'";
}

if ( isset($_REQUEST['debug']))
  print_r($sql_where);

$sql = "SELECT " . implode(", ", $fields_to_display) . " FROM ai_detections" ;

if ( count( $sql_where ) >1 )
{
  $sql .= " WHERE " . implode (" AND " , $sql_where) . " ";
}
elseif ( count( $sql_where ) == 1 )
{
  $sql .= " WHERE " . $sql_where[0];
}


//THIS PART ADDED FOR Searchbuilder 2022-09-09
$search_builder_sql_where = array();

if ( isset ($_REQUEST['searchBuilder']))
{
  if ( isset($_REQUEST['debug']))
    print_r($_REQUEST['searchBuilder'] );

  $search_builder_array = $_REQUEST['searchBuilder']['criteria'];

  for ($i = 0; $i<count($search_builder_array); $i++)
  {

    //skipping some of the data that is not useful
    if ( ! isset ($search_builder_array[$i]['data']) )
      continue;

    //convertback the display title to ori title
    if ( $search_builder_array[$i]['data'] == "Date & Time")
      $search_builder_array[$i]['data'] = "datetime";
    elseif ( $search_builder_array[$i]['data'] == "Detection / Types")
      $search_builder_array[$i]['data'] = "detections";
    elseif ( $search_builder_array[$i]['data'] == "Detection JSON")
      $search_builder_array[$i]['data'] = "detection_json";      
    elseif ( $search_builder_array[$i]['data'] == "detection_type")
      $search_builder_array[$i]['data'] = "extracted_detection_classes";
    else
      $search_builder_array[$i]['data'] = sanitize($search_builder_array[$i]['data']);

    if (isset($search_builder_array[$i]['value1']))
      $search_builder_array[$i]['value1'] = sanitize($search_builder_array[$i]['value1']);

    if (isset($search_builder_array[$i]['value2']))
      $search_builder_array[$i]['value2'] = sanitize($search_builder_array[$i]['value2']);
  }

  for ($i = 0; $i<count($search_builder_array); $i++)
  {

    //skipping some of the data that is not useful
    if ( ! isset ($search_builder_array[$i]['condition']) )
      continue;

    if ( $search_builder_array[$i]['condition'] == 'between' || $search_builder_array[$i]['condition'] == '!between' )
    {

      if ( stripos($search_builder_array[$i]['condition'], "!" ) === false )
      {
        $search_builder_sql_where[] = '"' . $search_builder_array[$i]['data'] . '" > "' . $search_builder_array[$i]['value1'] . '" AND ' . '"' . $search_builder_array[$i]['data'] . '" < "' . $search_builder_array[$i]['value2'] . '"';
      }else
      {
        $search_builder_sql_where[] = '"' . $search_builder_array[$i]['data'] . '" < "' . $search_builder_array[$i]['value1'] . '" AND ' . '"' . $search_builder_array[$i]['data'] . '" > "' . $search_builder_array[$i]['value2'] . '"';
      }

    }
    else if ( $search_builder_array[$i]['condition'] == 'null' || $search_builder_array[$i]['condition'] == '!null' )
    {
      $search_builder_sql_where[] = ' "' . $search_builder_array[$i]['data'] .
         ( ( stripos($search_builder_array[$i]['condition'], "!" ) === false )? '" = "" ' : '" != "" '  );
         
    } 
    else if ( $search_builder_array[$i]['condition'] == 'starts' || $search_builder_array[$i]['condition'] == '!starts' )
    {
      $search_builder_sql_where[] = ' "' . $search_builder_array[$i]['data'] .
         ( ( stripos($search_builder_array[$i]['condition'], "!" ) === false )? '" LIKE "' : '" NOT LIKE "'  ).
         $search_builder_array[$i]['value1'] . '%" ';      
    }      
    else if ( $search_builder_array[$i]['condition'] == 'contains' || $search_builder_array[$i]['condition'] == '!contains' )
    {
      $search_builder_sql_where[] = ' "' . $search_builder_array[$i]['data'] .
         ( ( stripos($search_builder_array[$i]['condition'], "!" ) === false )? '" LIKE "%' : '" NOT LIKE "%'  ).
         $search_builder_array[$i]['value1'] . '%" ';      
    }      
    else if ( $search_builder_array[$i]['condition'] == 'ends' || $search_builder_array[$i]['condition'] == '!ends' )
    {
      $search_builder_sql_where[] = ' "' . $search_builder_array[$i]['data'] .
         ( ( stripos($search_builder_array[$i]['condition'], "!" ) === false )? '" LIKE "%' : '" NOT LIKE "%'  ).
         $search_builder_array[$i]['value1'] . '" ';
    }
    else if (in_array( $search_builder_array[$i]['condition'], array('>','>=','<','<=','=','!=') ) )
    {
      $search_builder_sql_where[] = ' "' . $search_builder_array[$i]['data'] . '" '. $search_builder_array[$i]['condition'] .' "' . $search_builder_array[$i]['value1'] . '" ';
    }      
  }
}

if ( isset($_REQUEST['debug']))
  print_r($search_builder_sql_where);



$search_builder_logic = " AND ";
if ( isset ($_REQUEST['searchBuilder']))
{
  if ( $_REQUEST['searchBuilder']['logic'] == "OR" )
    $search_builder_logic = " OR ";
}

if ( count($search_builder_sql_where) > 0 )
{
  if ( stripos($sql, "WHERE",) == false)
  {
    $sql .= " WHERE ( " . implode( $search_builder_logic , $search_builder_sql_where) . " )";
    
  }
  else
  {
    $sql .= " AND ( " . implode( $search_builder_logic, $search_builder_sql_where) . " )";
  }
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




foreach ($results['data'] as &$row)
{  
  //$row[3] = message_translations($row[3]);
  // Check if the page was requested with HTTPS
  if( $is_cloudflare_https || $is_https){
    // Replace http with https in $row[1]
    $row[3] = str_replace('http://', 'https://', $row[3]);
    $row[2] = str_replace('http://', 'https://', $row[2]);
  }

  

  $inference_result = $row[4];
  $detection_result = json_decode($inference_result, true);
  if ( isset ($detection_result['class']))
  {
    $detect_classes = $detection_result['class'];
    $detect_classes = array_merge($detect_classes, explode("|", $row[3]) );   
  }
  else
  {
    $detect_classes = explode("|", $row[4]) ;
  }
  
  foreach ($detect_classes as &$class)
  {
    $class = message_translations($class);
  }

  //$row[3] . '::' .
  $row[4] =  implode(", ", $detect_classes) ;

  $row[5] = str_ireplace( array("[","]"), array("", ""), $row[5]);

  //print_r( $row );

  if ( isset ($cookieDomain) && $cookieDomain == ".rec-gt.com") 
  {
    $row[2] = str_ireplace("http://yolo.carryai.co/", "", $row[2]);
    $row[3] = str_ireplace("http://yolo.carryai.co/", "", $row[3]);
  }

  

}


if ( isset($_REQUEST['debug']))
{
  print_r($results['data']);

}

echo json_encode($results);



?>