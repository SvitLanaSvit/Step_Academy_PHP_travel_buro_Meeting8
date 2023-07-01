<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link <? echo $page == 1 ? 'active' : ''?>" aria-current="page" href="?page=1">Tours</a>
                </li>
                <li class="nav-item">
                <a class="nav-link <? echo $page == 2 ? 'active' : ''?>" href="?page=2">Comments</a>
                </li>
                <li class="nav-item">
                <a class="nav-link <? echo $page == 3 ? 'active' : ''?>" href="?page=3">Admin</a>
                </li>
                <li class="nav-item">
                <a class="nav-link <? echo $page == 4 ? 'active' : ''?>" href="?page=4">Registration</a>
                </li>
            </ul>
        </div>
    </div>
</nav>