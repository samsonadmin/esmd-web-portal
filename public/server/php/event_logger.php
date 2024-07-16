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


/*
if (isset($_SERVER['HTTP_ACCEPT']) &&
    (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
    header('Content-type: application/json');
} else {
    header('Content-type: text/plain');
}
*/

error_reporting(E_ALL | E_STRICT);

include '../../global-functions.php';
error_reporting(E_ALL);


//$abs_file_path = '/var/www/html/tradings.car1.hk' . $trading_images;

//$temp_file_path = $abs_file_path . 'temp/';

$db = new SQLite3("../../event_log.db");

$table_found = false;

$uploaded_image_count = 0;
$return_data = array();


$tablesquery = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='events';");
while ($table = $tablesquery->fetchArray(SQLITE3_ASSOC)) {
	$table_found = true;
	//echo $table['name'] . '<br />';
}


//var_dump($_POST);

$table_fields = array(
	"date" => "TEXT NOT NULL", 
	"time" => "TEXT NOT NULL", 
	"event" => "TEXT NOT NULL",
	"ip" => "TEXT", 
	"serial_no" => "TEXT"
);


/* Get values from POST */
$store_to_db = array();
foreach ( $table_fields as $field => &$val )
{

	$_POST[$field] = str_replace("/","-",$_POST[$field]);

	$store_to_db[$field] = isset ($_POST[$field]) ? trim( sanitize ($_POST[$field]) ) : "" ;
	
}


if (!$table_found)
{
	echo "Table is being created";

	$sql = "CREATE TABLE IF NOT EXISTS events( 
		id INTEGER PRIMARY KEY AUTOINCREMENT, ";

	foreach ( $table_fields as $field => &$val )
	{
		$sql .= $field . ' ' . $val ;

		if ( $field != array_key_last($table_fields) )
			$sql .= ', ' ;
	}
	$sql .= ')';

	//echo $sql;

	$db->exec($sql);

}else
{
	$tablesquery = $db->query("SELECT * FROM 'events';");
	while ($table = $tablesquery->fetchArray(SQLITE3_ASSOC)) {
		$table_found = true;
		//echo $table['name'] . '<br />';
	}
	
}


//send_sms2($src, $tar_mobile, $message)
//date('Y-m-d H:i:s')



/* Get the upload handler result and save to db starts */
if ( isset ($_POST))
{

	$store_to_db["ip"] = get_ip_address();
	
	$sql = 'INSERT INTO events (' . implode (", " , array_keys($store_to_db) ) . ') ';		
	$sql .= ' VALUES ( ' ;

	foreach ( $store_to_db as $field => &$val )
	{
		if ( in_array( $table_fields[$field], array("INTEGER", "REAL", "BLOB"  ) ) )
		{
			$sql .= $val ;
		}
		else
		{
			$sql .= "'" . $val . "'" ;
		}

		if ( $field != array_key_last($store_to_db) )
			$sql .= ', ' ;
	}
	
	$sql .= ' ) ;' ;
	
	//echo $sql;

	$db->exec($sql);

	$last_row_id = $db->lastInsertRowID();


	//echo "The last inserted row Id is $last_row_id";

	//send whatsapp
	if ($store_to_db['mobile'] != "")
	{
		$return_data[] = send_whatsapp ( 
			$store_to_db['mobile'],
		
		);

	}


}



$db->close();
?>