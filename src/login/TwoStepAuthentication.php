<?php
require_once "../../lib/base32/src/Base32.php";
require_once "../../lib/google-authenticator/src/Johnstyle/GoogleAuthenticator/GoogleAuthenticator.php";
require_once "../../lib/google-authenticator/src/Johnstyle/GoogleAuthenticator/GoogleAuthenticatorException.php";

include_once "../../config/Config.php";
include_once "../../config/Database.php";

use Johnstyle\GoogleAuthenticator\GoogleAuthenticator;

function twoStepAuthenticationAction()
{
    session_start();

    if(isset($_POST["2fa_code"])) {
        $code = $_POST["2fa_code"];
        $gAuth = new GoogleAuthenticator($_SESSION["2fa_secret"]);

        if($gAuth->verifyCode($code)) {
            try {
                $config = config();
                $_SESSION["2fa_true"] = true;
                $_SESSION["loggedin"] = true;

                setcookie("2fa_set", $_SESSION["username"], time() + (86400 * 30), "/");

                header("Location: " . $config["home"]);
                die();
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
                die();
            }
        } else {
            $_SESSION["twofafailed"] = "De ingevoerde code is onjuist";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            die();
        }
    } else {
        $_SESSION["twofafailed"] = "U heeft geen code ingevuld";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        die();
    }
}

function registerTwoStepAuthenticationAction()
{
    session_start();

    if(isset($_POST["2fa_code"])) {
        $code = $_POST["2fa_code"];
        $gAuth = new GoogleAuthenticator($_SESSION["2fa_secret"]);

        if($gAuth->verifyCode($code)) {
            try {
                $config = config();

                $conn = getDbConnection();
                $stmt = $conn->prepare("UPDATE user SET 2fa_enabled = 1, 2fa_secret = ? WHERE username = ?");
                $stmt->execute(array($_SESSION["2fa_secret"], $_SESSION["username"]));

                $_SESSION["2fa_true"] = true;
                $_SESSION["loggedin"] = true;

                setcookie("2fa_set", $_SESSION["username"], time() + (86400 * 30), "/");

                header("Location: " . $config["home"]);
                die();
            } catch(PDOException $e) {
                echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div><br><a href='" . $_SERVER['HTTP_REFERER'] . "'>terug naar twe-staps-verificatie pagina</a>";
                die();
            }
        } else {
            $_SESSION["twofaregisterfailed"] = "De ingevoerde code is onjuist";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            die();
        }
    } else {
        $_SESSION["twofaregisterfailed"] = "U heeft geen code ingevuld";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        die();
    }
}

if(isset($_POST['submit'])) {
    twoStepAuthenticationAction();
} elseif(isset($_POST['register'])) {
    registerTwoStepAuthenticationAction();
}
die();