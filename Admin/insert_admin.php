<?php
require_once 'helpers/db_connect.php';

$fetchUserQuery = "SELECT * FROM admins WHERE user_id=${_GET['id']}";
$fetchUserResult = $conn->query($fetchUserQuery);

if($fetchUserResult->num_rows === 0) {
    $insertUserQuery = "INSERT INTO admins (user_id) VALUES (${_GET['id']})";
    $insertUserResult = $conn->query($insertUserQuery);

    if($insertUserResult) {
        header("Location: members.php");
    } else {
        echo 'Internal Server Error';
    }
}

$conn->close();