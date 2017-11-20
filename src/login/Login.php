<?php
/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 20-11-2017
 * Time: 10:45
 */

include_once "../../config/Config.php";
include_once "../../config/Database.php";

function loginAction()
{
    if(!isset($_POST["email"]) && !isset($_POST["password"])) {
        header('Location: ' . $_POST["redirect"]);
        die();
    } else {
        $config = config();

        $username = $_POST["username"];
        $password = $_POST["password"];

        $con = getDbConnection();

        $sql = "SELECT username FROM user WHERE username = '" . $username . "' AND password = '" . $password . "'";

        if (mysqli_query($con, $sql)) {
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
            header("Location: " . $config["home"]);
            die();
        } else {
            $_SESSION["loginfailed"] = "U heeft uw gebruikersnaam en/of wachtwoord fout ingevoerd";
            header("Location: " . $_POST["redirect"]);
            die();
        }
    }
}

if(isset($_POST['submit']))
{
    loginAction();
}
