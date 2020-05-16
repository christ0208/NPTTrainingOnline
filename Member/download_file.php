<?php
    $path = $_GET['path'];
    if(file_exists($path)) {
        $filename = basename($path);

        file_put_contents($filename, file_get_contents($path));
    }