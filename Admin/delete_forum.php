<?php
    require_once 'helpers/db_connect.php';

    $deleteForumQuery = "DELETE FROM forums WHERE id=${_GET['id']}";
    $deleteForumResult = $conn->query($deleteForumQuery);

    header("Location: forums.php");

    $conn->close();