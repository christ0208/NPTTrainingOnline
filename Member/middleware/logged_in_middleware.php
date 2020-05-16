<?php

$startPortLocation = strpos($_SERVER['HTTP_HOST'], ":");
if($startPortLocation !== false)
    $host = substr($_SERVER['HTTP_HOST'], 0, $startPortLocation);
else
    $host = $_SERVER['HTTP_HOST'];

if(!isset($_SESSION['name']) || $_SESSION['name'] === '')
    header("Location: http://$host:8155/?url=http://${_SERVER['HTTP_HOST']}${_SERVER['REQUEST_URI']}");
