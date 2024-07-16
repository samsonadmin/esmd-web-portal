<?

header('Pragma: no-cache');
header('Cache-Control: private, no-cache');
header('X-Content-Type-Options: nosniff');
header('Connection: close');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

include 'global-functions.php';
include 'cms_auth.php';

// Define the path to the debug file
$debugFile = 'server/php/debug.txt';

display_login_form();

include "header.php";

?>

<div class="container-md">
<?
// Check if the file exists
if (file_exists($debugFile)) {
    // Read the contents of the file
    $content = file_get_contents($debugFile);

    // Display the contents
    echo "<pre>" . htmlspecialchars($content) . "</pre>";
} else {
    // Display an error message if the file does not exist
    echo "The file 'debug.txt' does not exist.";
}

?>
</div>
<?
include "footer.php";
?>
