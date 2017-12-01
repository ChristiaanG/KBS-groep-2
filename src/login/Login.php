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
    if(!isset($_GET["email"]) && !isset($_GET["password"])) {
        header('Location: ' . $_GET["redirect"]);
        die();
    } else {
        try {
            $username = $_GET["username"];
            $password = $_GET["password"];
            $conn = getDbConnection();

            $stmt = $conn->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
            $stmt->execute(array($username, $password));
            $result = $stmt->fetch();

            session_start();

            $config = config();

            if ($result["username"] == $username && $result["approved"] == true) {
                $conn = null;

                if($result["function"] == "admin" || $result["function"] == "medewerker" && $result["2fa_enabled"] == false) {
                    header("Location: " . $config["2fa"]);
                    die();
                }

                $_GET["loggedin"] = true;
                $_GET["username"] = $username;
                header("Location: " . $config["home"]);
                die();
            } elseif($result["approved"] == false) {
                $conn = null;
                $_GET["loginfailed"] = "Uw account is nog niet geactiveerd door de administrator";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                die();
            } else {
                $conn = null;
                $_GET["loginfailed"] = "U heeft uw gebruikersnaam en/of wachtwoord fout ingevoerd";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                die();
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            die();
        }
    }
}

function logoutAction()
{
    session_start();
    session_unset();
    session_destroy();

    $config = config();

    header("Location: " . $config["login"]);
    die();
}

if(isset($_GET['submit'])) {
    loginAction();
} elseif($_GET["logout"] = true) {
    logoutAction();
}
