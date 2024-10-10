<?php


function query(string $query, array $data = [])
{
    $string = "mysql:hostname=" . DB_HOST . ";dbname=" . DB_NAME;
    $con = new PDO($string, DB_USER, DB_PASSWORD);

    $stm = $con->prepare($query);
    $stm->execute($data);
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

    if (is_array($result) && !empty($result)) {
        return $result;
    }
    return false;
}
function query_row(string $query, array $data = [])
{
    $string = "mysql:hostname=" . DB_HOST . ";dbname=" . DB_NAME;
    $con = new PDO($string, DB_USER, DB_PASSWORD);

    $stm = $con->prepare($query);
    $stm->execute($data);
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

    if (is_array($result) && !empty($result)) {
        return $result[0];
    }
    return false;
}
// redirect

function redirect($page)
{
    header("Location:" . ROOT . "/" . $page);
    die;
}
function old_value($key, $default = "")
{
    if (!empty($_POST[$key])) {
        return $_POST[$key];
    }
    return $default;
}
function old_checked($key, $default = "")
{
    if (!empty($_POST[$key])) {
        return "checked";
    }
    return "";
}
function old_selected($key, $value, $default = "")
{
    if (!empty($_POST[$key]) && $_POST[$key] == $value) {
        return "selected";
    }
    if ($default == $value) {
        return "selected";
    }
    return "";
}
function authenticate($row)
{
    $_SESSION["USER"] = $row;
}
function loggedIn()
{
    if (!empty($_SESSION["USER"])) {
        return true;
    }
    return false;
}
function user($key = '')
{
    if (empty($key)) {
        return $_SESSION["USER"];
    }
    if (!empty($_SESSION["USER"][$key]))
        return $_SESSION["USER"][$key];

    return "";
}

function esc($str)
{
    return htmlspecialchars($str ?? "");
}

function get_image($file)
{
    $file = $file ?? "";
    if (file_exists($file)) {
        return ROOT  . '/' . $file;
    }
    return ROOT . "/assets/images/no-image.jpg";
}


function str_to_url($url)
{
    $url = str_replace("'", "", $url);
    $url = preg_replace('~[^\\pL0-9_]+~u', "-", $url);
    $url = trim($url, "-");
    $url = iconv('utf-8', 'us-ascii//TRANSLIT', $url);
    $url = strtolower($url);
    $url = preg_replace('~[^-a-z0-9_]+~', '', $url);

    return $url;
}
function get_pagination()
{
    $page_number = $_GET['page'] ?? 1;
    $page_number = empty($page_number) ? 1 : (int)$page_number;
    $page_number = $page_number < 1 ? 1 : $page_number;

    $current_link = $_GET['url'] ?? "Home";
    $current_link = ROOT . "/" . $current_link;
    $query_str = "";

    foreach ($_GET as $key => $val) {
        if ($key != 'url') {
            $query_str .= "&" . $key . "=" . $val;
        }
    }
    if (!strstr($query_str, "page=")) {
        $query_str .= "&page=" . $page_number;
    }
    $query_str = trim($query_str, "&");
    $current_link .= "?" . $query_str;

    $current_link = preg_replace("/page=.*/", "page=" . $page_number, $current_link);
    $next_link = preg_replace("/page=.*/", "page=" . ($page_number + 1), $current_link);
    $first_link = preg_replace("/page=.*/", "page=1", $current_link);
    $prev_page_number = $page_number < 2 ?  1 : $page_number - 1;
    $prev_link = preg_replace("/page=.*/", "page=" . $prev_page_number, $current_link);


    $result =  [
        "current_link" => $current_link,
        "next_link" => $next_link,
        "first_link" => $first_link,
        "prev_link" => $prev_link,
        "page_number" => $page_number,
    ];
    return $result;
}


