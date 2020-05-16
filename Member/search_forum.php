<?php
    require_once 'helpers/db_connect.php';
    session_start();

    require_once 'middleware/logged_in_middleware.php';

    require_once 'navigation_bar.php';
    
?>

<link rel="stylesheet" href="public/css/bootstrap.min.css">

<div class="container">
    <form action="" class="d-flex">
        <input type="text" name="searchQuery" id="txtSearchQuery" class="form-control flex-fill">
        <button class="btn btn-primary">
            Search
        </button>
    </form>
</div>