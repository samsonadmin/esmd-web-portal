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

<div class="container-md content">


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

    <!-- Chatbot  -->
    <a href="#"><i id="chatIcon" data-lucide="bot-message-square"></i></a>
    <!-- <i id = "chatIcon" data-lucide="message-circle-question"></i> -->

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
                    </div>
                <div id="chartContainer" style="display: none;">
                    <div id="chart"></div>
                </div>
                    <div class="input-group mt-3">
                        <input type="text" id="userInput" class="form-control" placeholder="Type your enquiry...">
                        <button id="recordButton">
                            <i data-lucide="mic-off" id="recordIcon"></i>
                            <div id="recordingModal">Recording in progress. Click the icon again to stop recording.</div>
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

// Handle chatbot chart generation
let viewChart = false;
var chartCounter = 0;

// Handle chatbot audio input
let mediaRecorder;
let audioChunks = [];
let isRecording = false;

// Handle enable chart generation button
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
    }

    // Initial update of the button
    updateButton();

    // Event listener for the button click
    viewChartButton.addEventListener('click', function() {
        viewChart = !viewChart;
        updateButton();
    });
});

// Format chatbot response
function formatResponse(tupleString) {
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

// Render chart into the chat box
function renderChart(finalResponse) {
    var chartId = 'chart-' + chartCounter++;

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

// Handle audio input
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
        document.getElementById('recordIcon').classList.add('recording');
        document.getElementById('recordIcon').setAttribute('data-lucide', 'mic');
        lucide.createIcons();
        document.getElementById('recordingModal').classList.add('show');
        setTimeout(() => {
            if (isRecording) {
                mediaRecorder.stop();
                isRecording = false;
                alert('Cannot input voice that is longer than 15 seconds.');
                document.getElementById('recordingModal').classList.remove('show');
                document.getElementById('recordIcon').classList.remove('recording');
                document.getElementById('recordIcon').setAttribute('data-lucide', 'mic-off');
                lucide.createIcons();
            }
        },20000); // Set maximum recording time to 20 seconds

    } else {
        mediaRecorder.stop();
        isRecording = false;
        document.getElementById('recordingModal').classList.remove('show');
        document.getElementById('recordIcon').classList.remove('recording');
        document.getElementById('recordIcon').setAttribute('data-lucide', 'mic-off');
        lucide.createIcons();
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


            <? } else { ?>

            { "visible": false,  "targets": 0, title: 'ID'} ,
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

        // Chatbot
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
                        url: '/process_query',
                        type: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify({
                            user_input: userInput,
                            view_chart: viewChart
                        }),
                        success: function(response) {
                            var finalResponse;
                            if (response.error) {
                                // Handle the error case
                                var endTime = Date.now();
                                executionTime = endTime - startTime;
                                var errorMessage =       response.error;
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
                                                <i data-lucide="thumbs-up"></i><br><span style="font-size: 15px;">Good</span>
                                            </button>
                                            <button class="feedback-button" data-feedback="unsatisfied">
                                                <i data-lucide="meh"></i><br><span style="font-size: 15px;">Unsatisfied</span>
                                            </button>
                                            <button class="feedback-button" data-feedback="incorrect">
                                                <i data-lucide="thumbs-down"></i><br><span style="font-size: 15px;">Incorrect</span>
                                            </button>
                                        </div>
                                    </div>
                                `;
                                $('#chatWindow').append(feedbackSection);
                                lucide.createIcons();
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