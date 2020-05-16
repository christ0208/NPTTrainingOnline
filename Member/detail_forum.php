<?php
    require_once 'helpers/db_connect.php';
    session_start();

    require_once 'middleware/logged_in_middleware.php';

    require_once 'navigation_bar.php';

    $detailForumQuery = "SELECT threads.title as thread_title, threads.detail as thread_detail, threads.upload_file_path as file_path, users.name as user_name FROM threads JOIN users ON users.id = threads.user_id WHERE forum_id=${_GET['id']}";
    $detailForumResult = $conn->query($detailForumQuery);

    $conn->close();
?>

<link rel="stylesheet" href="public/css/bootstrap.min.css">

<div class="container p-3">
    <div class="text-right">
        <a href="add_thread.php?id=<?= $_GET['id'];?>">
            <button class="btn btn-success">
                Add Thread
            </button>
        </a>
    </div>
    <?php
        while($currentDetailForum = $detailForumResult->fetch_assoc()) {
            ?>
            <div class="mt-2">
                <div class="bg-dark text-white p-2">
                    <?= $currentDetailForum['thread_title'];?>
                </div>
                <div class="bg-light p-2">
                    <?= $currentDetailForum['thread_detail'];?>
                </div>
                <?php
                    if($currentDetailForum['file_path'] !== '') {
                        ?>
                        <div class="bg-light p-2">
                            <a href="<?= $currentDetailForum['file_path'];?>"><?= str_replace("uploads/", "", $currentDetailForum['file_path']);?></a>
                        </div>
                        <?php
                    }
                ?>
                <div class="bg-light p-2">
                    Created By:
                    <?= $currentDetailForum['user_name'];?>
                </div>
            </div>
            <?php
        }
    ?>
</div>
