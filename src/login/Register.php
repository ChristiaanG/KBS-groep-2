<?php
/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 16-11-2017
 * Time: 15:47
 */

include_once "../../config/Config.php";
include_once "../../config/Database.php";

require_once '../../lib/securimage/securimage.php';

function registerAction()
{
    session_start();

    if(!isset($_POST["username"])) {
        $_SESSION["loginfailed"] = "U heeft geen gebruikersnaam ingevuld";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    } elseif(!isset($_POST["password"])) {
        $_SESSION["loginfailed"] = "U heeft geen wachtwoord ingevuld";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    } elseif(!isset($_POST["name"])) {
        $_SESSION["loginfailed"] = "U heeft geen naam ingevuld";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }

    $image = new Securimage();
    if ($image->check($_POST['captcha_code']) == true) {
        try {
            $username = $_POST["username"];
            $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
            $name = $_POST["name"];
            $config = config();

            $conn = getDbConnection();
            $stmt = $conn->prepare("INSERT INTO user (username, password, name) VALUES (?, ?, ?)");
            $result = $stmt->execute(array($username, $password, $name));

            if($result == true) {
                $conn = null;
                header("Location: " . $config["login"]);
                die();
            } else {
                $conn = null;
                $_SESSION["registerfailed"] = "Uw wachtwoord en of gebruikersnaam voldoen niet aan de eisen";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                die();
            }
        } catch(PDOException $e) {
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div><br><a href='" . $_SERVER['HTTP_REFERER'] . "'>terug naar registratiepagina</a>";
        }
    } else {
        $_SESSION["registerfailed"] = "U heeft de code verkeerk ingevuld.";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        die();
    }


}

if(isset($_POST['submit']))
{
    registerAction();
}
die();