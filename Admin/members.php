<?php
    require_once 'helpers/db_connect.php';
    session_start();

    require_once 'middleware/logged_in_middleware.php';

    require_once 'navigation_bar.php';

    if(isset($_SESSION['user_id'])){
        $usersQuery = "SELECT users.id, users.name, users.email, admins.user_id FROM users LEFT JOIN admins ON users.id=admins.user_id WHERE users.id not in(${_SESSION['user_id']})";
    } else {
        $usersQuery = "SELECT users.id, users.name, users.email, admins.user_id FROM users LEFT JOIN admins ON users.id=admins.user_id";
    }
    $userRows = $conn->query($usersQuery);

    $conn->close();
?>

<link rel="stylesheet" href="public/css/bootstrap.min.css">

<div class="container p-3">
    <table class="table table-hover mt-2">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
            if($userRows->num_rows === 0) {
        ?>
            <tr>
                <td colspan="4">No Users Yet</td>
            </tr>
        <?php
            } else {
                while($userRow = $userRows->fetch_assoc()) {
        ?>
            <tr>
                <td scope="row"><?= $userRow['id'];?></td>
                <td><?= $userRow['name'];?></td>
                <td><?= $userRow['email'];?></td>
                <td>
                    <a href="delete_member.php?id=<?= $userRow['id'];?>"><button class="btn btn-danger">Delete</button></a>
                    <?php
                        if(is_null($userRow['user_id'])) {
                    ?>
                    <a href="insert_admin.php?id=<?= $userRow['id'];?>"><button class="btn btn-primary">Admin</button></a>
                    <?php
                        } else {
                    ?>
                    <a href="delete_admin.php?id=<?= $userRow['id'];?>"><button class="btn btn-primary">Member</button></a>
                    <?php
                        }
                    ?>
                </td>
            </tr>
        <?php
                }
            }
        ?>
        </tbody>
    </table>
</div>