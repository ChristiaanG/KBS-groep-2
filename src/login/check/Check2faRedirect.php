<?php
/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 6-12-2017
 * Time: 10:15
 */

function Check2faRedirectAction()
{
    if(!isset($_SESSION["2fa_redirect"])) {
        include_once "../../config/Config.php";

        $config = config();

        header("Location: " . $config["login"]);
        die();
    }
}

Check2faRedirectAction();