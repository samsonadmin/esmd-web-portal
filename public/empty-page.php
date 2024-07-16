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

<div class="container-md">


      
</div>
<script>


$(document).ready(function() {


    
} );    
</script>
<? include "footer.php"; ?>