<?php

require 'vendor/autoload.php';


use OTPHP\TOTP;

include "header.php";

print_r($_SESSION);

?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center">2FA Verification</h2>


            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $code = $_POST['code'];
                    
                    $otp = TOTP::createFromSecret($_SESSION['2fa_secret']); // create TOTP object from the secret.
                    $otp->verify($code); // Returns true if the input is verified, otherwise false.

                    if ($otp->verify($code)) {
                        echo 'Login successful!';
                        // Clear session data
                        // session_unset();
                        // session_destroy();
                    } else {
                        echo 'Invalid 2FA code';
                    }
                }


                ?>
            <form action="2fa.php" method="post">
                <div class="form-group">
                    <label for="code">Enter 2FA Code</label>
                    <input type="text" class="form-control" id="code" name="code" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Verify</button>
            </form>
        </div>
    </div>
</div>
<? include "footer.php";
?>