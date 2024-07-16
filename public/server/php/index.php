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

ini_set("log_errors", 1);
ini_set("error_log", "php-upload-error.log");

require('UploadHandler.php');


//$abs_file_path = '/var/www/html/tradings.car1.hk' . $trading_images;

//$temp_file_path = $abs_file_path . 'temp/';

$db = new SQLite3("../../upload.db");

$table_found = false;

$uploaded_image_count = 0;
$return_data = array();


$tablesquery = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='ai_detections';");
while ($table = $tablesquery->fetchArray(SQLITE3_ASSOC)) {
	$table_found = true;
	//echo $table['name'] . '<br />';
}

$tablesquery1 = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='api_queue';");
while ($table = $tablesquery1->fetchArray(SQLITE3_ASSOC)) {
	$table_found1 = true;
	//echo $table['name'] . '<br />';
}
//var_dump($_POST);

$table_fields = array(
	"datetime" => "TEXT NOT NULL", 
	"location" => "TEXT NOT NULL", 
	"filename" => "TEXT NOT NULL",
	"url" => "TEXT NOT NULL", 
	"thumbnail" => "TEXT", 		
	"detections" => "TEXT", 
	"detection_json" => "TEXT", 
	"ip" => "TEXT", 
	"client" => "TEXT", 
	"serial_no" => "TEXT", 
	"jetpack_version" => "TEXT", 
	"git_hash" => "TEXT", 
	"arch" => "TEXT", 
	"remarks" => "TEXT", 
	"gps" => "TEXT", 
	"mobile" => "TEXT", 
	"email" => "TEXT",
	"sent_status" => "TEXT",
	"size" => "INTEGER",
	"extracted_detection_classes" => "TEXT"
);

// $table1_fields = array(
// 	"datetime" => "TEXT NOT NULL", 	
// 	"tar_mobile" => "TEXT NOT NULL",
// 	"image_url" => "TEXT NOT NULL", 
// 	"api_url" => "TEXT NOT NULL", 
// 	"thumbnail" => "TEXT", 		
// 	"title" => "TEXT", 
// 	"desc" => "TEXT", 
// 	"complete_datetime" => "TEXT", 	
// 	"status" => "TEXT", 
// 	"return_response" => "TEXT"
// );

/* Get values from POST */
$store_to_db = array();
foreach ( $table_fields as $field => &$val )
{

	if ( ! in_array( $field, array("datetime", "location", "filename", "url", "thumbnail", "ip", "send_status") ) )
	{
		if ( $field == "detection_json")
		{
			$store_to_db[$field] = isset ($_POST[$field]) ? trim( $_POST[$field] ) : "" ;
		}
		else
		{
			$store_to_db[$field] = isset ($_POST[$field]) ? trim( sanitize ($_POST[$field]) ) : "" ;
		}
	}
}


if (!$table_found)
{
	echo "Table is being created";

	$sql = "CREATE TABLE IF NOT EXISTS ai_detections( 
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

}

if ( isset ($_POST['simple_form'] ) or isset ($_POST['API_POST'] ) ) 
{

	
	$this_year_month = date("Y/m/");

	$options = array(

		//'script_url' => $_SERVER['PHP_SELF'],
		'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']) .'/files/' . $this_year_month ,
		'upload_url' => $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST']  .'/server/php/files/' . $this_year_month ,
		'param_name' => 'files',
		'mkdir_mode' => 0755,
		// The php.ini settings upload_max_filesize and post_max_size
		// take precedence over the following max_file_size setting:
		'max_file_size' => 5767168,
		'min_file_size' => 60,
		//'accept_file_types' => '/.+$/i',
		'accept_file_types' => '/\.(jpe?g|png)$/i',
		'max_number_of_files' => 200000,
		'discard_aborted_uploads' => true,
		'print_response' => false

	);

	$upload_handler = new UploadHandler($options);

}
else
{


	$this_year_month = date("Y/m/");

	$options = array(

		//'script_url' => $_SERVER['PHP_SELF'],
		'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']) .'/files/' . $this_year_month,
		'upload_url' => $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST']  .'/server/php/files/' . $this_year_month,
		'param_name' => 'files',
		'mkdir_mode' => 0755,
		// The php.ini settings upload_max_filesize and post_max_size
		// take precedence over the following max_file_size setting:
		'max_file_size' => 5767168,
		'min_file_size' => 60,
		//'accept_file_types' => '/.+$/i',
		'accept_file_types' => '/\.(jpe?g|png)$/i',
		'max_number_of_files' => 200000,
		'discard_aborted_uploads' => true,

	);
	
	$upload_handler = new UploadHandler($options);

}


