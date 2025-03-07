<?php
// store_data.php

// Include the AWS SDK for PHP
require 'vendor/autoload.php';

use Aws\S3\S3Client;

// Create an S3 client
$s3 = new S3Client([
    'version' => 'latest',
    'region'  => 'us-west-2',
    'credentials' => [
        'key'    => 'your-access-key',
        'secret' => 'your-secret-key',
    ],
]);

// Handle data storage
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['data']; // Get data from the HTML form

    // Store data in S3
    $result = $s3->putObject([
        'Bucket' => 'your-bucket-name',
        'Key'    => 'data.txt',
        'Body'   => $data,
    ]);

    echo "Data stored successfully: " . $result['ObjectURL'];
}
?>
