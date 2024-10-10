<?php


if ($action == "add") {
    if (!empty($_POST)) {
        $errors = [];
        if (empty($_POST['category'])) {
            $errors['category'] = "a category must be provided";
        } else if (!preg_match('/^[A-Za-z0-9 \-\_\&]+$/', $_POST['category'])) {
            $errors['category'] = "A category not priveded correctly";
        }

        $slug = str_to_url($_POST['category']);
        $query = "select id from categories where slug = :slug limit 1";
        $slug_query = query($query, ['slug' => $slug]);

        if ($slug_query) {
            $slug .= rand(1000, 9999);
        }



        if (empty($errors)) {

            $data = [];
            $data['category']   = $_POST['category'];
            $data['disabled']   = $_POST['disabled'];
            $data['slug']      = $slug;

            $query = "insert into categories(category, slug,disabled) values (:category, :slug, :disabled)";

            query($query, $data);
            redirect('/admin/categories');
        }
    }
} else if ($action == "edit") {
    $query = 'select * from categories where id = :id';
    $row = query_row($query, ['id' => $id]);
    if (!empty($_POST)) {
        $errors = [];
        if (empty($_POST['category'])) {
            $errors['category'] = "a category must be provided";
        } else if (!preg_match('/^[A-Za-z0-9 \-\_\&]+$/', $_POST['category'])) {
            $errors['category'] = "provide a correct category";
        }

        if (empty($errors)) {
            $data = [];
            $data['category']   = $_POST['category'];
            $data['disabled']   = $_POST['disabled'];
            $data['id']         = $id;

            $query = "update categories set category = :category,disabled = :disabled where id = :id limit 1";

            query($query, $data);
            redirect('/admin/categories');
        }
    }
} else if ($action == 'delete') {
    $query = 'select * from categories where id = :id';
    $row = query_row($query, ['id' => $id]);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($row) {
            $data = [];
            $data['id'] = $id;
            $query = 'delete from categories where id = :id limit 1';
            query($query, $data);

            redirect('/admin/categories');
        }
    }
}
