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

    //Check if the new password and repeated password has been filled in and if they match each other
    if ((!isset($_POST["password"])) || empty($_POST["password"])) {
        $_SESSION["resetPasswordFailed"] = "Er is geen wachtwoord ingevuld";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    } elseif(!isset($_POST["passwordRepeat"]) || empty($_POST["passwordRepeat"])) {
        $_SESSION["resetPasswordFailed"] = "Het ingevulde wachtwoord moet twee keer ingevuld worden";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    } elseif($_POST["password"] != $_POST["passwordRepeat"]) {
        $_SESSION["resetPasswordFailed"] = "De ingevoerde wachtwoorden zijn niet identiek";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }

    //Validate if the new password meets the minimum required conditions
    $validPassword = preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$/", $_POST["password"]);

    if($validPassword == false) {
        $_SESSION["resetPasswordFailed"] = "Uw wachtwoord voldoet niet aan de minimale eisen";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    } else {
        try {
            include_once "../../config/Config.php";

            $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
            $conn = getDbConnection();

            //Set new password and remove password reset token
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