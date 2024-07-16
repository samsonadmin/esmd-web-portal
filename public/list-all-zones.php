<?
//phpinfo();



header('Pragma: no-cache');
header('Cache-Control: private, no-cache');
header('X-Content-Type-Options: nosniff');
header('Connection: close');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

include 'global-functions.php';
include 'cms_auth.php';

$debug = false;
if ( isset($_REQUEST['debug']))
{
  $debug = true;
  error_reporting(E_ALL | E_STRICT);
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
}

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

//$sql = "SELECT DISTINCT ai_detections.serial_no, machine_information.id, machine_information.location, machine_information.name, machine_information.remarks, machine_information.mobile, machine_information.email   FROM ai_detections  LEFT JOIN machine_information ON ai_detections.serial_no = machine_information.serial_no ";



$fields_to_display = array(   
    "serial_no",        
    "name",
    "location",
    "remarks",
    // "mobile",
    // "email",
    "id",
    "id",
    "id"
    
    );



include "header.php";

// $serial_no_receiving_alerts = array();
// $serial_no_receiving_alerts[] = "1423421009432";
// $serial_no_receiving_alerts[] = "1421621053802"; //Spare unit 1
// $serial_no_receiving_alerts[] = "1421621055084"; //Hung Shui Kiu
// $serial_no_receiving_alerts[] = "1422921152970"; //VHSoft Dev Test
// //$serial_no_receiving_alerts[] = "x86_64-UNKNOWN";
// $serial_no_receiving_alerts[] = "1421621055527";
// $serial_no_receiving_alerts[] = "1421621053134"; //RGT Spare unit 3
// $serial_no_receiving_alerts[] = "1420623040085"; //DEMO Machine RGT Show Room
// $serial_no_receiving_alerts[] = "1420822032829"; //Tung Chung Area 99
// $serial_no_receiving_alerts[] = "1421621053134"; //kwu tung
// $serial_no_receiving_alerts[] = "00001234500a";
// $serial_no_receiving_alerts[] = "00001234500b";
// $serial_no_receiving_alerts[] = "00001234500c";
// $serial_no_receiving_alerts[] = "00001234500d";
// $serial_no_receiving_alerts[] = "1421621053802"; //Wanchai
// $serial_no_receiving_alerts[] = "1420822032829"; //new on 2024 apr 23
// $serial_no_receiving_alerts[] = "1421621052904"; //just for test Yau Lee Shui On
// $serial_no_receiving_alerts[] = "1421621055038"; //just for test Yau Lee Shui On

// $json_data = json_encode($serial_no_receiving_alerts);



// Read the JSON file
$json_string = file_get_contents('serial_no_receiving_alerts.json');

// Decode the JSON string into a PHP array
$serial_no_receiving_alerts = json_decode($json_string, true);

// Check if decoding was successful
if ($serial_no_receiving_alerts === null) 
{
    $serial_no_receiving_alerts = array();
}

?>

<div class="container-md">

    <span style="color: red;">Alert Check box (if tick, will receive alert, otherwise not alert received, once it is clicked, it will be saved immediately)</span>
    <div id="tableInfo"></div>
            
    <table id="load_log" class="display compact" style="width:100%">
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

    </table>
    
      
</div>
<script>
var serial_no_receiving_alerts = <?=$json_string?>;

