<?php
    require_once 'helpers/db_connect.php';
    session_start();

    require_once 'middleware/logged_in_middleware.php';

    require_once 'navigation_bar.php';

    if(isset($_GET['search'])) {
        $forumsQuery = "SELECT * FROM forums WHERE title='${_GET['searchQuery']}'";
        $forumsResult = $conn->query($forumsQuery);
    }
?>

<link rel="stylesheet" href="public/css/bootstrap.min.css">

<div class="container p-3">
    <form action="" class="d-flex">
        <input type="text" name="searchQuery" id="txtSearchQuery" class="form-control flex-fill">
        <button class="btn btn-primary" name="search" type="submit">
            Search
        </button>
    </form>
    <?php
        if(isset($_GET['search'])) {
            ?>
            <div>
                Search Keyword: <?= $_GET['searchQuery'];?>
            </div>
            <table class="table table-hover mt-2">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Name</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($forumsResult->num_rows === 0) {
            ?>
            <tr>
                <td>No Forum Found</td>
            </tr>
            <?php
        } else {
            while($forumResult = $forumsResult->fetch_assoc()) {
                ?>
                <tr>
                    <td>
                        <a href="detail_forum.php?id=<?= $forumResult['id'];?>"><?= $forumResult['title'];?></a>
                        <br>
                        Created: <?= $forumResult['created_at'];?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>
            <?php
        }
    ?>
</div>