<?php

//header('Vary: Accept');
header('Pragma: no-cache');
header('Cache-Control: no-store, no-cache, must-revalidate');
//   header('Content-Disposition: inline; filename="files.json"');
header('X-Content-Type-Options: nosniff');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');
header('Accept-Encoding: gzip;q=0,deflate,sdch');

ini_set('display_errors', 1);

include 'global-functions.php';

$db = new SQLite3("upload.db");

$id = 0;
if ( isset ( $_REQUEST['id'] ) )
{
  $id = intval( $_REQUEST['id']);
}

$filter_conditions = "where ( id = '".$id."' ) ";

$select_sql = "SELECT * from 'ai_detections' ".$filter_conditions." order by id LIMIT 0,1 ;";

$query = $db->query($select_sql);
$all_rows = array();
while ($rows = $query->fetchArray(SQLITE3_ASSOC)) {
  $all_rows[] = $rows;
  //print_r ($rows);
	//echo $table['name'] . '<br />';

    //echo "\n";
}

$db->close();



//print_r($all_rows[0]);

// $inference_result = $all_rows[0]['detection_json'];

// $thumbnail = $all_rows[0]['thumbnail'];
// $image = $all_rows[0]['url'];
// $serial_no = $all_rows[0]['serial_no'];
// $datetime = $all_rows[0]['datetime'];
// $ip = $all_rows[0]['ip'];
// $client = $all_rows[0]['client'];


//echo $image_path;


//var_dump( is_file ($image_path) );

$load_success = false;

if ( count( $all_rows) > 0)
{

    $filename = $all_rows[0]['filename'];
    $location = $all_rows[0]['location'];
    $image_path = "server/php/files/" . $location . '/'.  $filename;

    if ( is_file ($image_path) ) 
    {
        header('Content-Type: image/jpeg');
        readfile($image_path);
        $load_success = true;
    }
}


if ( !$load_success)
{
    header('Content-Type: image/jpeg');
    readfile("file_not_found.jpg");
}
?>