function resize_image($filename, $max_size = 1000)
{

    if (file_exists($filename)) {
        $type = mime_content_type($filename);

        switch ($type) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($filename);
                break;
            case 'image/png':
                $image = imagecreatefrompng($filename);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($filename);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($filename);
                break;

            default:
                return;
                break;
        }
    }
    $src_width = imagesx($image);
    $src_height = imagesy($image);
    if ($src_width > $src_height) {
        if ($src_width < $max_size) {
            $max_size = $src_width;
        }
        $dest_width = $max_size;
        $dest_height = ($src_height / $src_width) * $max_size;
    } else {
        if ($src_height < $max_size) {
            $max_size = $src_height;
        }
        $dest_height = $max_size;
        $dest_width = ($src_width / $src_height) * $max_size;
    }
    $dest_height = round($dest_height);
    $dest_width = round($dest_width);
    $resized_image = imagecreatetruecolor($dest_width, $dest_height);
    imagecopyresampled($resized_image, $image, 0, 0, 0, 0, $dest_width, $dest_height, $src_width, $src_height);

    switch ($type) {
        case 'image/jpeg':
            imagejpeg($resized_image, $filename, 90);
            break;
        case 'image/png':
            imagepng($resized_image, $filename, 90);
            break;
        case 'image/gif':
            imagegif($resized_image, $filename, 90);
            break;
        case 'image/webp':
            imagewebp($resized_image, $filename, 90);
            break;
    }
}




function extract_img_from_content($content, $folder = "uploads/")
{
    preg_match_all("/<img[^>]+/", $content, $matches);

    if (is_array($matches[0]) && count($matches[0]) > 0) {

        foreach ($matches[0] as $img) {

            if (!strstr($img, "data:")) {
                continue;
            }

            preg_match('/src="[^"]+/', $img, $match);
            $parts = explode("base64,", $match[0]);
            preg_match('/data-filename="[^"]+/', $img, $file_match);

            $filename = $folder . str_replace('data-filename="', "", $file_match[0]);
            file_put_contents($filename, base64_decode($parts[1]));
            $content = str_replace($match[0], 'src="' . $filename, $content);
        }
    }

    return $content;
}
function add_root_to_images($content)
{
    preg_match_all("/<img[^>]+/", $content, $matches);

    if (is_array($matches[0]) && count($matches[0]) > 0) {

        foreach ($matches[0] as $img) {
            preg_match('/src="[^"]+/', $img, $match);
            $new_img = str_replace('src="', 'src="' . ROOT . "/", $img);
            $content = str_replace($img, $new_img, $content);
        }
    }

    return $content;
}
function remove_root_fro_content($content)
{
    $content = str_replace(ROOT, "", $content);
    return $content;
}
// create_table();
function create_table()
{
    $string = "mysql:hostname=localhost;";
    $con = new PDO($string, DB_USER, DB_PASSWORD);

    $query = "create database if not exists " . DB_NAME;
    $stm = $con->prepare($query);
    $stm->execute();
    $query = "use " . DB_NAME;
    $stm = $con->prepare($query);
    $stm->execute();

    $query = "create table if not exists users(
        id int primary key auto_increment,
        username varchar(50) not null,
        email varchar(200) not null,
        password varchar(255) not null,
        image varchar(1024) null,
        date datetime default current_timestamp,
        role varchar(50) not null,

        key username (username),
        key email (email)
    )";
    $stm = $con->prepare($query);
    $stm->execute();

    $query = "create table if not exists categories(
        id int primary key auto_increment,
        category varchar(50) not null,
        slug varchar(200) not null,
        disabled tinyint default 0, 

        key category (category),
        key slug (slug)
    )";
    $stm = $con->prepare($query);
    $stm->execute();

    $query = "create table if not exists posts(
        id int primary key auto_increment,
        user_id int  ,
        category_id int ,
        title varchar(200) not null,
        content text null,
        image varchar(1024) null,
        slug varchar(200) not null,
        date datetime default current_timestamp,


        key user_id (user_id),
        key category_id (category_id),
        key title (title),
        key date (date),
        key slug (slug)

    )";
    $stm = $con->prepare($query);
    $stm->execute();
}
