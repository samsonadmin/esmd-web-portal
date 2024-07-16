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



include "header.php";
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.49.0/apexcharts.min.js" integrity="sha512-NpRqjS1hba1uc6270PmwsKwQti3CSCDkZD9/dlen3+ytOUb/azIyuaGtyewUkjazLMSdl7Zy2CVWMvGxR6vFWg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css">
<script src="js/dashboard.js?date=<?=mt_rand(10000,99999)?>"></script>

<div class="container-md">

<div id="wrapper">

<a href="https://media-serve.carryai.co/live/hktram/" target="_blank" style="display: block; text-align:center">https://media-serve.carryai.co/live/hktram/</a>
<!--
<iframe allowfullscreen style="width: 640px; height: 400px; border: 0; text-align: center; margin: 10px auto ; display: block;" src="https://media.carryai.co/live/hktram/" old_src="https://carryai-1421023004726-video.carryai.co/video.html"></iframe>
-->



<div id="chart"></div>

<div id="chart2"></div>
<div id="detection_results" style="display: none;">Loading...</div>

<script>

function get_detection_result()
{
        $.ajax({
    url: "https://carryai-1421023004726-video.carryai.co/api/show-current",				
            type: "GET",							
            data: { 	
            },
    dataType: 'json',
            success: function (response) {

                //$("#detection_results").html("Done, "+ response);

                //parsed_data = jQuery.parseJSON(response);
                //console.log(JSON.stringify(response));

        //$("#detection_results").html(JSON.stringify(response.detections) +  JSON.stringify(response.count));
        //parsed_data = JSON.stringify(response);
                //console.log(response);


        if ( parseInt(response.crowd_avg_count) < 50)
        sentence = " <50";
        else
        sentence = response.crowd_avg_count ;
        $("#overlays-text").html( "<div class='line1'>"+ convertUnixTimestamp(response.last_sent) + "</div><div class='line2'>" + sentence + "</div>");

        setTimeout(() => {
        //$("#detection_results").html(JSON.stringify(response.detections) +  JSON.stringify(response.count) + " .. ");
        //$("#detection_results").html(parsed_data + " .. ");

        
        get_detection_result();
        }, 400)

        
            },
            error: function (xhr, status) {
                // handle errors
        $("#detection_results").html("ERROR");
        console.log(status);

            },
            dataType: "json",
            timeout: 6000 // sets timeout to 6 seconds
        });        
    
}

function update_chart1()
{
    $.ajax({
        url: 'hktram-ajax.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
           var crowdData = data.map(function(item) {
                return {
                    x: new Date(item.x),
                    y: item.y1
                };
            });



            var options = {
                series: [
                    {
                        name: 'Crowd Count',
                        data: crowdData
                    }
                ],
                chart: {
                    type: 'line',
                    height: 350,
                    zoom: {
                      enabled: true
                    }                    
                },
                xaxis: {
                    type: 'datetime',
                    labels: {
                        formatter: function(value) {
                            return new Date(value).toLocaleString('en-US', {timeZone: 'Asia/Hong_Kong'});
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector('#chart'), options);
            chart.render();


            /////////////----------------////////

       

        },
        error: function(xhr, status, error) {
            console.log('Error:', error);
        }
    });
}


</script>  

      
</div>

<script>
$(document).ready(function() {

    get_detection_result();
    update_chart1();
    //setInterval(update_chart1, 10000); 
} );    
</script>
<? include "footer.php"; ?>