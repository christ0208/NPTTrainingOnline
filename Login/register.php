<?php
    require_once 'helpers/db_connect.php';
    session_start();

    if(isset($_POST['register'])) {
        $credential = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];

        if($credential['name'] === '') {
            $_SESSION['error-message'] = "Fill the Name!";
        } else if($credential['email'] === '') {
            $_SESSION['error-message'] = "Fill the email!";
        } else if($credential['password'] === '') {
            $_SESSION['error-message'] = "Fill the password!";
        } else {
            $query = "INSERT INTO users(name, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sss", $credential['name'], $credential['email'], $credential['password']);

            if($stmt->execute()) {
                header("Location: index.php?url=${_GET['url']}");
            } else {
                $_SESSION['error-message'] = "Something's wrong. Please contact administrator.";
            }
        }
    } else {
        $_SESSION['error-message'] = '';
    }

    $conn->close();
?>

<link rel="stylesheet" href="public/css/bootstrap.min.css">
<link rel="stylesheet" href="public/css/index-mainstyles.css">

<form action="" class="container w-25 p-3 position-absolute center-screen circular-border" method="post">
    <div class="form-group">
        <label for="txtName">Name</label>
        <input type="text" class="form-control" id="txtName" placeholder="Enter full name" name="name">
    </div>
    <div class="form-group">
        <label for="txtEmail">Email address</label>
        <input type="email" class="form-control" id="txtEmail" placeholder="Enter email" name="email">
    </div>
    <div class="form-group">
        <label for="txtPassword">Password</label>
        <input type="password" class="form-control" id="txtPassword" placeholder="Enter password" name="password">
    </div>
    <div class="invalid-feedback d-block">
        <?php
        if(isset($_SESSION['error-message']) && $_SESSION['error-message'] !== '')
            echo $_SESSION['error-message'];
        ?>
    </div>
    <button class="btn btn-primary" name="register" type="submit">
        Register
    </button>
</form>