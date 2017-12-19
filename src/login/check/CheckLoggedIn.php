<?php
/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 6-12-2017
 * Time: 10:10
 */

function checkLoggedInAction()
{
    if(isset($_SESSION["loggedin"])) {
        include_once "../../config/Config.php";

        $config = config();

        header("Location: " . $config["home"]);
        die();
    }
}

checkLoggedInAction();