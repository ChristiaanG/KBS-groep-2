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
    session_start();

    $config = config();

    if((!isset($_POST["username"]) || empty($_POST["username"])) && (!isset($_POST["password"]) || empty($_POST["password"]))) {
        $_SESSION["loginfailed"] = "Vul een gebruikersnaam en wachtwoord in";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    } elseif(!isset($_POST["username"]) || empty($_POST["username"])) {
        $_SESSION["loginfailed"] = "U heeft geen gebruikersnaam ingevuld";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    } elseif(!isset($_POST["password"]) || empty($_POST["password"])) {
        $_SESSION["loginfailed"] = "U heeft geen wachtwoord ingevuld";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    } else {
        try {
            $username = $_POST["username"];
            $password = $_POST["password"];
            $conn = getDbConnection();

            $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
            $stmt->execute(array($username));
            $result = $stmt->fetch();

            $passwordTrue = password_verify($password, $result["password"]);

            if ($passwordTrue && $result["approved"] == true) {
                $conn = null;

                if(!isset($_COOKIE["2fa_set"]) || $_COOKIE["2fa_set"] != $username || $result["2fa_enabled"] == false) {
                    if(($result["function"] == "admin" || $result["function"] == "medewerker") && $result["2fa_enabled"] == false) {
                        $_SESSION["username"] = $username;
                        $_SESSION["function"] = $result["function"];
                        $_SESSION["2fa_redirect"] = true;
                        header("Location: " . $config["2fa_re"]);
                        die();
                    } elseif($result["function"] == "admin" || $result["function"] == "medewerker" && $result["2fa_enabled"] == true && !isset($_SESSION["2fa_true"])) {
                        $_SESSION["username"] = $username;
                        $_SESSION["function"] = $result["function"];
                        $_SESSION["2fa_secret"] = $result["2fa_secret"];
                        $_SESSION["2fa_redirect"] = true;
                        header("Location: " . $config["2fa"]);
                        die();
                    }
                } else {
                    $_SESSION["loggedin"] = true;
                    $_SESSION["function"] = $result["function"];
                    $_SESSION["username"] = $username;
                    header("Location: " . $config["home"]);
                    die();
                }
            } elseif($result["approved"] == false) {
                $_SESSION["loginfailed"] = "Uw account is nog niet geactiveerd door de administrator";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                die();
            } else {
                $conn = null;
                $_SESSION["loginfailed"] = "U heeft uw gebruikersnaam en/of wachtwoord fout ingevoerd";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                die();
            }
        } catch(PDOException $e) {
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div><br><a href='" . $config["login"] . "'>terug naar loginpagina</a>";
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

if(isset($_POST['submit'])) {
    loginAction();
} elseif($_GET["logout"] = true) {
    logoutAction();
}
die();