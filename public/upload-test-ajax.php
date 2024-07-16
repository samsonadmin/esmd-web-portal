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

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<!-- Force latest IE rendering engine or ChromeFrame if installed -->
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
<meta charset="utf-8">
<title>CarryAI Image Uploader</title>
<!-- Bootstrap styles -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Generic page styles -->
<link rel="stylesheet" href="css/style.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="css/jquery.fileupload.css">
</head>
<body>
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-fixed-top .navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="https://github.com/blueimp/jQuery-File-Upload">Test upload</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">

                <li><a href="mailto:samson_li@hotmail.com">&copy; Samson Li</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <h1>Simulate Jetson Nano Detection upload</h1>
    <h2 class="lead">Multiple Files Upload Test &#8250; <a href="upload-test.php">Upload Test</a> | <a href=".">Record check</a> | <a href="gallery.php">Image Gallery</a></h2>


		<div id="fileupload" class="clear">
			<form action="/server/php/" method="POST" enctype="multipart/form-data" class="border border-light p-5">
				<div class="fileupload-buttonbar">
					<!-- The fileinput-button span is used to style the file input field as button -->
					<span class="btn btn-success fileinput-button">
						<i class="glyphicon glyphicon-plus"></i>
						<span>Select files...</span>
						<!-- The file input field used as target for the file upload widget -->
						<input id="fileupload" type="file" name="files[]" multiple />
					</span>
				</div>

                <div class="form-group">
				<label for="inputEmail1">Email address</label>
				<input type="email" name="email" class="form-control" id="inputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
				<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
			  </div>
			  <div class="form-group">
				<label for="inputDetectedObject">Detected Object</label>
				<input type="text" name="detections" class="form-control" id="inputDetectedObject" placeholder="Detected Object" value="Helmet, Polic">
			  </div>
			  <div class="form-group">
				<label for="inputGPS">GPS Location</label>
				<input type="text" name="gps" class="form-control" id="inputGPS" placeholder="GPS Location">
			  </div>
			  <div class="form-group">
				<label for="inputPassword1">Mobile</label>
				<input type="text" name="mobile" class="form-control" id="inputPassword1" placeholder="Mobile for SMS">
			  </div>
			  <div class="form-group">
				<label for="inputClient">Client</label>
				<input type="text" name="client" class="form-control" id="inputClient" placeholder="Client ID" value="167-SenianAI COMP">
			  </div>
			  <div class="form-group">
				<label for="inputSerialNumber">Device Serial Number</label>
				<input type="text" name="serial_no" class="form-control" id="inputSerialNumber" placeholder="012345678012345">
			  </div>
			  <div class="form-group">
				<label for="inputJetPack">JetPack Version</label>
				<input type="text" name="jetpack_version" class="form-control" id="inputJetPack" placeholder="4.6.1">
			  </div>
			  <div class="form-group">
				<label for="inputGetHash">Git hash</label>
				<input type="text" name="git_hash" class="form-control" id="inputGetHash" placeholder="h5c37">
			  </div>
			  <div class="form-group">
				<label for="inputArch">Client Arch</label>
				<input type="text" name="arch" class="form-control" id="inputArch" placeholder="arm64">
			  </div>
			  <div class="form-group">
				<label for="inputRemarks">Remarks</label>
				<input type="text" name="remarks" class="form-control" id="inputRemarks" placeholder="">
			  </div>			  			  			  			  
			  <input type="hidden" name="simple_form" value="1" />
			  <button id="to_be_hidden" type="submit" class="btn btn-primary">Submit</button>
			</form>

		</div>

	<br />
    <!-- The global progress bar -->
    <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files" class="files"></div>
    <br>
    <!-- The container for the uploaded files -->
    <div id="files" class="files"></div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Upload Notes</h3>
        </div>
        <div class="panel-body">
            <ul>
                <li>The maximum file size for uploads is <strong>999 KB</strong> (default file size is unlimited).</li>
                <li>Only image files (<strong>JPG, GIF, PNG</strong>) </li>
            </ul>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" crossorigin="anonymous"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="js/vendor/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->

<script src="js/jquery.iframe-transport.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="js/load-image.all.min.js"></script> 
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="js/canvas-to-blob.min.js"></script>

<!-- The basic File Upload plugin -->
<script src="js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="js/jquery.fileupload-validate.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script>
/*jslint unparam: true, regexp: true */
/*global window, $ */
$(function () {
    'use strict';
	
    // Change this to the location of your server-side upload handler:
    var url = ( window.location.hostname === "jetson-nano.mail2you.net" ?
                'server/php/' : '//jquery-file-upload.appspot.com/' );

    var  uploadButton = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Abort')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });

     $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 999000,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .text('Upload')
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);
                $(data.context.children()[index])
                    .wrap(link);
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

	$('#to_be_hidden').hide();

	navigator.geolocation.getCurrentPosition(function(location) {
		document.getElementById("inputGPS").value = location.coords.latitude+','+location.coords.longitude;
	//  console.log(location.coords.latitude);
	//  console.log(location.coords.longitude);
	//  console.log(location.coords.accuracy);
	});

});

</script>
</body>
</html>
<?
/*
error_reporting(E_ALL | E_STRICT);

$upload_handler = new UploadHandler();


if(!empty($_FILES['uploaded_file']))
{
	$path = "uploads/";
	$path = $path . basename( $_FILES['uploaded_file']['name']);

	if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path))
	{
		echo "The file ".  basename( $_FILES['uploaded_file']['name']). " has been uploaded";
	}
	else
	{
		echo "There was an error uploading the file, please try again!";
	}
}
*/
?>