<?php
require_once 'helpers/db_connect.php';

$query = "DELETE FROM users WHERE id=${_GET['id']}";
$result = $conn->query($query);

$conn->close();
if($result) {
    header('Location: members.php');
} else {
    echo 'Internal Server Error';
}