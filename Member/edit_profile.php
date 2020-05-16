<?php
    require_once 'helpers/db_connect.php';
    session_start();

    require_once 'middleware/logged_in_middleware.php';

    require_once 'navigation_bar.php';

    if(isset($_POST['update'])) {
        $profile = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];

        $updateProfileQuery = "UPDATE users SET name='${profile['name']}', email='${profile['email']}', password='${profile['password']}' WHERE id=${_SESSION['user_id']}";
        $updateProfileResult = $conn->query($updateProfileQuery);

        if($updateProfileResult) {
            $conn->close();
            header('Location: edit_profile.php');
        } else {
            $_SESSION['error-message'] = 'Internal Server Error';
        }
    } else {
        $_SESSION['error-message'] = '';
    }

    $fetchProfileQuery = "SELECT * FROM users WHERE id=${_SESSION['user_id']} limit 1";
    $fetchProfileResult = $conn->query($fetchProfileQuery);

    if($fetchProfileResult->num_rows) {
        $currentProfileResult = $fetchProfileResult->fetch_assoc();
        $profile = [
            'name' => $currentProfileResult['name'],
            'email' => $currentProfileResult['email'],
            'password' => $currentProfileResult['password']
        ];
    }

    $conn->close();
?>

<link rel="stylesheet" href="public/css/bootstrap.min.css">

<div class="container p-3">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="txtName">Name</label>
            <input type="text" name="name" id="txtName" class="form-control" value="<?= $profile['name'];?>">
        </div>
        <div class="form-group">
            <label for="txtEmail">Email</label>
            <input type="email" name="email" id="txtEmail" class="form-control" value="<?= $profile['email'];?>">
        </div>
        <div class="form-group">
            <label for="txtPassword">Password</label>
            <input type="password" name="password" id="txtPassword" class="form-control" value="<?= $profile['password'];?>">
        </div>
        <div class="invalid-feedback">
            <?php
                if(isset($_SESSION['error-message']) && $_SESSION['error-message'] !== '')
                    echo $_SESSION['error-message'];
            ?>
        </div>
        <button class="btn btn-primary" name="update" type="submit">
            Update Profile
        </button>
    </form>
</div>
