<?php
/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 1-12-2017
 * Time: 11:18
 */

function checkNotLoggedInAction()
{
    if(!isset($_SESSION["loggedin"])) {
        include_once "../../config/Config.php";

        $config = config();

        header("Location: " . $config["login"]);
        die();
    }
}

checkNotLoggedInAction();