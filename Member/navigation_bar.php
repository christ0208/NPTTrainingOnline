<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <span class="navbar-brand">Forum</span>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?=(strpos($_SERVER['REQUEST_URI'], 'index.php') !== false || $_SERVER['REQUEST_URI'] === '/') ? "active": "";?>">
                <a class="nav-link" href="index.php">Forums</a>
            </li>
            <li class="nav-item <?=(strpos($_SERVER['REQUEST_URI'], 'search_forum.php') !== false) ? "active": "";?>">
                <a class="nav-link" href="search_forum.php">Search Forum</a>
            </li>
            <li class="nav-item <?=(strpos($_SERVER['REQUEST_URI'], 'edit_profile.php') !== false) ? "active": "";?>">
                <a class="nav-link" href="edit_profile.php">Edit Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="sign_out.php">Sign Out</a>
            </li>
        </ul>
        <span class="navbar-text">
            Hello, <?= $_SESSION['name'];?>
        </span>
    </div>
</nav>