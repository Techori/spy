<?php
$date = date('dMYHis');
$imageData = $_POST['cat'];

if (!empty($imageData)) {
    error_log("Received" . "\r\n", 3, "Log.log");

    // Remove base64 header (e.g., "data:image/png;base64,")
    $filteredData = substr($imageData, strpos($imageData, ",") + 1);

    // Decode base64 data to binary
    $unencodedData = base64_decode($filteredData);

    // Ensure the directory 'saved_photos/' exists
    $saveDir = 'saved_photos/';
    if (!is_dir($saveDir)) {
        mkdir($saveDir, 0755, true);
    }

    // Create full path for the file
    $filePath = $saveDir . 'cam' . $date . '.png';

    // Write binary data to the file
    $fp = fopen($filePath, 'wb');
    fwrite($fp, $unencodedData);
    fclose($fp);
}

exit();
?>
