<?php
require_once 'helpers/db_connect.php';

$fetchUserQuery = "SELECT * FROM admins WHERE user_id=${_GET['id']}";
$fetchUserResult = $conn->query($fetchUserQuery);

if($fetchUserResult->num_rows) {
    $deleteUserQuery = "DELETE FROM admins WHERE user_id=(${_GET['id']})";
    $deleteUserResult = $conn->query($deleteUserQuery);

    if($deleteUserResult) {
        header("Location: members.php");
    } else {
        echo 'Internal Server Error';
    }
}

$conn->close();