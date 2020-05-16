<?php
    $path = "http://${_SERVER['HTTP_HOST']}/${_GET['path']}";
    if(file_exists($path)) {
        $filename = basename($path);

        echo file_get_contents($path);
    }