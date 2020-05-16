<?php

session_start();

session_regenerate_id(true);
unset($_SESSION['user_id']);
unset($_SESSION['name']);

header("Location: http://${_SERVER['HTTP_HOST']}");