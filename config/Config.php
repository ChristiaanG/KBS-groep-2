<?php

/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 20-11-2017
 * Time: 11:30
 */
function config() {
    return array(
        "home" => (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] . "/views/dashboard/index.php",
        "login" => (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] . "/views/login/index.php",
        "2fa_re" => (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] . "/views/login/register-two-step-authentication.php",
        "2fa" => (isset($_SERVER['HTTPS']) ? "https://" : "htt://p") . $_SERVER["HTTP_HOST"] . "/views/login/two-step-authentication.php",
    );
}
