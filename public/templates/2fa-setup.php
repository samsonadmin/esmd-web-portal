<?php
header('Pragma: no-cache');
header('Cache-Control: private, no-cache');
header('X-Content-Type-Options: nosniff');
header('Connection: close');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');


include 'global-functions.php';
include 'cms_auth.php';

require 'vendor/autoload.php';
//$pdo = require '2fa-db.php'; // Include PDO initialization


//$_SESSION['2fa_skip'] = true; //only used for doing the 2fa_setup, if user has setup previously but lost, and r

display_login_form();



use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;


$username = $_SESSION['admin_user'];

if ( isset ($_SESSION['2fa_secret']))
{
    $errors[] = "2FA is already setup";
}


$g = new GoogleAuthenticator();
$secret = $g->generateSecret();

// // Save the secret to the database
// $stmt = $pdo->prepare('UPDATE users SET secret = :secret WHERE username = :username');
// $stmt->execute(['secret' => $secret, 'username' => $username]);

//$_SESSION['2fa_secret'] = $secret;

$domainName = $_SERVER['HTTP_HOST'];

$qrCodeUrl = GoogleQrUrl::generate($username, $secret, $domainName . '-AI-Safety');


include "header.php";

?>
<div class="container-md my-3">

    <form method="post">

    <div class="mb-3 row justify-content-center form-group">
        <div class="col-md-8">    
            <h2>Setup 2FA</h2>
        </div>
    </div>  

    <div class="errors mb-3 row justify-content-center">
        <div class="col-md-8">
            <? display_errors(); ?>       
        </div>
    </div>
    
    <div class="mb-3 row justify-content-center form-group">
        <div class="col-md-8">
            
            <p>Scan the QR code below with your Google Authenticator app:</p>
            <img src="<?php echo $qrCodeUrl; ?>" alt="QR Code" style="display:block; margin: 10px auto;">
            <p>Or enter this code manually: <strong><?php echo $secret; ?></strong></p>

        </div>
    </div>

    <div class="mb-3 row justify-content-center form-group">
		<label for="2fa_test" class="col-sm-2 col-form-label">2FA Code:</label>
			<div class="col-md-6">
			<input type="text" name="2fa_test"  class="form-control" required>
			</div>
		</div>
				

		<div class="mb-3 row justify-content-center form-group">
            <label for="" class="col-sm-2 col-form-label"></label>
            <div class="col-md-6">
            <input class="btn btn-primary" type="submit" value="2FA Verfication" />        
      </div>
	</div>
        

    </form>
</div>
</body>
</html>
