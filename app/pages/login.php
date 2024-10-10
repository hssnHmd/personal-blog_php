<?php
if (!empty($_POST)) {

    $errors = "";
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "select * from users where email = :email limit 1";
    $row = query($query, ['email' => $email]);

    if (!empty($row)) {
        if (password_verify($password, $row[0]['password'])) {

            authenticate($row[0]);
            redirect('admin');
        } else {
            $errors = "Email or Password incorrect";
        }
    } else {
        $errors = "Email does not exist";
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="generator" content="Hugo 0.104.2">
    <title><?= APP_NAME ?> -Signin </title>

    <link href="<?= ROOT ?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="<?= ROOT ?>/assets/css/signin.css" rel="stylesheet">
</head>

<body class="text-center">

    <main class="form-signin w-100 m-auto">
        <form method="post">
            <a href="home">
                <img class="mb-4 p-2 shadow rounded-circle" src="<?= ROOT ?>/assets/images/logo.svg" alt="" width="72" height="57" style="border:1px solid lightgray">
            </a>
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger"><?= $errors ?></div>
            <?php endif; ?>
            <div class="form-floating">
                <input type="email" name="email" value="<?= old_value('email'); ?>" class="form-control" id="email" placeholder="name@example.com">
                <label for="email">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                <label for="password">Password</label>
            </div>

            <div class="my-2">Don't have an account ? <a href="<?= ROOT ?>/signup">Sign Up</a></div>
            <div class="checkbox mb-3">
                <label>
                    <input name="remember" type="checkbox" value="1"> Remember me
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">&copy; <?= date('Y'); ?></p>
        </form>
    </main>



</body>

</html>