$(document).ready(function() {

    //$.fn.dataTable.moment( 'YYYY-MM-DD' );


    var table = $('#load_log').DataTable( {
        "order": [[0 , "asc" ]],
        "processing": true,
        "serverSide": false,
        "stateSave": true,
        pagingType: 'full_numbers',
        "ajax": "server/php/datatables_ajax_server_processing_unique_serial.php",
        "scrollX": true, 
        paging: false, 
        responsive: true,
        "columnDefs": [
            { 
                title: 'Serial no ',  "targets": 0 ,
                render: function ( data, type, row)
                {
                    return '<a href="https://carryai-' + data + '-video.carryai.co" target="_blank" class="hls_video">' + data + '</a>'; 
                }
            }, 
            { 
                title: 'Name',  "targets": 1 ,
            }, 
            { 
                title: 'Location',  "targets": 2 ,
            },       
            { 
                title: 'Remarks',  "targets": 3 ,
            },          
            { 
                title: 'Receive alerts',  "targets": 4 ,
                render: function (data, type, row) 
                {
                    if ( type === 'display')
                    {
                        return '<input type="checkbox" class="editor-active" data-serial_no="'+row[0]+'">';
                    }
                    return data;
                    
                },
                className: 'dt-body-center'
                
            },                      
            { 
                title: 'Edit',  "targets": 5 ,
                render: function ( data, type, row)
                {
                    return '<a href="edit.php?serial_no=' + row[0] + '"><i class="bi bi-pencil-square"></i></a>'; 
                }
            }, 
            { 
                title: 'zone',  "targets": 6 ,
                render: function ( data, type, row)
                {
                    return '<a href="zoning.php?id=' + data + '&serial_no='+ row[0]+ '&img=none" target="_blank"><i class="bi bi-bullseye"></i></a>'; 
                }
            }                  


        ],
        //dom: 'QBlfrtip',
        dom: 'Qlfrtip',
        deferRender: true,
        rowCallback: function ( row, data ) 
        {
            // Set the checked state of the checkbox in the table
            //$('input.editor-active', row).prop( 'checked', data.active == 1 );

            if ( serial_no_receiving_alerts.includes (data[0]) )
            {
                $('input.editor-active', row).prop( 'checked', 1);
                //console.log (data[0]) ;
            }
                
        }    
        // buttons: [
        //     'copy', 'csv', 'excel', 'pdf', 'print'
        // ]
     
    } );



    $('#load_log').on( 'change', 'input.editor-active', function () 
    {
        console.log( $(this).data('serial_no'))
        console.log( $(this).prop( 'checked' ) )

        var data_to_send = {
            serial_no: $(this).data('serial_no'),
            new_val: $(this).prop( 'checked' )
        }

        
        $.ajax({
            url: 'server/php/ajax_update_serial_no_receiving_alerts.php', // URL to send the request
            type: 'POST', // Request type
            data: data_to_send, // Data to be sent
            dataType: "json", 
            success: function(response) { // Callback function for successful request
                console.log('Request successful:', response);
                // Handle the response here
                //console.log ( response.status )
                if (response.status != "success")
                    alert ( response.status + "\n" + response.error );
            },
            error: function(xhr, status, error) { // Callback function for failed request
                console.error('Request failed:', error);
                alert("Failed to update, please contact carryai support")
                // Handle the error here
            }
        });

        // editor
        //     .edit( $(this).closest('tr'), false )
        //     .set( 'active', $(this).prop( 'checked' ) ? 1 : 0 )
        //     .submit();
    } );

    $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();
 
        // Get the column API object
        var column = table.column( $(this).attr('data-column') );
 
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );    


    table
        .on('draw', function () {
            console.log("Draw done");
            //var lightbox = new SimpleLightbox('a.gallery', a.lightBoxVideoLink', { /* options */ });        

 
            $('a.hls_video').magnificPopup({
                type:'iframe',
                mainClass: 'mfp-with-zoom', // this class is for CSS animation below
                markup: '<div class="mfp-iframe-scaler">'+
                    '<div class="mfp-close"></div>'+
                    '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
                    '</div>', // HTML markup of popup, `mfp-close` will be replaced by the close button
        
                srcAction: 'iframe_src', // Templating object key. First part defines CSS selector, second attribute. "iframe_src" means: find "iframe" and set attribute "src".        
                disableOn: function() {
                if( $(window).width() < 600 ) {
                    return false;
                }
                return true;
                }                          
            })    
       
            // setTimeout( () => 
            // {

            //     //console.log("Delayed for 1 second after draw done. //Code tobedisabled as interence drawing code added into the upload logic. Added the interence_result");
            //     //var new_img = '<img src="server/php/image_overlay_inference_results.php" width="1" height="1" />';
            //     //$("body").append(new_img);

            // },1000)
            

        

        });        
    
    


    
} );    
</script>
<? include "footer.php"; ?>