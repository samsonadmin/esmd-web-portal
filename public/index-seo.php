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
    "datetime",
    "url",
    "thumbnail",
    "detections",
    "detection_json",
    "serial_no",
    "id",
    "Name",
    "Location",
    "Remarks",
    // "feedback"
  );


if ($_SESSION['access'] === "admin")
{
    $fields_to_display = array(
        "Date Time",
        "image",
        "thumbnail",
        "detections",
        "detection_json",
        "client",
        "serial_no",
       // "git_hash",
        "ip",
        "id",
        "Name",
        "Location",
        "Remarks",
        //"sent_status",
       // "remarks",
       // "jetpack_version"
    //    "feedback"
      );
}




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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <head>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    </head>

    <style>
        #chatIcon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 30px;
            cursor: pointer;
            color: #3CB043;
        }

        /* Smaller font size for mobile */
        @media (max-width: 600px) {
            #chatIcon {
                font-size: 20px;
            }
        }

        .chat-bubble {
            padding: 10px;
            border-radius: 15px;
            margin-bottom: 10px;
            max-width: 70%;
            position: relative;
            word-wrap: break-word;
        }

        .chat-bubble::after {
            content: "";
            position: absolute;
            border-style: solid;
        }

        .chat-bubble.assistant {
            background-color: #e1ffc7;
            align-self: flex-start;
        }

        .chat-bubble.assistant.chart-container {
            width: 40vw;
            max-width: 90%;
            min-width: 280px;
        }

        .chat-bubble.assistant::after {
            border-width: 10px 10px 10px 0;
            border-color: transparent #e1ffc7 transparent transparent;
            left: -10px;
            top: 10px;
        }

        .chat-bubble.user {
            background-color: #d1e7ff;
            align-self: flex-end;
            text-align: right;
        }

        .chat-bubble.user::after {
            border-width: 10px 0 10px 10px;
            border-color: transparent transparent transparent #d1e7ff;
            right: -10px;
            top: 10px;
        }

        .chat-message {
            display: flex;
            flex-direction: column;
        }

        #chatWindow {
            display: flex;
            flex-direction: column;
        }

        .feedback-section {
            border-top: 1px solid #ccc;
            padding: 5px;
            text-align: center;
            background-color: #f9f9f9;
        }

        .feedback-icons {
            display: flex;
            justify-content: space-around;
            margin-top: 10px;

        }

        .feedback-button {
            background: none;
            border: none;
            cursor: pointer;
            text-align: center;
            color: #808080;
        }

        .feedback-button i {
            font-size: 25px;
        }

        .feedback-button[data-feedback="good"]:hover {
            color: green;
        }

        .feedback-button[data-feedback="unsatisfied"]:hover {
            color: orange;
        }

        .feedback-button[data-feedback="incorrect"]:hover {
            color: red;
        }

        .recording {
            color: red;
        }

        .record-button{
            background: none; /* No background */
            border: none; /* No border */
            padding-left: 15px;
            padding-right: 15px;
            cursor: pointer; /* Change cursor to pointer to indicate it's clickable */
            font-size: 20px;
            color: grey;
            position: relative;

        }

        .record-button:hover{
            color: black;
        }

        .record-modal {
            display: none;
            width: 180px;
            position: absolute;
            top: -90px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #e5e5e5;
            padding: 10px;
            border-radius: 5px;
            z-index: 1000;
            font-size: 14px;
            color: #000;
            pointer-events: none;
        }

        .record-modal::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-top: 10px solid #e5e5e5;
            border-bottom: none;
        }


        .record-modal.show {
            display: block;
        }



    </style>

    </style>
        <i id = "chatIcon" class = "fas fa-comments"></i>
    <!-- Bootstrap Modal -->
    <div class="modal fade" id="chatModal" tabindex="-1" aria-labelledby="chatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chatModalLabel">Assistant</h5>
                    <button class="btn btn-primary" id="viewChart" type="button" style = "margin-left: 15px; font-size: 15px;">Enable Chart Generation</button>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body" style="height: 70vh; overflow-y: auto;">
                <div id="chatWindow" style="height: 87%; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
                        <!-- Chat messages will appear here -->
                    </div>
                <div id="chartContainer" style="display: none;">
                    <div id="chart"></div>
                </div>

                    <div class="input-group mt-3">
                        <input type="text" id="userInput" class="form-control" placeholder="Type your enquiry...">
                        <button class = "record-button" id="recordButton">
                            <i class="fa-solid fa-microphone"></i>
                            <div class="record-modal" id="recordingModal">Recording in progress. Click the icon again to stop recording.</div>
                        </button>
                        <div class="input-group-append">
                            <button class="btn btn-primary" id="sendBtn" type="button">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

