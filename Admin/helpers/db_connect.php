<?php

$conn = new mysqli("127.0.0.1", "root", "", "cpforum");
if($conn->connect_error) {
    die("Connection Error: $conn->connect_error");
}