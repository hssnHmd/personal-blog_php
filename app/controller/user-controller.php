<?php


if ($action == "add") {
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

        $allowedFormat = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!empty($_FILES['image']['name'])) {

            $destination = "";
            if (in_array($_FILES['image']['type'], $allowedFormat)) {
                $folder = 'uploads/';
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }
                $destination = $folder . time() . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'],  $destination);
                resize_image($destination);
            } else {
                $errors['image'] = "Image format not allowed";
            }
        }

        if (empty($errors)) {

            $data = [];
            $data['username']   = $_POST['username'];
            $data['email']      = $_POST['email'];
            $data['role']       = $_POST['role'];
            $data['password']   = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $query = "insert into users(username, email, role, password) values (:username, :email, :role, :password)";
            if (!empty($destination)) {
                $data['image'] = $destination;
                $query = "insert into users(username, email, role, password,image) values (:username, :email, :role, :password, :image)";
            }
            query($query, $data);
            redirect('/admin/users');
        }
    }
} else if ($action == "edit") {
    $query = 'select * from users where id = :id';
    $row = query_row($query, ['id' => $id]);
    if (!empty($_POST)) {
        $errors = [];
        if (empty($_POST['username'])) {
            $errors['username'] = "a username must be provided";
        } else if (!preg_match('/^[A-Za-z]+$/', $_POST['username'])) {
            $errors['username'] = "a username can only contain letters, no spaces no numbers";
        }


        $query = "select id from users where email = :email && id != :id limit 1";
        $email = query($query, ['email' => $_POST['email'], 'id' => $id]);

        if (empty($_POST['email'])) {
            $errors['email'] = "Email must be provided";
        } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email Not valide";
        } else if ($email) {
            $errors['email'] = "Email already exists";
        }
        if (empty($_POST['password'])) {
        } else if (strlen($_POST['password']) < 7) {
            $errors['password'] = "Password must be at least 7 characters";
        } else if ($_POST['password'] != $_POST['retype_password']) {
            $errors['password'] = "Password does not match";
        }

        $allowedFormat = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        if (!empty($_FILES['image']['name'])) {

            $destination = "";
            if (in_array($_FILES['image']['type'], $allowedFormat)) {
                $folder = 'uploads/';
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }
                $destination = $folder . time() . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'],  $destination);
                resize_image($destination);
            } else {
                $errors['image'] = "Image format not allowed";
            }
        }

        if (empty($errors)) {

            $data = [];
            $data['username']   = $_POST['username'];
            $data['email']      = $_POST['email'];
            $data['role']       =  $_POST['role'];

            $data['id']         = $id;
            $password_str = "";
            $image_str = "";

            if (!empty($_POST['password'])) {
                $data['password']  = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $password_str = "password = :password,";
            }

            if (!empty($destination)) {
                $image_str = "image = :image,";
                $data['image'] = $destination;
            }
            $query = "update users set username = :username, email = :email,$password_str $image_str  role = :role  where id = :id limit 1 ";


            query($query, $data);
            redirect('/admin/users');
        }
    }
} else if ($action == 'delete') {
    $query = 'select * from users where id = :id';
    $row = query_row($query, ['id' => $id]);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($row) {
            $data = [];
            $data['id'] = $id;
            $query = 'delete from users where id = :id limit 1';
            query($query, $data);
            if (file_exists($row['image']))
                unlink($row['image']);

            redirect('/admin/users');
        }
    }
}
