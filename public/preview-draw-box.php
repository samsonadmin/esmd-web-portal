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

    echo "\n";
}

$db->close();


if (count( $all_rows) == 0 )
{
  echo 'ID not found, please visit <a href="https://yolo.carryai.co">yolo.carryai.co</a>';
  die;
}

$inference_result = $all_rows[0]['detection_json'];

$thumbnail = $all_rows[0]['thumbnail'];
$image = $all_rows[0]['url'];
$serial_no = $all_rows[0]['serial_no'];
$datetime = $all_rows[0]['datetime'];
$ip = $all_rows[0]['ip'];
$client = $all_rows[0]['client'];

$filename = $all_rows[0]['filename'];
$location = $all_rows[0]['location'];
$image_path = "server/php/files/" . $location . '/'.  $filename;

$detections = $all_rows[0]['detections'];

$message_to_send = $detections;
$detect_classes = $detections;
if (!is_array ($detect_classes))
  $detect_classes = array($detect_classes );


if (strlen($inference_result) > 0)
{
  $detection_result = json_decode($inference_result, true);
  $detections = implode(", ", $detection_result['class']);

  $detect_classes = $detection_result['class'];

  //print_r($detect_classes);

  foreach ($detect_classes as &$class)
  {
    $class = message_translations($class);
  }

  $message_to_send = implode(", ", $detect_classes) ;
  
  
}

$meta_tags = array();

$meta_tags[] = '<meta property="og:title" content="Detections: '.$detections.'" />';
$meta_tags[] = '<meta property="og:description" content="Detections: '.$id." " . $serial_no . " " . $datetime . " ".$message_to_send. '" />';
$meta_tags[] = '<meta property="og:image" content="' .$image.'" />';
$meta_tags[] = '<meta property="og:image:type" content="image/jpeg" />';
$meta_tags[] = '<meta property="og:type" content="image" />';
$meta_tags[] = '<meta property="og:image:alt" content="' .$detections.'" />';

$unlabel_image = str_ireplace(".labeled", "", $image);

$unlabel_image_path = str_ireplace(".labeled", "", $image_path);


$new_temp_file = "tmp/".$filename;

if ( isset ($_REQUEST['new_json']))
{


  $output_image_file = draw_bbox ($unlabel_image_path, $new_temp_file, trim($_REQUEST['new_json']));

  //echo $output_image_file;
}

?>
<? include_once 'header.php'; ?>

<div class="text-center">
  <img class="img-fluid rounded mx-auto d-block" src="<?=$unlabel_image?>" />
  <? if ( isset ( $output_image_file )) { ?>
  <img class="img-fluid rounded mx-auto d-block" src="<?=$new_temp_file?>" />
  <? } ?>
</div>
<br />
<div class="container-md">
Detected results from the image / 從圖像中檢測到的結果：
<?="<ol>\n<li>" . implode("</li>\n<li>", $detect_classes) . "</li></ol>"?>
Date time: <?=$datetime?>

<form method="post" >
<textarea style="width: 80%; height: 200px" name="new_json">
<?

if ( isset ($_REQUEST['new_json']))
  echo $_REQUEST['new_json'];
else
  echo $inference_result;

?>
</textarea>
<br />
<input name="id" type="hidden" value="<?=$id?>" />
<input type=submit />
</form>
</div>
<?//print_r($all_rows); ?>
</body>
</html>