// Handle chart generation
let viewChart = false;
let mediaRecorder;
let audioChunks = [];
let isRecording = false;


document.addEventListener('DOMContentLoaded', function() {
    viewChart = false; // Initialize the viewChart state
    var viewChartButton = document.getElementById('viewChart');

    // Update button text and color
    function updateButton() {
        if (viewChart) {
            viewChartButton.classList.remove('btn-primary');
            viewChartButton.classList.add('btn-danger');
            viewChartButton.textContent = 'Disable Chart Generation';
        } else {
            viewChartButton.classList.remove('btn-danger');
            viewChartButton.classList.add('btn-primary');
            viewChartButton.textContent = 'Enable Chart Generation';
        }
        console.log(viewChart);

    }

    // Initial update of the button
    updateButton();

    // Event listener for the button click
    viewChartButton.addEventListener('click', function() {
        viewChart = !viewChart;
        updateButton();
    });
});


// Format response
function formatResponse(tupleString) {
    // // console.log(tupleString);
    // if (tupleString.trim() === "") {
    //     return "Invalid enquiry. Please input enquiry about the data.";
    // }

    // Replace image URLs with <img> tags
    let htmlString = tupleString.replace(/(https?:\/\/[^\s]+?\.(?:jpg|jpeg))/g, '<img src="\$1" alt="Image Output" style="max-width: 100%; height: auto; margin-top: 10px; border-radius: 10px;"><br>');

    // Remove square brackets and commas if there is only one element
    htmlString = htmlString.replace(/[\[\]]/g, '');
    htmlString = htmlString.replace(/,\)/g, ')');

    // Split the string into individual tuples
    let tuples = htmlString.split('),').map(tuple => tuple.trim());

    // Remove leading and trailing parentheses and single quotes from each tuple
    tuples = tuples.map(tuple => tuple.replace(/[\(\)']/g, '').trim());

    // For each tuple, split by comma and trim each element
    tuples = tuples.map(tuple => tuple.split(',').map(item => item.trim()));

    // Join items within each tuple with commas (only if more than one item) and separate tuples with <br> tags
    htmlString = tuples.map(tuple => tuple.join(', ')).join('<br>');

    return htmlString;
}

var chartCounter = 0;

function renderChart(finalResponse) {
    var chartId = 'chart-' + chartCounter++;

    // $('#chatWindow').append('<div id="chartContainer-' + chartId + '" class="chat-message"><div class="chat-bubble assistant"><strong>Assistant<br></strong><div id="' + chartId + '"></div></div></div>');
    $('#chatWindow').append(
        '<div id="chartContainer-' + chartId + '" class="chat-message">' +
        '<div class="chat-bubble assistant chart-container"><strong>Assistant<br></strong>' +
        '<div id="' + chartId + '" style="width: 100%;"></div>' +
        '</div></div>'
    );

    finalResponse = '(' + finalResponse + ')';
    var chartOptions = new Function('return ' + finalResponse)();

    var chart = new ApexCharts(document.querySelector("#" + chartId), chartOptions);
    chart.render();
}

document.getElementById('recordButton').addEventListener('click', async () => {
    if (!isRecording) {
        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        mediaRecorder = new MediaRecorder(stream);

        mediaRecorder.ondataavailable = event => {
            audioChunks.push(event.data);
        };

        mediaRecorder.onstop = async () => {
            const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
            audioChunks = [];

            document.getElementById('userInput').placeholder = "Processing your voice. Please wait a moment…";

            const formData = new FormData();
            formData.append('audio', audioBlob);

            $.ajax({
                url: '/transcribe',
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    document.getElementById('userInput').placeholder = "Type your enquiry...";
                    document.getElementById('userInput').value = response.transcription;
                    console.log(response.transcription)
                },
                error: function(xhr, status, error) {
                    document.getElementById('userInput').placeholder = "Type your enquiry...";
                    alert('Empty voice file detected. Please input voice.');
                    console.error('Error:', error);
                }
            });
        };
        mediaRecorder.start();
        isRecording = true;
        document.querySelector('#recordButton i').classList.add('recording');
        document.getElementById('recordingModal').classList.add('show');

        setTimeout(() => {
            if (isRecording) {
                mediaRecorder.stop();
                isRecording = false;
                alert('Cannot input voice that is longer than 15 seconds.');
                document.querySelector('#recordButton i').classList.remove('recording');
                document.getElementById('recordingModal').classList.remove('show');
            }
        },30000); // Set maximum recording time to 15 seconds

    } else {
        mediaRecorder.stop();
        isRecording = false;
        document.querySelector('#recordButton i').classList.remove('recording');
        document.getElementById('recordingModal').classList.remove('show');

    }
});



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
            { "visible": false,  "targets": [2,5,6,7,8,9], title: ''} ,
            { title: 'Date & Time',  "targets": 0 } ,
            {
                // The `data` parameter refers to the data for the cell (defined by the
                // `data` option, which defaults to the column being worked with, in
                // this case `data: 0`.
                title: 'Image',
                "render": function ( data, type, row ) {
                    //return data +' ('+ row[2]+')';
                    return '<a class="gallery" href="' + data + '" target="_blank"><img src="' + row[2]+ '" style="max-height: 80px; " title="' + row[0] + ': ' + row[3] + '" /></a>';
                },
                "targets": 1, "orderable": false
            },

            { title: 'Detection / Types',  "targets": 3,
                render: function ( data, type, row)
                {
                    return data + ' <a href="preview.php?id=' + row[6] + '" target="_blank" title="Preview" ><i class="bi bi-search"></i></i></a>';
                }
            } ,
            {
                title: 'Site / Location',  "targets": 4 ,
                render: function ( data, type, row)
                {
                    return '<a href="https://carryai-' + row[5] + '-video.carryai.co" class="hls_video" title="'+row[5]+'"><i class="bi bi-camera-video"></i></a> ' + row[7] + "<br />" + row[8] + "<br />" + row[9];
                }
            },
            // {
            //     title: 'Detection Feedback'
            // }

            <? } else { ?>

            { "visible": false,  "targets": [2,9,10,11], title: ''} ,
            {
                // The `data` parameter refers to the data for the cell (defined by the
                // `data` option, which defaults to the column being worked with, in
                // this case `data: 0`.
                title: 'Image', "orderable": false,
                "render": function ( data, type, row ) {
                    //return data +' ('+ row[2]+')';
                    return '<a class="gallery" href="' + data + '" target="_blank"><img src="' + row[2]+ '" style="max-height: 80px; " title="' + row[0] + ': ' + row[3] + '" /></a>';
                },
                "targets": 1
            },
            { title: 'Date & Time',  "targets": 0 } ,
            { title: 'Detection / Types',  "targets": 3 } ,
            { title: 'Detection JSON',  "targets": 4, "orderable": false,
                render: function ( data, type, row)
                {
                    return data + ' <a href="preview.php?id=' +  row[8] + '&serial_no='+ row[6]+ '"><i class="bi bi-chat-left-dots"></i></a>';   ;
                }
             } ,
            { title: 'Client',  "targets": 5 } ,
            {
                title: 'Serial no(HLS)',  "targets": 6 ,
                render: function ( data, type, row)
                {
                    return data + " " +'<a href="https://carryai-' + data + '-video.carryai.co" target="_blank" class="hls_video"> <i class="bi bi-camera-video"></i></a> ' +
                    row[9] + "<br />" + row[10] + "<br />" + row[11] ;
                }
            } ,
            { title: 'Detection Machine IP',  "targets": 7, "orderable": false } ,
            {
                title: 'Zoning',  "targets": 8 ,
                render : function ( data, type, row){
                    return '<a href="zoning.php?id=' + data + '&serial_no='+ row[6]+ '" target="_blank"><i class="bi bi-bullseye"></i></a>';
              }
            },
            // {title: 'Detection Feedback'
            // }

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

        // Handle chat icon click
        $('#chatIcon').click(function() {
                $('#chatModal').modal('show');
        });

        // Handle send button click
        $(document).ready(function() {
            var currentQuestion = '';
            var currentAnswer = '';

            $('#sendBtn').click(function() {
                var userInput = $('#userInput').val();

                if (userInput.trim() !== '') {
                    $('#feedbackButtons').remove();

                    $('#chatWindow').append('<div class="chat-message"><div class="chat-bubble user"><strong>You<br></strong> ' + userInput + '</div></div>');
                    $('#userInput').val(''); // Clear input field


                    currentQuestion = userInput; // Store the current question
                    var startTime = Date.now();
                    var executionTime;
                    $.ajax({
                        // url: './llm_assistant/process_query.php',
                        //url: 'http://127.0.0.1:5000/process_query',
                        url: '/process_query',
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify({
                            user_input: userInput,
                            view_chart: viewChart
                        }),
                        success: function(response) {
                            // console.log(response)
                            var finalResponse;
                            if (response.error) {
                                // Handle the error case
                                var endTime = Date.now();
                                executionTime = endTime - startTime;
                                var errorMessage = response.error;
                                $('#chatWindow').append('<div class="chat-message"><div class="chat-bubble assistant"><strong>Assistant</strong><br>' + errorMessage + '</div></div>');
                                $.ajax({
                                    url: './llm_assistant/submit_feedback.php',
                                    type: 'POST',
                                    contentType: 'application/json',
                                    data: JSON.stringify({
                                        question: currentQuestion,
                                        answer: errorMessage,
                                        feedback: 'error',
                                        comment: 'automatic feedback; system generated error',
                                        execution_time: executionTime
                                    }),
                                    success: function(response) {
                                        console.log('Automatic feedback submitted successfully.');
                                    },
                                    error: function(error) {
                                        console.log('Error submitting automatic feedback:', error);
                                    }
                                });
                            }
                            else {
                                if (viewChart){
                                    finalResponse = response.chart_result;
                                    renderChart(finalResponse);
                                }
                                else {
                                    finalResponse = formatResponse(response.result);
                                    $('#chatWindow').append('<div class="chat-message"><div class="chat-bubble assistant"><strong>Assistant<br></strong> ' + finalResponse + '</div></div>');
                                }
                                var endTime = Date.now()
                                executionTime = endTime - startTime;
                                var feedbackSection = `
                                    <div class="feedback-section" id="feedbackButtons">
                                        <p style = "font-size: 18px;">Did you like the response?</p>
                                        <div class="feedback-icons">
                                            <button class="feedback-button" data-feedback="good">
                                                <i class="fas fa-thumbs-up"></i><br><span style="font-size: 15px;">Good</span>
                                            </button>
                                            <button class="feedback-button" data-feedback="unsatisfied">
                                                <i class="fas fa-meh"></i><br><span style="font-size: 15px;">Unsatisfied</span>
                                            </button>
                                            <button class="feedback-button" data-feedback="incorrect">
                                                <i class="fas fa-thumbs-down"></i><br><span style="font-size: 15px;">Incorrect</span>
                                            </button>
                                        </div>
                                    </div>
                                `;
                                $('#chatWindow').append(feedbackSection);
                                $('#chatWindow').scrollTop($('#chatWindow')[0].scrollHeight); // Scroll to bottom

                                currentAnswer = finalResponse; // Store the current answer
                                $('.feedback-button').click(function() {
                                    var feedback = $(this).data('feedback');
                                    var comment = '';

                                    if (feedback === 'incorrect' || feedback === 'unsatisfied') {
                                        comment = prompt('Please provide additional comments:');
                                        if (comment === null) {
                                            // User pressed Cancel, so return early and do not proceed with the AJAX request
                                            return;
                                        }
                                    }

                                    $.ajax({
                                        url: './llm_assistant/submit_feedback.php',
                                        type: 'POST',
                                        contentType: 'application/json',
                                        data: JSON.stringify({
                                            question: currentQuestion,
                                            answer: currentAnswer,
                                            feedback: feedback,
                                            comment: comment,
                                            execution_time: executionTime
                                        }),
                                        success: function(response) {
                                            alert('Feedback submitted successfully.');
                                            $('#feedbackButtons').hide(); // Hide feedback buttons after submission
                                        },
                                        error: function(error) {
                                            console.log('Error:', error);
                                            alert('Error submitting feedback.');
                                        }
                                    });
                                });
                            }
                        },
                        error: function(error) {
                            var endTime = Date.now()
                            executionTime = endTime - startTime;
                            $('#chatWindow').append('<div class="chat-message"><div class="chat-bubble assistant"><strong>Assistant</strong><br> Error processing your request. </div></div>');

                            $.ajax({
                                url: './llm_assistant/submit_feedback.php',
                                type: 'POST',
                                contentType: 'application/json',
                                data: JSON.stringify({
                                    question: currentQuestion,
                                    answer: 'Error processing your request.',
                                    feedback: 'error',
                                    comment: "unknown Error",
                                    execution_time: executionTime
                                }),
                                success: function(response) {
                                    console.log('Automatic feedback submitted successfully.');
                                },
                                error: function(error) {
                                    console.log('Error submitting automatic feedback:', error);
                                }
                            });

                        }
                    });
                }
            });
        });

        // Handle enter key in input field
        $('#userInput').keypress(function(e) {
            if (e.which == 13) {
                $('#sendBtn').click();
            }
        });
} );


</script>

<? include "footer.php"; ?>