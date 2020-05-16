<?php
    require_once 'helpers/db_connect.php';
    session_start();

    require_once 'middleware/logged_in_middleware.php';

    require_once 'navigation_bar.php';

    $forumsQuery = "SELECT * FROM forums ORDER BY created_at DESC";
    $forumsResult = $conn->query($forumsQuery);

    $conn->close();
?>

<link rel="stylesheet" href="public/css/bootstrap.min.css">

<div class="container p-3">
    <div class="text-right">
        <a href="add_forum.php">
            <button class="btn btn-success">
                + Add
            </button>
        </a>
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
                    <td>No Forum</td>
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
</div>