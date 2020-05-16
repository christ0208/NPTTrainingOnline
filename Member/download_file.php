<?php
    $filename = basename($_GET['path']);
    file_put_contents($filename, fopen($_GET['path'], 'r'));