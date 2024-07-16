<?php
header('Pragma: no-cache');
header('Cache-Control: private, no-cache');
header('X-Content-Type-Options: nosniff');
header('Connection: close');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');


// Report all PHP errors
error_reporting(E_ALL);

// Display errors in the HTML output
ini_set('display_errors', 1);

// Optionally, you can also set the display_startup_errors directive to show errors that occur during PHP's startup sequence
ini_set('display_startup_errors', 1);

require 'vendor/autoload.php';

use OTPHP\TOTP;

// Generate a TOTP object
$otp = TOTP::create();


// Set the label (usually in the format "user@example.com")
$otp->setLabel('user@example.com');

// Set the issuer (your application name)
$otp->setIssuer('YourAppName');

// Get the secret key
$secret = $otp->getSecret();

// Display the secret key (for demonstration purposes)
echo "Secret: " . $secret . "<br>";

$grCodeUri = $otp->getQrCodeUri(
    'https://api.qrserver.com/v1/create-qr-code/?data=[DATA]&size=300x300&ecc=M',
    '[DATA]'
);
echo "<img src='{$grCodeUri}'>";

// Display the QR code URL
echo "QR Code URL: <a href='" . $grCodeUri . "' target='_blank'>Scan this QR code with Google Authenticator</a><br>";


// Verify the code entered by the user
if (isset($_POST['code'])) {
    $code = $_POST['code'];
    
    $otp = TOTP::createFromSecret($secret); // create TOTP object from the secret.
    $otp->verify($input); // Returns true if the input is verified, otherwise false.

    if ($result) {
        echo "Code is valid!";
    } else {
        echo "Invalid code!";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the username already exists
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo 'Username already exists. Please choose a different username.';
    } else {
        try {
            // Insert user into database
            $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
            $stmt->execute(['username' => $username, 'password' => $password]);

            echo 'User registered successfully!';
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center">Register</h2>
            <form action="2fa-register.php" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
