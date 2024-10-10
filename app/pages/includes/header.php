<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Home - <?= APP_NAME ?></title>
    <link href="<?= ROOT ?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="<?= ROOT ?>/assets/css/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= ROOT ?>/assets/css/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="<?= ROOT ?>/assets/js/ism-2.2.min.js"></script>

    <link href="<?= ROOT ?>/assets/css/headers.css" rel="stylesheet">
    <link href="<?= ROOT ?>/assets/css/slider.css" rel="stylesheet">
</head>

<body>
    <header class="p-3 border-bottom">
        <div class="container ">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="<?= ROOT ?>/home" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">

                    <img class="bi me-2" src="<?= ROOT ?>/assets/images/logo.svg" width="70" height="32" alt="">
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="<?= ROOT ?>/home" class="nav-link px-2  <?= $url[0] == "home" ? "active" : "link-secondary" ?>">Home</a></li>
                    <li><a href="<?= ROOT ?>/blog" class="nav-link px-2  <?= $url[0] == "blog" ? "active" : "link-dark " ?>">Blog</a></li>
                    <li><a href="<?= ROOT ?>/contact" class="nav-link px-2 <?= $url[0] == "contact" ? "active" : "link-dark " ?>">Conatct</a></li>
                    <li>
                        <span class="dropdown nav-link px-2 link-dark">
                            <a href="#" class="d-block d-flex align-items-center  link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Category
                            </a>
                            <ul class="dropdown-menu text-small">
                                <?php
                                $query = 'select * from categories order by id desc';
                                $categoriess = query($query);
                                ?>
                                <?php if (!empty($categoriess)): ?>
                                    <?php foreach ($categoriess as $cat): ?>
                                        <li>
                                            <a class="dropdown-item" href="<?= ROOT ?>/category/<?= $cat['slug'] ?>">
                                                <?= $cat['category'] ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </span>
                    </li>
                </ul>

                <form action="<?= ROOT ?>/search" class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                    <div class="input-group">
                        <input value="<?= $_GET['find'] ?? "" ?>" type="search" name="find" class="form-control" placeholder="Search..." aria-label="Search">
                        <button class="btn btn-primary " type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                <?php if (loggedIn()): ?>
                    <div class="dropdown text-end">
                        <a href="#" class="d-block d-flex align-items-center  link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?= get_image(user('image')) ?? "<?= ROOT ?>/assets/images/user.svg" ?>" alt="mdo" width="32" height="32" class="rounded-circle ">
                        </a>
                        <ul class="dropdown-menu text-small">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="<?= ROOT ?>/admin">Admin</a></li>
                            <li><a class="dropdown-item" href="#">Setting</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= ROOT ?>/logout">Sign out</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <button class="btn btn-outline-secondary  "><a class="text-decoration-none" href="<?= ROOT ?>/login">Sign in</a></button>
                <?php endif; ?>
            </div>
        </div>
    </header>