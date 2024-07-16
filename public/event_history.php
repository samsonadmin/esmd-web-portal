<?
//phpinfo();



header('Pragma: no-cache');
header('Cache-Control: private, no-cache');
header('X-Content-Type-Options: nosniff');
header('Connection: close');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Access-Control-Allow-Origin: *');

include 'global-functions.php';
include 'cms_auth.php';


display_login_form();

$fields_to_display = array(
    "date",
    "time",
    "event",
    "ip"
  );

?>
<? include 'header.php' ?>

<div class="container-lg">
    <div style="margin-bottom: 1.5em">
        <div class="d-grid gap-2 d-md-block">
            <!--<a href="<?=$hls_iframe_src?>" target="_blank" class="btn btn-outline-primary" type="button" id="live_stream" >Login Live Stream (new window)</a>-->
            <button class="btn btn-outline-danger" id="live_stream" type="button">Current Alarm</button>
            <a href="../" class="btn btn-outline-success" type="button">AI Detections</a>
        </div>
    </div>
</div>

<div class="container-lg">
    <!--
    <h2 class="lead">Upload Records &#8250; <a href="upload-test.php">Upload Test</a> | <a href="upload-test-ajax.php">Multiple Files Upload Test</a> | <a href="gallery.php">Image Gallery</a></h2>
    -->
    <div class="row">
        <div id="target_video" class="hidden shrink" style="display: none;">
            <div style="width: 100%; padding-top:56.25%; position: relative; background-color: #5e5e5e;">
                <iframe id="video_iframe" allowtransparency="true" allowfullscreen="true" allow="geolocation; microphone; camera" sandbox="allow-same-origin allow-scripts allow-popups allow-forms" src="<?=$hls_iframe_src?>" style="position:absolute; width:100%; height: 100%; margin:0; border: 0; top:0; left:0; bottom:0; right: 0;"></iframe>
            </div>
        </div>
        
    
        <div id="target_table" class="col-sm-12 grow">
            <div style="display: none1;">
                Show/Hide:
                <?php         
                    $i=0;           
                    foreach ($fields_to_display as $field)
                    {
                        echo '<a href="#" class="toggle-vis" data-column="' . $i . '">'. $field . "</a> \n";

                        if ($i < count($fields_to_display)-1 )
                            echo " | ";

                        $i++;

                    }
                ?>    
            </div>
                    
            <table id="load_log" class="display" style="width:100%">
                <thead>
                    <tr>
                        <?php                    
                            foreach ($fields_to_display as $field)
                            {
                                echo "<th>". $field . "</th>\n";
                            }
                        ?>
                    </tr>
                </thead>
                <tfoot >
                    <tr style="display: none;">
                    <?php                    
                            foreach ($fields_to_display as $field)
                            {
                                echo "<th>". $field . "</th>\n";
                            }
                        ?>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
      
</div>

<script>
$(document).ready(function() {
    var table = $('#load_log').DataTable( {
        "order": [[0 , "desc" ]],
        "processing": true,
        "serverSide": true,
        "stateSave": true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        "pageLength": 50,
        "ajax": "server/php/datatables_ajax_event_log.php",
        stateSave: false,
        "scrollX": true, 
        responsive: true,
        //dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
     
    } );

    $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();
 
        // Get the column API object
        var column = table.column( $(this).attr('data-column') );
 
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );    

    is_live_stream_open = false;
    $('#live_stream').on( 'click', function (e) {
        //e.preventDefault();
        if (!is_live_stream_open)
        {
          is_live_stream_open = true;        
          $('#target_video').toggleClass('col-sm-12 col-md-6 col-lg-4 grow');
          $('#target_video').toggle();
          $('#target_table').toggleClass('col-sm-12 col-md-6 col-lg-8 shrink');
          $('#video_iframe').attr('src', "<?=$hls_iframe_src?>");
        }


    } );    

    table
        .on('draw', function () {
            console.log("Draw done");
            var lightbox = new SimpleLightbox('a.gallery', { /* options */ });        
            
        });        
    
} );    
</script>
<? include 'footer.php' ?>