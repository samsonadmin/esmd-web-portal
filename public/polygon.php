<?
//phpinfo();



header('Pragma: no-cache');
header('Cache-Control: private, no-cache');
header('X-Content-Type-Options: nosniff');
header('Connection: close');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

include 'global-functions.php';
include 'cms_auth.php';

include "header.php";

?>
<div class="container-md">

    <div>
        <div><span class="text-info">Left click</span> to add points, the points will form a polygon. <span class="text-danger">Right</span> click to remove.<br />
        <b>Remarks: detection's center point is the middle of the detection rectangle.</b>
        </div>
        <canvas height="540" width="960" style="height: 540px; width: 960px; border: 1px solid #333; background-image: url(/server/php/files/2022/11/20221104-165435-69962.png); background-repeat: no-repeat; background-size: 960px 540px; background-position: center center;"></canvas>
        <div style="max-width: 960px;">
            <button class="btn btn-light tab_type" type="button" data-tab="zone_restricted" >Restricted Area</button>
            <button class="btn btn-light tab_type" type="button" data-tab="zone_danger" >Danger Area</button>
            <button class="btn btn-light tab_type" type="button" data-tab="zone_lifting" >Lifting Area</button>

            <div class="float-end">
                <span id="status_text" style="margin-right: 10px"></span>
                <button class="btn btn-danger" id="clear" type="button" >Clear Selection</button>
                <button class="btn btn-success" id="save" type="button" >Save</button>
            </div>

        </div>
    </div>

    
      
</div>
<script type="text/javascript" src="js/polygon.js"></script>
<script>

</script>
<? include "footer.php"; ?>
