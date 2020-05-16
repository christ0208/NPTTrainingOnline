<?php
    require_once 'helpers/db_connect.php';
    session_start();

    require_once 'middleware/logged_in_middleware.php';

    require_once 'navigation_bar.php';

    if(isset($_POST['add'])) {
        $thread = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'upload_file' => $_FILES['upload_file']
        ];

        if($thread['title'] === '') {
            $_SESSION['error-message'] = 'Title must be filled';
        } else if($thread['description'] === '') {
            $_SESSION['error-message'] = 'Description must be filled';
        } else {
            if(is_uploaded_file($thread['upload_file']['tmp_name'])){
                $tempFileName = basename($thread['upload_file']['name']);
                $extension = strtolower(substr($tempFileName, strrpos($tempFileName, ".")));
                $newFileName = bin2hex(random_bytes(32)) . $extension;
                $targetDir = "uploads/" . $newFileName;

                if(move_uploaded_file($thread['upload_file']['tmp_name'], $targetDir)) {
                    $insertThreadQuery = "INSERT INTO threads(forum_id, user_id, title, detail, upload_file_path) VALUES (${_GET['id']}, ${_SESSION['user_id']}, '${thread['title']}', '${thread['description']}', '$targetDir')";
                    $insertThreadResult = $conn->query($insertThreadQuery);

                    if($insertThreadResult) {
                        $conn->close();
                        header("Location: detail_forum.php?id=${_GET['id']}");
                    } else {
                        $_SESSION['error-message'] = 'Internal Server Error';
                    }
                } else {
                    $_SESSION['error-message'] = 'Cannot Upload file';
                }
            } else {
                $insertThreadQuery = "INSERT INTO threads(forum_id, user_id, title, detail, upload_file_path) VALUES (${_GET['id']}, ${_SESSION['user_id']}, '${thread['title']}', '${thread['description']}', '')";
                $insertThreadResult = $conn->query($insertThreadQuery);

                if($insertThreadResult) {
                    $conn->close();
                    header("Location: detail_forum.php?id=${_GET['id']}");
                } else {
                    $_SESSION['error-message'] = 'Internal Server Error';
                }
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
            <label for="txtTitle">Title</label>
            <input type="text" name="title" id="txtTitle" class="form-control">
        </div>
        <div class="form-group">
            <label for="txtDescription">Description</label>
            <textarea name="description" id="txtDescription" rows="5" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="">Upload File</label>
            <input type="file" name="upload_file" id="fileUpload" class="form-control">
        </div>
        <div class="invalid-feedback d-block">
            <?php
                if(isset($_SESSION['error-message']) && $_SESSION['error-message'] !== '')
                    echo $_SESSION['error-message'];
            ?>
        </div>
        <button class="btn btn-primary" type="submit" name="add">
            Add Thread
        </button>
    </form>
</div>
