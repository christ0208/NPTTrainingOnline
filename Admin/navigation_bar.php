<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <span class="navbar-brand">Forum</span>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item <?=(strpos($_SERVER['REQUEST_URI'], 'members.php') !== false) ? "active": "";?>">
                <a class="nav-link" href="members.php">Members</a>
            </li>
            <li class="nav-item <?=(strpos($_SERVER['REQUEST_URI'], 'forums.php') !== false) ? "active": "";?>">
                <a class="nav-link" href="forums.php">Forums</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="sign_out.php">Sign Out</a>
            </li>
        </ul>
    </div>
</nav>