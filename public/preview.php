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

$cookieDomain = '.carryai.co'; // Change to your domain name

$domain = $_SERVER['HTTP_HOST'];

// Extract the TLD using regular expressions
if (preg_match('/\b(?:[a-z0-9-]+\.)?([a-z0-9-]+\.(?:com|co))\b/i', $domain, $matches)) {
    $extractedDomain = $matches[1];
	if ($extractedDomain == "rec-gt.com")
		$cookieDomain = ".rec-gt.com";
    
}

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

    echo "\n";
}

$db->close();


if (count( $all_rows) == 0 )
{
  echo 'ID not found, please visit <a href="https://yolo.carryai.co">yolo.carryai.co</a>';
  die;
}


$detections = "";
$detect_classes = array();

$inference_result = $all_rows[0]['detection_json'];

$thumbnail = $all_rows[0]['thumbnail'];
$image = $all_rows[0]['url'];
$serial_no = $all_rows[0]['serial_no'];
$datetime = $all_rows[0]['datetime'];
$ip = $all_rows[0]['ip'];
$client = $all_rows[0]['client'];


$violations = $all_rows[0]['detections'];
$violations = message_translations($violations);

$violations_array = explode ("|", $violations);
$message_to_send = $violations;
//$detect_classes = $violations;

// if (!is_array ($detect_classes))
//   $detect_classes = array($detect_classes );

$domain = $_SERVER['HTTP_HOST'];
//print_r($domain);

// Extract the TLD using regular expressions
if (preg_match('/\b(?:[a-z0-9-]+\.)?([a-z0-9-]+\.(?:com|co))\b/i', $domain, $matches)) {
    $extractedDomain = $matches[1];
	if ($extractedDomain == "carryai.co")
  $image = str_replace("https://aisafety.rec-gt.com", "https://yolo.carryai.co" ,$image);
		
    
}




$need_to_send_alert = false;
$debug_messages = array();
$extra_messages = array();

if (strlen($inference_result) > 0)
{
  $detection_result = json_decode($inference_result, true);
  $detections = implode(", ", $detection_result['class']);

  $detect_classes = $detection_result['class'];

  $detection_array = json_decode($inference_result, true);
  
  //print_r($detect_classes);
  list($need_to_send_alert, $debug_messages, $extra_messages) = check_zoning($serial_no, $detection_array );

  $detect_classes = array_merge($detect_classes, $extra_messages);


  foreach ($detect_classes as &$class)
  {
    $class = message_translations($class);
  }

  $message_to_send = implode(", ", $detect_classes) ;  

}

$message_to_send .= $violations;


$actual_link = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];


$meta_tags = array();

$meta_tags[] = '<meta property="og:title" content="['. $serial_no.'] ' .$detections.'" />';
$meta_tags[] = '<meta property="og:description" content="' .$message_to_send. '" />';
$meta_tags[] = '<meta property="og:image" content="' .$image.'" />';
$meta_tags[] = '<meta property="og:image:type" content="image/jpeg" />';
$meta_tags[] = '<meta property="og:type" content="image" />';
$meta_tags[] = '<meta property="og:image:alt" content="' .$detections.'" />';
$meta_tags[] = '<meta property="og:logo" content="carryai-simple-dark.png" />';
$meta_tags[] = '<meta property="og:url" content="'.$actual_link.'" />';

?>
<? include_once 'header.php'; ?>
<style>

@media screen and (min-width:480px) {
  .display_img {
    max-width: 880px;
    display: table-cell;
    padding: 2px 0;
  }  
}  
@media screen and (max-width:480px) {
  .display_img {
    width: 100%;
    display: table-cell;
    padding: 2px 0;
  }
}


</style>
<div class="text-center">
  <img class="_img-fluid rounded mx-auto d-block display_img" src="<?=$image?>" />
</div>
<br />
<div class="container-md">
  Detected results from the image / 從圖像中檢測到的結果：
  <?="<ol>\n<li>" . implode("</li>\n<li>", array_merge($violations_array, $detect_classes))  . "</li></ol>"?>

  Record Time: <?=$datetime?>

  <hr />
  <div class="logs">
  <b>[<?=$serial_no?>] Was alert sent? <span style="color: <?= $need_to_send_alert ? "red" : "green"?> ;"><?= $need_to_send_alert ? "&#10004;" : "&#x274c;"?> <? var_dump($need_to_send_alert);?></span> </b>

    <div style="color: #244522; font-size:80%;">
    Debug Log: <? echo implode("<br />", $debug_messages); ?>
    </div>
    
    <div style="color: #332245; font-size:80%;">
    <?=json_encode($extra_messages, JSON_PRETTY_PRINT)?>
    </div>    

    <div style="color: #332245; font-size:80%;">
    <?=$inference_result?>
    </div>   
      
  </div>
</div>


<? include "footer.php"; ?>