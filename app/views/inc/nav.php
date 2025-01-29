<nav class="navbar navbar-expand-lg bg-white shadow">
    <div class="container">
        <a class="navbar-brand" href="#">POS system</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">category</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php if (getUserSession()): ?>
                            <?= getUserSession()->name; ?>
                        <?php else: ?>
                            Member
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if (getUserSession()): ?>
                            <li><a class="dropdown-item" href="/logout">Logout</a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="#">Register</a></li>
                            <li><a class="dropdown-item" href="/login">Login</a></li>
                        <?php endif; ?>
                    </ul>
                </li>

            </ul>

        </div>
    </div>
</nav>