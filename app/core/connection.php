<?php

if ($_SERVER['SERVER_NAME'] == 'localhost') {
    define("DB_USER", "root");
    define("DB_PASSWORD", "");
    define("DB_NAME", "myblog_db");
    define("DB_HOST", "localhost");
} else {
    define("DB_USER", "root");
    define("DB_PASSWORD", "");
    define("DB_NAME", "myblog_db");
    define("DB_HOST", "http://blog.com");
}
