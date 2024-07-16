<?
//phpinfo();



header('Pragma: no-cache');
header('Cache-Control: private, no-cache');
header('X-Content-Type-Options: nosniff');
header('Connection: close');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

include 'global-functions.php';
include 'cms_auth.php';

display_login_form();


$fields_to_display = array(
    "id",
    "datetime",
    "thumbnail",
    "url",        
    "types",    
    "detections",
    "client"
  );
  
  


include "header.php";
?>

<div class="container-md">


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
        <tfoot>
            <tr>
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
<script>


$(document).ready(function() {

    //$.fn.dataTable.moment( 'YYYY-MM-DD' );


    var table = $('#load_log').DataTable( {
        "order": [[0 , "desc" ]],
        "processing": true,
        "serverSide": true,
        "stateSave": false,        
        "ajax": "server/php/datatables_ajax_server_processing.php",
        "scrollX": true, 
        "pagingType": 'full_numbers',
        "responsive": true,
        "lengthMenu": [
            [20, 50, 200, 2000, 5000, -1],
            [20, 50, 200, 2000, 5000, 'All'],
        ],
        "columnDefs": [

            <? if ($_SESSION['access'] !== "admin") { ?>

            
            <? } else { ?>

            { "visible": true,  "targets": 0, title: 'ID'} ,
            { "visible": true,  "targets": 1, title: 'Date Time'} ,
            {
                // The `data` parameter refers to the data for the cell (defined by the
                // `data` option, which defaults to the column being worked with, in
                // this case `data: 0`.
                title: 'Image', "orderable": false, 
                "render": function ( data, type, row ) {
                    return '<a class="gallery" href="' + row[3] + '" target="_blank"><img src="' + data+ '" style="max-height: 80px; " title="' + row[4] + '" /></a>';
                },
                "targets": 2
            },
            { title: 'URL',  "targets": 3, "visible": false, "orderable": false } ,
            { title: 'Alarm',  "targets": 4, 
                render: function ( data, type, row)
                {
                    return data + ' <a href="preview.php?id=' +  row[0] + '"><i class="bi bi-chat-left-dots"></i></a>';
                }  
            } ,
            { title: 'Detections',  "targets": 5 ,"visible": false} ,
            { title: 'Clients',  "targets": 6 },
            
              

            <? } ?>

        ],
        //dom: 'QBlfrtip',
        "searchBuilder": {
            <? if ($_SESSION['access'] !== "admin") { ?>
            columns: [0,3],
            <? } else { ?>
            columns: [0,3,4,5,6],
            <? } ?>
            depthLimit: 1
        },    
       // "dom": '<"wrapper"flipt>' ,
        //"dom": 'lrtip',
        dom: 'QlfBrtip',
        "deferRender": true,
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


    table
        .on('draw', function () {
            console.log("Draw done");
            //var lightbox = new SimpleLightbox('a.gallery', a.lightBoxVideoLink', { /* options */ });        

            $('a.gallery').magnificPopup({
                type:'image',
                mainClass: 'mfp-with-zoom', // this class is for CSS animation below
                closeOnContentClick: true,
                zoom: {
                    enabled: true, // By default it's false, so don't forget to enable it

                    duration: 300, // duration of the effect, in milliseconds
                    easing: 'ease-in-out', // CSS transition easing function

                    // The "opener" function should return the element from which popup will be zoomed in
                    // and to which popup will be scaled down
                    // By defailt it looks for an image tag:
                    opener: function(openerElement) {
                        // openerElement is the element on which popup was initialized, in this case its <a> tag
                        // you don't need to add "opener" option if this code matches your needs, it's defailt one.
                        return openerElement.is('img') ? openerElement : openerElement.find('img');
                    }
                }                
            })
         
 
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