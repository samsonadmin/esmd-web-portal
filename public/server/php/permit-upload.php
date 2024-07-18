<?php

$databaseFile = '../../upload.db';

try {
    $db = new PDO('sqlite:' . $databaseFile);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create table if it doesn't exist
    $db->exec("CREATE TABLE IF NOT EXISTS hotwork_permits (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        date_start TEXT NOT NULL,
        date_end TEXT NOT NULL,
        location TEXT NOT NULL,
        file_path TEXT NOT NULL
    )");
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit();
}

error_reporting(E_ALL | E_STRICT);

include '../../global-functions.php';
error_reporting(E_ALL);

ini_set("log_errors", 1);
ini_set("error_log", "hotwork-permit-upload-error.log");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dateStart = str_replace("/", "-", sanitize($_POST['date_start']));
    $dateEnd = str_replace("/", "-", sanitize($_POST['date_end']));
    $location = sanitize($_POST['location']);
    $file = $_FILES['file'];

    // Validate end date is not earlier than start date
    if (strtotime($dateStart) > strtotime($dateEnd)) {
        echo "End date must be the same as or later than the start date.";
        exit;
    }
    
    // Validate file size and type
    $allowedTypes = ['application/pdf', 'application/msword', 'image/jpeg', 'image/png', 'image/gif'];
    if ($file['size'] > 10 * 1024 * 1024 || !in_array($file['type'], $allowedTypes)) {
        echo "Invalid file type or size.";
        exit;
    }

    // Generate file path
    $year = date('Y');
    $month = date('m');
    $randomId = bin2hex(random_bytes(8));
    $uploadDir = "files/hotwork-permit/$year/$month/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $filePath = $uploadDir . $randomId . '-' . sanitize(basename($file['name']));
    
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        // Save form data and file path to the database

        $filePath = "server/php/". $filePath;

        $stmt = $db->prepare("INSERT INTO hotwork_permits (date_start, date_end, location, file_path) VALUES (?, ?, ?, ?)");
        $stmt->execute([$dateStart, $dateEnd, $location, $filePath]);
        echo "File uploaded successfully.";
    } else {
        echo "Error uploading file.";
    }
}
?>
