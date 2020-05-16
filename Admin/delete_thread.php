<?php
    require_once 'helpers/db_connect.php';

    $deleteThreadQuery = "DELETE FROM threads WHERE id=${_GET['id']}";
    $deleteThreadResult = $conn->query($deleteThreadQuery);

    header("Location: detail_forum.php?id=${_GET['forum_id']}");

    $conn->close();