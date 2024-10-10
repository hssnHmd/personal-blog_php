<?php
if (!empty($_POST)) {
    $errors = [];
    if (empty($_POST['username'])) {
        $errors['username'] = "a username must be provided";
    } else if (!preg_match('/^[A-Za-z]+$/', $_POST['username'])) {
        $errors['username'] = "a username can only contain letters, no spaces no numbers";
    }


    $query = "select id from users where email=:email limit 1";
    $email = query($query, ['email' => $_POST['email']]);

    if (empty($_POST['email'])) {
        $errors['email'] = "Email must be provided";
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email Not valide";
    } else if ($email) {
        $errors['email'] = "Email already exists";
    }

    if (empty($_POST['password'])) {
        $errors['password'] = "Password must be provided";
    } else if (strlen($_POST['password']) < 8) {
        $errors['password'] = "Password must be at least 4 characters";
    } else if ($_POST['password'] != $_POST['retype_password']) {
        $errors['password'] = "Password does not match";
    }
    if (empty($_POST['remember'])) {
        $errors['remember'] = "Select remember term";
    }

    if (empty($errors)) {

        $data = [];
        $data['username']   = $_POST['username'];
        $data['email']      = $_POST['email'];
        $data['role']       = "user";
        $data['password']   = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $query = "Insert into users(username, email, role, password) values (:username, :email, :role, :password)";
        query($query, $data);
        redirect('login');
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
            <a href="<?= ROOT ?>/home">
                <img class="mb-4 p-2 shadow rounded-circle" src="<?= ROOT ?>/assets/images/logo.svg" alt="" width="72" height="57" style="border:1px solid lightgray">
            </a>
            <h1 class="h3 mb-3 fw-normal">Create account</h1>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">Please fix the errors belows</div>
            <?php endif; ?>
            <div class="form-floating mb-2">
                <input value="<?= old_value('username') ?>" name="username" type="text" class="form-control" id="username" placeholder="username">
                <label for="username">User name</label>
            </div>
            <?php if (!empty($errors['username'])): ?>
                <div class="text-danger mb-2"><?= $errors['username'] ?></div>
            <?php endif; ?>
            <div class="form-floating mb-2">
                <input value="<?= old_value('email') ?>" name="email" type="email" class="form-control" id="email" placeholder="name@example.com">
                <label for="email">Email address</label>
            </div>
            <?php if (!empty($errors['email'])): ?>
                <div class="text-danger mb-2"><?= $errors['email'] ?></div>
            <?php endif; ?>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
            <?php if (!empty($errors['password'])): ?>
                <div class="text-danger mb-2"><?= $errors['password'] ?></div>
            <?php endif; ?>
            <div class="form-floating">
                <input type="password" class="form-control" name="retype_password" id="retype_password" placeholder="Password confirmation">
                <label for="retype_password">Conform password</label>
            </div>
            <div class="my-2">Already have an account ? <a href="<?= ROOT ?>/login">Sign In</a></div>

            <div class="checkbox mb-2">
                <label>
                    <input <?= old_checked('remember') ?> name="remember" type="checkbox" value="1"> Accept Term and Condition
                </label>
            </div>
            <?php if (!empty($errors['remember'])): ?>
                <div class="text-danger mb-2"><?= $errors['remember'] ?></div>
            <?php endif; ?>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign Up</button>
            <p class="mt-5 mb-3 text-muted">&copy; <?= date('Y'); ?></p>
        </form>
    </main>



</body>

</html>