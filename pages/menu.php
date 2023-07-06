<nav class="navbar navbar-expand-lg bg-custom-color">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <? echo $page == 1 ? 'active' : '' ?>" aria-current="page" href="?page=1">Tours</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <? echo $page == 2 ? 'active' : '' ?>" href="?page=2">Comments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <? echo $page == 3 ? 'active' : '' ?>" href="?page=3">Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <? echo $page == 4 ? 'active' : '' ?>" href="?page=4">Registration</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <? if (!isset($_SESSION['login'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link <? echo $page == 5 ? 'active' : '' ?>" href="?page=5">Log In</a>
                    </li>
                <? } else { ?>
                    <? if (isset($_SESSION['login'])) { ?>
                        <li class="nav-item">
                            <p class='nav-link navbar-text' style='margin-bottom: 0;'>Hello, <? echo $_SESSION['login'] ?></p>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <? echo $page == 5 ? 'active' : '' ?>" href="?page=6">Log Out</a>
                        </li>
                <? }
                } ?>

            </ul>
        </div>
    </div>
</nav>