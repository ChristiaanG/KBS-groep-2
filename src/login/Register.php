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

    //Check if username has been filled in
    if(!isset($_POST["username"]) || empty($_POST["username"])) {
        $_SESSION["registerfailed"] = "U heeft geen gebruikersnaam ingevuld";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    } else {
        $_SESSION["username"] = $_POST["username"];
    }

    //Check if name has been filled in
    if(!isset($_POST["name"]) || empty($_POST["name"])) {
        $_SESSION["registerfailed"] = "U heeft geen naam ingevuld";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    } else {
        $_SESSION["name"] = $_POST["name"];
    }

    //Check if password and repeated password has been filled in and if they match each other
    if(!isset($_POST["password"]) || empty($_POST["password"])) {
        $_SESSION["registerfailed"] = "U heeft geen wachtwoord ingevuld";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    } elseif(!isset($_POST["passwordRepeat"]) || empty($_POST["passwordRepeat"])) {
        $_SESSION["registerfailed"] = "Het ingevulde wachtwoord moet twee keer ingevuld worden";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    } elseif ($_POST["password"] != $_POST["passwordRepeat"]) {
        $_SESSION["registerfailed"] = "De ingevoerde wachtwoorden zijn niet identiek";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }

    //Validate if the password meets the minimum required conditions
    $validPassword = preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/", $_POST["password"]);

    if($validPassword == false) {
        $_SESSION["registerfailed"] = "Uw wachtwoord voldoet niet aan de minimale eisen";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    } else {
        $image = new Securimage();

        //See if the filled in captcha code is correct
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
}

if(isset($_POST['submit']))
{
    registerAction();
}
die();