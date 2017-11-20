<?php
/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 20-11-2017
 * Time: 11:30
 */

function config()
{
    return array(
        "host" => "localhost",
        "username" => "root",
        "password" => "",
        "dbname" => "kbs",
        "home" => __DIR__ . "../views/dashboard/index.php",
        "login" => __DIR__ . "../views/login/index.php",

    );
}