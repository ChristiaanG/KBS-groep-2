<?php
/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 5-12-2017
 * Time: 16:14
 */

include_once "../../config/Database.php";

function forgotPasswordResetAction()
{
    session_start();

    if ((!isset($_POST["password"]) || empty($_POST["password"])) || (!isset($_POST["passwordRepeat"]) || empty($_POST["passwordRepeat"]))) {
        $_SESSION["resetPasswordFailed"] = "De ingevoerde wachtwoorden zijn niet identiek";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    } else {
        try {
            include_once "../../config/Config.php";

            $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
            $conn = getDbConnection();

            $stmt = $conn->prepare("UPDATE user SET password = ?, reset_token = NULL WHERE username = ?");
            $stmt->execute(array($password, $_SESSION["usernameResetToken"]));

            $config = config();

            $_SESSION["passwordReset"] = "Uw wachtwoord is aangepast. <a href='" . $config["login"] . "'>Klik hier om naar de inlogpagina te gaan</a>";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            die();
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div><br><a href='" . $_SERVER['HTTP_REFERER'] . "'>terug naar wachtwoord reset pagina</a>";
            die();
        }
    }
}
if(isset($_POST["reset"])) {
    forgotPasswordResetAction();
}
die();