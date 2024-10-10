<?php

if ($action == "add") {
    if (!empty($_POST)) {
        $errors = [];
        if (empty($_POST['title'])) {
            $errors['title'] = "a title must be provided";
        }

        $slug = str_to_url($_POST['title']);
        $query = "select id from posts where slug = :slug limit 1";
        $slug_query = query($query, ['slug' => $slug]);

        if ($slug_query) {
            $slug .= rand(1000, 9999);
        }

        if (empty($_POST['content'])) {
            $errors['content'] = "Content must be provided";
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
        } else {
            $errors['image'] = "Image file is not uploaded";
        }

        if (empty($errors)) {
            $new_content = extract_img_from_content($_POST['content']);
            $data = [];
            $data['title']   = $_POST['title'];
            $data['content']      =  $new_content;
            $data['category_id']       = $_POST['category_id'];
            $data['user_id']       = user('id');
            $data['slug']       = $slug;


            $query = "insert into posts(title, content, category_id,user_id, slug) values (:title, :content, :category_id,:user_id :slug)";
            if (!empty($destination)) {
                $data['image'] = $destination;
                $query = "insert into posts(title, content, category_id,user_id, slug,image) values (:title, :content, :category_id,:user_id, :slug, :image)";
            }
            query($query, $data);
            redirect('/admin/posts');
        }
    }
} else if ($action == "edit") {
    $query = 'select * from posts where id = :id limit 1';
    $row = query_row($query, ['id' => $id]);

    if (!empty($_POST)) {
        $errors = [];
        if (empty($_POST['title'])) {
            $errors['title'] = "a title must be provided";
        }


        if (empty($_POST['content'])) {
            $errors['content'] = "Content must be provided";
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
            $new_content = extract_img_from_content($_POST['content']);
            $new_content = remove_root_fro_content($new_content);
            $data = [];
            $data['title']   = $_POST['title'];
            $data['content'] = $new_content;
            $data['id']      = $id;
            $image_str = "";

            if (!empty($destination)) {
                $image_str = 'image = :image,';
                $data['image'] = $destination;
            }
            $query = "update posts set title = :title,$image_str content = :content where id = :id ";

            query($query, $data);
            redirect('/admin/posts');
        }
    }
} else if ($action == 'delete') {
    $query = 'select * from posts where id = :id';
    $row = query_row($query, ['id' => $id]);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($row) {
            $data = [];
            $data['id'] = $id;
            $query = 'delete from posts where id = :id limit 1';
            query($query, $data);
            if (file_exists($row['image']))
                unlink($row['image']);

            redirect('/admin/posts');
        }
    }
}
