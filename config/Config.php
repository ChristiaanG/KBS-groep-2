<?php
/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 20-11-2017
 * Time: 11:30
 */

function config()
{
    session_start();

    $_SESSION["home"] = "http://localhost/windesheim/KBS-groep-2/views/dashboard/index.php";
    $_SESSION["login"] = "http://localhost/windesheim/KBS-groep-2/views/login/index.php";

    return array(
        "host" => "localhost",
        "username" => "root",
        "password" => "",
        "dbname" => "kbs",
        "port" => 3306,
    );
}