/*	Delete old files start */
//	This part is for deleting old files

$files = glob(dirname($_SERVER['SCRIPT_FILENAME']) .'/files/'."*" ,GLOB_MARK );
array_push($files, glob(dirname($_SERVER['SCRIPT_FILENAME']) .'/files/thumbnail/'."*") );

$now = time();

foreach ($files as $file) {

	if (is_string($file)){
		if (is_file($file)) {
			if ($now - filemtime($file) >= 60 * 60 * 24 * 365) { // 365 days
				unlink($file);
			}
		}
	}
}

/*	Delete old files ends */



//send_sms2($src, $tar_mobile, $message)
//date('Y-m-d H:i:s')



/* Get the upload handler (for every request) starts */
$file_obj = array_values( $upload_handler->get_response() );

$url="";
$thumbnailUrl="";

//print_r($file_obj );

foreach ($file_obj as $name => $value)
{
	foreach ( $value as $inner_val )
	{
		if ( isset ($inner_val->url) )
			$url=$inner_val->url;
		if ( isset ($inner_val->thumbnailUrl) )
			$thumbnailUrl=$inner_val->thumbnailUrl;

	}
}
	
/* Get the upload handler (for every request) ends */

/* Get the upload handler result and save to db starts */
if ( isset ($_POST['simple_form'] ) or isset ($_POST['API_POST'] ) )
{

	$alert_sending_domain = 'https://yolo.carryai.co/';

	
	foreach ($file_obj as $name => $value)
	{
		foreach ( $value as $inner_val )
		{
			
			if ( isset ($inner_val->thumbnailUrl) )
				$thumbnailUrl=$inner_val->thumbnailUrl;

			

			$inference_result = $store_to_db["detection_json"];

			if ( $inference_result !== "" && isset ($inner_val->name) && isset($inner_val->url) )
			{

				//Added from 2022 Nov for generating the image border around the detected images - Start

				$inner_val->url = str_ireplace(".jpg", ".labeled.jpg", $inner_val->url );

				$img = "files/" . date('Y/m') . '/'. $inner_val->name ;

				//Name is changed here
				$inner_val->name = str_ireplace(".jpg", ".labeled.jpg",$inner_val->name);

				$new_img = "files/" . date('Y/m') . '/'. $inner_val->name ;
				
				$output_image_file = draw_bbox ($img, $new_img, $inference_result);
				

				//Check if the inference_result is within one of the zones,.
				//check_zones($new_img, $inference_json, $serial_no)


				//$output_image_filename = str_ireplace(".png", ".jpg", $new_img) ;

				//20240715
				$inference_obj = json_decode($inference_result, true);
				//print_r($inference_obj['class']);

				foreach ($inference_obj['class'] as &$this_class)
				{
					$this_class = str_ireplace( array("helmet_yes", "helmet_ok"), array("helmet_good", "helmet_bad"), $this_class );
				}

				$store_to_db["extracted_detection_classes"] = json_encode($inference_obj['class']);

							
				
			}
			else
			{
				$store_to_db["extracted_detection_classes"] = "";
			}


		
			//Added from 2022 Nov for generating the image border around the detected images - end

			//Write to SQLite

			$store_to_db["datetime"] = date('Y-m-d H:i:s');
			$store_to_db["size"] = $inner_val->size;
			$store_to_db["url"] = $inner_val->url;
			$store_to_db["location"] = date('Y/m');
			$store_to_db["thumbnail"] = $thumbnailUrl;
			$store_to_db["ip"] = get_ip_address();
			$store_to_db["filename"] = $inner_val->name;

			$store_to_db["remarks"] = $store_to_db["remarks"] . "Token: " . getBearerToken();


		
			//var_dump($store_to_db );
			//echo "-------------";

			if ( $store_to_db["client"] == 'REC_JEC' ||  $store_to_db["client"] == 'REC_GREEN_TECH' ) 
			{
				$alert_sending_domain = 'https://aisafety.rec-gt.com/';

				$store_to_db["url"] = str_replace("yolo.carryai.co", "aisafety.rec-gt.com",$store_to_db["url"]);

				$store_to_db["url"] = str_replace("http://", "https://",$store_to_db["url"]);

			}
			
			
			
			$sql = 'INSERT INTO ai_detections (' . implode (", " , array_keys($store_to_db) ) . ') ';		
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


			if ( $last_row_id > 0 )
				$uploaded_image_count++;	

			// Read the JSON file
			$json_string = file_get_contents('../../serial_no_receiving_alerts.json');

			// Decode the JSON string into a PHP array
			$serial_no_receiving_alerts = json_decode($json_string, true);

			// Check if decoding was successful
			if ($serial_no_receiving_alerts === null) 
			{
				$serial_no_receiving_alerts = array();
			}
			


			
			safe_log( "debug.txt",  date('Y-m-d H:i:s'). " ID: "  . $last_row_id . " Serial : ". $store_to_db['serial_no'] .  "\n", FILE_APPEND );

			//Only send those are included
			if ( in_array( $store_to_db['serial_no'], $serial_no_receiving_alerts ) !== false ) 
			{

				safe_log( "debug.txt",  date('Y-m-d H:i:s'). " ALERT ACTIVE SERIAL : " . $store_to_db['serial_no'] . "\n", FILE_APPEND );

				//jonathan and I 
				$receipents = array(
					'62350965', '92157557', '64404095', '91933900'
				);

				// $receipents = array(
				// 	'92157557'
				// );
				

				//洪水橋 camera 
				if ($store_to_db['serial_no'] == "1421621055084")
				{
					$receipents[] = '92838741';										
				}

				//kwu tung camera 
				if ($store_to_db['serial_no'] == "1421621053134")
				{
					$receipents[] = '51114166';			//stanley fung YL safety officer							
				}

				//Tong chung 99, request from derek 2023 04 25
				if ($store_to_db['serial_no'] == "1425022003303")
				{
					$receipents[] = '64294127'; //logan
					$receipents[] = '94447927';
					$receipents[] = '54044484'; //oswald

				}
								

				//#send to JEC , client of REC => ray
				if ( strpos( $store_to_db['client'], "REC_JEC" ) !== false )
				{
					//$receipents[] = '63937391'; //ray
					$receipents[] = '51119172'; //william
					$receipents[] = '62350965';

				}

				


				if ( strpos( $store_to_db['client'], "SAMSON" ) !== false )
				{
					//this only include samson's phone
					$receipents = array( '92157557' );
				}	


				if ( strpos( $store_to_db['client'], "OFFICE" ) !== false )
				{
					//this only include samson's phone an michael
					$receipents = array( '92157557' );
				}	

				if ( getenv('APP_ENV') !== "prod")
				{
					$receipents = array( '92157557' );
				}


			}else
			{
				$receipents = array();
			}

			$color = "";

			//$message_to_send = "empty";
			//Get the best wordings
			$message_to_send = message_translations(trim($_REQUEST['detections']));

			if ( isset ( $inference_result))
			{

				if (strlen($inference_result) > 0)
				{
					$detection_result = json_decode($inference_result, true);

					$detect_classes = $detection_result['class'];

					foreach ($detect_classes as &$class)
					{
					  $class = message_translations($class);
					}
					
					$message_to_send .= implode(", ", $detect_classes) ;

				}

			}
			

			safe_log( "debug.txt",  date('Y-m-d H:i:s'). " RECEIPENTS: " . implode(",", $receipents) . "\n", FILE_APPEND );

			$send_alert_array = array();
			//$send_alert_array[] = "periodic_recordings";
			$send_alert_array[] = "BAD";
			//$send_alert_array[] = "GOOD";
			//$send_alert_array[] = "helmet_ok";
			//$send_alert_array[] = "helmet_yes";
			$send_alert_array[] = "helmet_bad";
			$send_alert_array[] = "helmet_none";
			$send_alert_array[] = "vest_none";
			$send_alert_array[] = "fire";
			$send_alert_array[] = "smoke";
			$send_alert_array[] = "helmet_unknown";
			$send_alert_array[] = "helmet_good";
			$send_alert_array[] = "Simulate: NONE";
			//$send_alert_array[] = "mask_none";
			//$send_alert_array[] = "mask_bad";
			//$send_alert_array[] = "mask_good";



			$need_to_send_alert = false;
			if ( in_array( trim($_REQUEST['detections']), $send_alert_array  ) )
			{
				$need_to_send_alert = true;
			}


			if ( trim($_REQUEST['detections']) != "periodic_recordings" )
			{

				//Added new criterial based on detection of the the picture size, so the detected result be be bigger and width and height, otherwise treat it is not ok
                $width = 0;
                $height = 0;

                $largest_width = 0;
                $largest_height = 0;
		
				safe_log( "debug.txt",  date('Y-m-d H:i:s'). " detections :" .$_REQUEST['detections']. "\n", FILE_APPEND );


                if ( isset ($_REQUEST['detection_json']) || ( trim($_REQUEST['detections']) != "" ))
                {
					//Now, assume we don't need to send alert and re-check if we need to
					if ( trim($_REQUEST['detections']) != "Simulate: NONE" )					
						$need_to_send_alert = false; //removed on 20230424

                    $detection_array = json_decode($_REQUEST['detection_json'], true);

					$detected_classes[] = array();
					if ( isset ($detection_array['class'] ) )
					{
						if ( is_array( $detection_array['class'] ))
						{
							$detected_classes = array_unique($detection_array['class']);
					
							foreach ($detected_classes as $class)
							{            
								$need_to_send_alert = $need_to_send_alert || in_array($class, $send_alert_array, $strict = false  );
					
							}							
					
						}
					}

					//Maybe the idle / fall
					if (! $need_to_send_alert)
					{
						//Force to set it back

						$need_to_send_alert = true; 
						if ($_REQUEST['detections'] != "")
						{
						
							$detection_array = array(
								"class" => mb_strtolower($_REQUEST['detections']),
								"confs" => "1",
								"boxes" => "[0,0,0,0]",
								"color" => "N/A"
							);
							$need_to_send_alert = true;
						}

						
												
					}
					

					

					

					list($zone_need_to_send_alert, $debug_messages, $extra_messages) = check_zoning($store_to_db['serial_no'], $detection_array );

					foreach ($debug_messages as $message)
					{
						safe_log( "debug.txt",  date('Y-m-d H:i:s'). " " . $message . "\n", FILE_APPEND );
					}
					foreach ($extra_messages as $message)
					{
						safe_log( "debug.txt",  date('Y-m-d H:i:s'). " " . $message . "\n", FILE_APPEND );
					}						
					
                }

				safe_log( "debug.txt",  date('Y-m-d H:i:s'). " need_to_send_alert:" .($need_to_send_alert? "TRUE " : "FALSE " ) ."|| zone_need_to_send_alert :" .( $zone_need_to_send_alert? "TRUE " : "FALSE ") . "\n", FILE_APPEND );

				if ( $need_to_send_alert && $zone_need_to_send_alert)
				{

					if ( count( $extra_messages) > 0 )
						{
							foreach ($extra_messages as $this_message)
							{
								if ( $this_message == "no_vest") //because this word will be captured in detection_json
								{
									$message_to_send = class_to_words($this_message) . " \n" . $message_to_send ;
								}
			
							}
						}

					//Send SMS
					//$message_to_send = $message_to_send . "@". date('Y-m-d H:i:s'). " \n" . $url ;
					$message_to_send = "[" . date('Y-m-d H:i:s'). "] " . $message_to_send  ;

					for ($i = 0; $i<count($receipents); $i++)
					{

						if ( $receipents[$i] == "") continue;
							
						if ( strpos( $receipents[$i], "852" ) === false )
						{
							$receipents[$i] = '852' . $receipents[$i];
						}

						safe_log( "debug.txt",  date('Y-m-d H:i:s'). " " . "Sending MESSAGE: " . $receipents[$i] . " " . var_dump($need_to_send_alert). var_dump($zone_need_to_send_alert) . $message_to_send . "\n", FILE_APPEND );

						// //"${width}x${height}" .'@' ." Detected: " . $color . " " .$_REQUEST['detections']
						// $return_data[] = send_whatsapp ( 
						// 	$receipents[$i],
						// 	$store_to_db["url"], 
						// 	$store_to_db["thumbnail"],
						// 	"ALERT: " . $_REQUEST['detections'],
					 // 	"COLOR: " . $color 
						// );	

						//"${width}x${height}" .'@' ." Detected: " . $color . " " .$_REQUEST['detections']
						$return_data[] = send_whatsapp ( 
							$receipents[$i],
							$alert_sending_domain . "preview.php?id=".$last_row_id, 
							$store_to_db["thumbnail"],
							$message_to_send,
							$color 
						);							

						//send_sms2("CarryAI", $receipents[$i] , $message);

						//Speed up the sending
						//$sql = "UPDATE ai_detections SET sent_status = 'WHATSAPP: ". $return_data . "' WHERE id = " . $last_row_id .';';
		
						///$db->exec($sql);
						
						
					}


					

					

					if ( isset ($detection_array['class'] ) )
					{
						if ( is_array( $detection_array['class'] ))
						{
							//$detection_array
							$unique_count = array_count_values($detection_array['class']);
							$result_array = array();
							foreach ($unique_count as $key => $value )
							{
								$result_array[] = array(
									"Item" => $key,
									"Number" => $value
								);								
							}

							$unique_count2 = array_count_values($extra_messages);

							foreach ($unique_count2 as $key => $value )
							{
								$result_array[] = array(
									"Item" => $key,
									"Number" => $value
								);								
							}							

						}
						else
						{

							safe_log( "debug.txt",  date('Y-m-d H:i:s'). " " . "REQUEST[detections]" . json_encode(mb_strtolower(trim($_REQUEST['detections']))) ."\n", FILE_APPEND );	

							//getting from Detection
							$result_array[] = array(
								"Item" => mb_strtolower(trim($_REQUEST['detections'])),
								"Number" => 1
							);	
						}
					}
					


					$data = array(
						"key" => array(
							"type" => "JSON",
							"data" => array ("WORKSPACECODE")
						),
						"value" => array(
							"type" => "JSON",
							"data" => array (
								"WorkspaceCode" => "WORKSPACECODE",
								"LocationName" => "",
								"Serial_no" => $store_to_db['serial_no'],
								"Timestamp" => time(),
								"Result" => $result_array,
								"Attachment" => array(

									array(
										"id" => $last_row_id,
										"type" => "photo",
										"url" => $store_to_db["url"],
										"value" => $alert_sending_domain. "/preview.php?id=".$last_row_id
									),
									array(
										"id" => $last_row_id,
										"type" => "photo",
										"value" => $alert_sending_domain. "/video-preview.php?id=".$last_row_id
									),			
									"timestamp"	=> time()
								)					
							)
						)
					);


					safe_log( "debug.txt",  date('Y-m-d H:i:s'). " " . "VHsoft CMP DATA:" . json_encode($data) ."\n", FILE_APPEND );	

					//sending to CMP
					$vhsoft_server = "prod";

					if ($store_to_db['serial_no'] == "1421621055084")
					{
						$vhsoft_server = "prod";
					}
					if ($store_to_db['serial_no'] == "1421621053802")
					{
						$vhsoft_server = "prod";
					}							
					$response = send_vhsoft_cmp_datahub($data, $vhsoft_server);
					safe_log( "debug.txt",  date('Y-m-d H:i:s'). " " . "VHsoft CMP" . $response ."\n", FILE_APPEND );					


					//Need to add logic to call api, only for 1421621055073 to call the jetson api for making voice

					safe_log( "debug.txt",  date('Y-m-d H:i:s'). " " . "checking for 1421621055073:unauthorized_entry:" . $response ."\n", FILE_APPEND );	

					if ( isset ($extra_messages ))
					{
						if ($store_to_db['serial_no'] == "1421621055073" && in_array( "unauthorized_entry", $extra_messages  ))
						{
							//

							//https://carryai-1421621055073-video.carryai.co/api/playmp3/unauthorized_entry

							$response = get_url("https://carryai-1421621055073-video.carryai.co/api/playmp3/unauthorized_entry");
							safe_log( "debug.txt",  date('Y-m-d H:i:s'). " " . "1421621055073::" . $response ."\n", FILE_APPEND );						
						}
					}

				}
				else
				{
					safe_log( "debug.txt",  date('Y-m-d H:i:s'). " " . "No Alert sent.\n", FILE_APPEND );
				}


				// //#send to JEC , client of REC => ray
				// if ( strpos( $store_to_db['client'], "REC_JEC" ) !== false )
				// {

				// 	send_sms2("CarryAI", "85263937391" , $message);

				// }
			}


			//send to rec-gt server start
			//https://aiotrak.rec-gt.com/dashboardview/selected
			//username: samson
			//password: 4gftwvoe

			// $skip_sending = true;

			// if ( strcmp( trim($_POST['client']) , 'REC_GREEN_TECH') == 0 && $skip_sending == false)
			// {

			// 	//send to rec-gt server ends

			// 	$return_data[] = send_rec_gt_api (
			// 		"files/". $store_to_db["location"]."/" .$store_to_db["filename"],
			// 		$store_to_db["filename"],
			// 		$store_to_db["size"]
			// 	);

			// 	$sql = "UPDATE ai_detections SET sent_status = sent_status || '". 'API: "'. sanitize( end($return_data) ) . '" ' . "' " . ' WHERE id = ' . $last_row_id .';';
			// 	//echo $sql. "\n";;
			// 	$db->exec($sql);
			// }
				
			//send ifttt

			/*
			$return_data[] = send_ifttt ( 
				$store_to_db["url"], 
				$store_to_db["thumbnail"],
				$store_to_db["detections"]
			);			
			
			$sql = "UPDATE ai_detections SET sent_status = sent_status || '". 'IFTTT: "'. sanitize( end($return_data) ) . '" ' . "' " . ' WHERE id = ' . $last_row_id .';';			

			//echo $sql. "\n";;
			$db->exec($sql);

			*/


			
		}
	}


	if ( $uploaded_image_count > 0 )
	{

		echo json_encode( 
			array(
					"Success" => true,
					"Uploaded Images" => $uploaded_image_count
				)
			, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT ) ;		

	}
	else
	{
		echo json_encode( 
			array(
					"Success" => false,
					"Uploaded Images" => 0
				)
			, JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT ) ;	
	}


}




$db->close();
safe_log( "debug.txt", date('Y-m-d H:i:s'). " -------------------------------------" . "\n", FILE_APPEND );
?>