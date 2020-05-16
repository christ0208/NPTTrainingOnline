<?php
    require_once 'helpers/db_connect.php';
    session_start();

    require_once 'middleware/logged_in_middleware.php';

    require_once 'navigation_bar.php';

    if(isset($_POST['add'])) {
        $newForum = [
            'forum_name' => $_POST['forum_name'],
            'thread_name' => $_POST['thread_name'],
            'thread_description' => $_POST['thread_description'],
            'upload_file' => $_FILES['upload_file']
        ];

        if($newForum['forum_name'] === '') {
            $_SESSION['error-message'] = 'Forum name must be filled';
        } else if ($newForum['thread_name'] === '') {
            $_SESSION['error-message'] = 'Thread name must be filled';
        } else if($newForum['thread_description'] === '') {
            $_SESSION['error-message'] = 'Thread Description must be filled';
        } else {
            $conn->begin_transaction();
            $insertForumQuery = "INSERT INTO forums (user_id, title) VALUES (${_SESSION['user_id']}, '${newForum['forum_name']}')";
            $insertForumResult = $conn->query($insertForumQuery);

            if($insertForumResult) {
                if(is_uploaded_file($newForum['upload_file']['tmp_name'])){
                    $tempFileName = basename($newForum['upload_file']['name']);
                    $extension = strtolower(substr($tempFileName, strrpos($tempFileName, ".")));
                    $newFileName = bin2hex(random_bytes(32)) . $extension;
                    $targetDir = "uploads/" . $newFileName;

                    if(move_uploaded_file($newForum['upload_file']['tmp_name'], $targetDir)) {
                        $insertThreadQuery = "INSERT INTO threads(forum_id, user_id, title, detail, upload_file_path) VALUES ($conn->insert_id, ${_SESSION['user_id']}, '${newForum['thread_name']}', '${newForum['thread_description']}', '$targetDir')";
                        $insertThreadResult = $conn->query($insertThreadQuery);

                        if($insertThreadResult) {
                            $conn->commit();
                            $conn->close();
                            header("Location: index.php");
                        } else {
                            $conn->rollback();
                            $_SESSION['error-message'] = 'Internal Server Error';
                        }
                    } else {
                        $conn->rollback();
                        $_SESSION['error-message'] = 'Cannot Upload file';
                    }
                } else {
                    $insertThreadQuery = "INSERT INTO threads(forum_id, user_id, title, detail, upload_file_path) VALUES ($conn->insert_id, ${_SESSION['user_id']}, '${newForum['thread_name']}', '${newForum['thread_description']}', '')";
                    $insertThreadResult = $conn->query($insertThreadQuery);

                    if($insertThreadResult) {
                        $conn->commit();
                        $conn->close();
                        header("Location: index.php");
                    } else {
                        $conn->rollback();
                        $_SESSION['error-message'] = 'Internal Server Error';
                    }
                }
            } else {
                $conn->rollback();
                $_SESSION['error-message'] = 'Internal Server Error';
            }
        }
    } else {
        $_SESSION['error-message'] = '';
    }

    $conn->close();
?>

<link rel="stylesheet" href="public/css/bootstrap.min.css">

<div class="container p-3">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="txtForumName">Forum Name</label>
            <input type="text" name="forum_name" id="txtForumName" class="form-control">
        </div>
        <div class="form-group">
            <label for="txtThreadTitle">Thread Title</label>
            <input type="text" name="thread_name" id="txtThreadTitle" class="form-control">
        </div>
        <div class="form-group">
            <label for="txtThreadDescription">Thread Description</label>
            <textarea name="thread_description" id="txtThreadDescription" class="form-control" rows="5"></textarea>
        </div>
        <div class="form-group">
            <label for="fileUpload">Upload File</label>
            <input type="file" name="upload_file" id="fileUpload" class="form-control">
        </div>
        <div class="invalid-feedback d-block">
            <?php
                if(isset($_SESSION['error-message']) && $_SESSION['error-message'] !== '')
                    echo $_SESSION['error-message'];
            ?>
        </div>
        <button class="btn btn-primary" name="add" type="submit">
            Add New Forum
        </button>
    </form>
</div>