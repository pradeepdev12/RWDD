<?php
// store_data.php

// EC2 instance details
$ec2_host = 'ip-172-31-9-198'; // Your EC2 instance address
$ec2_user = 'ec2-user';
$ec2_keyfile = '/c/Users/HP/Downloads/rwdd.pem';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $weight = $_POST['weight'];
    $height = $_POST['height'];
    $first_time = $_POST['first_time'];

    $data = json_encode([
        'name' => $name,
        'email' => $email,
        'username' => $username,
        'password' => $password,
        'age' => $age,
        'gender' => $gender,
        'weight' => $weight,
        'height' => $height,
        'first_time' => $first_time
    ]);

    // Set up the SSH connection
    $connection = ssh2_connect($ec2_host, 22);
    ssh2_auth_pubkey_file($connection, $ec2_user, $ec2_keyfile . '.pub', $ec2_keyfile);

    // Store data on EC2 instance
    $stream = ssh2_exec($connection, 'echo ' . escapeshellarg($data) . ' >> /home/ec2-user/customer_details.txt');
    stream_set_blocking($stream, true);

    $output = stream_get_contents($stream);
    fclose($stream);

    echo "Data stored successfully on EC2 instance.";
}
?>
