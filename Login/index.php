<?php
    require_once 'helpers/db_connect.php';
    session_start();

    $startPortLocation = strpos($_SERVER['HTTP_HOST'], ":");
    if($startPortLocation !== false)
        $host = substr($_SERVER['HTTP_HOST'], 0, $startPortLocation);
    else
        $host = $_SERVER['HTTP_HOST'];

    if(isset($_POST['login'])) {
        $credential = [
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];

        $query = "SELECT * FROM users WHERE email='${credential['email']}' AND password='${credential['password']}';";
        $rows = $conn->query($query);

        if($conn->error){
            $_SESSION['error-message'] = 'Error when try to login';
        } else if($rows->num_rows) {
            $currentRow = $rows->fetch_assoc();

            if(isset($_GET['url']) && strpos($_GET['url'], "http://$host:47021") !== false) {
                $adminQuery = "SELECT * FROM admins WHERE user_id=${currentRow['id']}";
                $adminRows = $conn->query($adminQuery);

                if($adminRows->num_rows) {
                    $_SESSION['error-message'] = '';
                    $_SESSION['user_id'] = $currentRow['id'];
                    $_SESSION['name'] = $currentRow['name'];
                    header("Location: ${_GET['url']}");
                } else {
                    $_SESSION['error-message'] = 'Unauthorized access';
                }
            } else {
                $_SESSION['error-message'] = '';
                $_SESSION['user_id'] = $currentRow['id'];
                $_SESSION['name'] = $currentRow['name'];
                header("Location: ${_GET['url']}");
            }
        } else {
            $_SESSION['error-message'] = "Wrong username or password combination";
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
    <button class="btn btn-primary" name="login" type="submit">
        Login
    </button>
    <div class="form-group">
        <?php
        if(isset($_GET['url']) && strpos($_GET['url'], "http://$host") !== false) {
            ?>
            Not Registered as Member? <a href="register.php?url=<?= $_GET['url'];?>">Click Here</a>
            <?php
        }
        ?>
    </div>
</form>