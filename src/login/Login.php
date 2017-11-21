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
        try {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $conn = getDbConnection();

            $stmt = $conn->prepare("SELECT username FROM user WHERE username = ? AND password = ?");
            $stmt->execute(array($username, $password));
            $result = $stmt->fetch();

            session_start();

            if (!empty($result)) {
                $conn = null;
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $username;
                header("Location: " . $_SESSION["home"]);
                die();
            } else {
                $conn = null;
                $_SESSION["loginfailed"] = "U heeft uw gebruikersnaam en/of wachtwoord fout ingevoerd";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                die();
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            die();
        }
    }
}

if(isset($_POST['submit']))
{
    loginAction();
}
