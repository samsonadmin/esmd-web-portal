<?
//phpinfo();



header('Pragma: no-cache');
header('Cache-Control: private, no-cache');
header('X-Content-Type-Options: nosniff');
header('Connection: close');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

include 'global-functions.php';
include 'cms_auth.php';

if ($_SESSION['access'] !== "admin")
{
  $error = array (
    "success" => "false",
    "error" => "not login, please login again"
  ) ;
  echo json_encode($error);
  die;
}

display_login_form();

include "header.php";
//The zoning data is stored in zoning.json text file, so whenever whatsapp / sms is sent, it will look up this zoning.json

$img = "loading.gif";


ini_set('display_errors', 1);

error_reporting(E_ALL | E_STRICT);

error_reporting(E_ALL);

$db = new SQLite3("upload.db");


$id = 0;
if ( isset ( $_REQUEST['id'] ) )
{
  $id = intval( $_REQUEST['id']);
}

$filter_conditions = "where ( id = '".$id."' ) ";

$select_sql = "SELECT * from 'ai_detections' ".$filter_conditions." order by id DESC LIMIT 0,1 ;";

if ( $id == 0 )
{
  
  $select_sql = "SELECT * from 'ai_detections' order by id DESC LIMIT 0,1 ;";
}

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
  echo 'ID not found, please visit <a href="/">Home Page</a>';
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
$img = "server/php/files/" . $location . '/'.  $filename;


   
$detection_array = json_decode($inference_result, true);



if (is_null( $detection_array ))
{
  echo "<!-- Please select another image, this image doesn't content any detection info-->";
}
else
{
  list($need_to_send_alert, $debug_messages, $extra_messages) = check_zoning($serial_no, $detection_array );
}

?>

<style>
#zone_name_buttons button{margin-right: 10px}
</style>

<? 
  if ($_SESSION['access'] !== "admin") { 
    echo "Need Admin rights!";
    die;
  }

?>

<div class="container-md content">

    <div style="padding-top: 10px">
        <canvas id="draw_canvas" height="540" width="960" style="height: 540px; width: 960px; border: 1px solid #333; background-image: url(<?=$img?>); background-repeat: no-repeat; background-size: 960px 540px; background-position: center center;"></canvas>
        <div style="max-width: 960px;">

            <span id="zone_name_buttons"><!--zone is loaded from ajax-->
            </span>

            <div class="float-end">
                <span id="status_text" style="margin-right: 10px"></span>
                <button class="btn btn-info" id="new_zone" type="button" data-bs-toggle="modal" data-bs-target="#new_zone_modal" >New Zone</button>
                <button class="btn btn-success" id="save" type="button" _disabled aria-disabled="true">Save Zone</button>
                <button class="btn btn-danger" id="delete-btn" type="button" data-bs-toggle="modal" data-bs-target="#delete_modal" disabled aria-disabled="true">Delete Zone</button>                
            </div>

            <div><span class="text-info">Left click</span> to add points, the points will form a polygon. <span class="text-danger">Right</span> click on points to remove.<br />
            <b>Remarks: Zones are related to serial number. Any corners of the detections box inside the zone, will recieve Whatsapp alert.</b>
            </div>
        </div>


    </div>


    <hr />
    <div>
    
<?php  if (is_null( $detection_array ))  { ?>
  <span style="color: #b4b4ba;">This image doesn't content any detection info(maybe periodic save), if you select an image with detections, it will show debug info.</span>
<? }else{ ?>
    <b>Was alert sent? <span style="color: <?= $need_to_send_alert ? "red" : "green"?> ;"><?= $need_to_send_alert ? "&#10004;" : "&#x274c;"?> <? var_dump($need_to_send_alert);?></span> </b>
    </div>

    <div style="color: #244522; font-size:80%;">
    Debug Log: <? echo implode("<br />", $debug_messages); ?>
    </div>
    
    <div  style="color: #332245; font-size:80%;">
    <?=json_encode($extra_messages, JSON_PRETTY_PRINT)?>
    </div>    

    <div  style="color: #332245; font-size:80%;">
    <?=$inference_result?>
    </div> 
    
<? } ?>      
</div>


<!-- new zone Modal -->
<div class="modal fade" id="new_zone_modal" tabindex="-1" aria-labelledby="new_zone_modal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Zone Name and Color Picker</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="zone-name" class="form-label">
              Zone Name (no space, small letters)
              e.g:
              <ul>
               <li><span style="color: red;">require_red_helmet</span> ( alert if no helmet / alert with blue/green/red helmet )</li>
               <li><span style="color: blue;">require_blue_helmet</span> ( alert if no helmet / alert with yellow/green/red helmet )</li>
               <li><span style="color: green;">no_person</span> ( alert if people detected )</li>
              </ul>
            </label>
            <input type="text" class="form-control" id="zone-name" placeholder="Enter Zone Name">
          </div>
          <div class="mb-3">
            <label for="color-picker" class="form-label">Zone Color (only for display)</label>
            <input type="color" class="m-auto 
                form-control form-control-color" 
                id="color-picker" value="#<?=substr(md5(mt_rand()), 0, 6);?>">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-button">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- delete Modal -->
<div class="modal fade" id="delete_modal" tabindex="-1" aria-labelledby="delete_Modal_Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete [<span id="delete-zone-name" style="color:red">N/A</span>] zone?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirm-delete-button">Delete</button>
      </div>
    </div>
  </div>



</div>

<script type="text/javascript" src="js/polygon.js?date=6"></script>




<? include "footer.php"; ?>
