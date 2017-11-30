<?php
/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 30-11-2017
 * Time: 11:07
 */

include_once "../../config/Database.php";

function forgotPasswordAction()
{
    session_start();

    try {
        $conn = getDbConnection();

        $stmt = $conn->prepare("SELECT username FROM user WHERE username = ?");
        $stmt->execute(array($_POST["email"]));
        $result = $stmt->fetch();

        if($result["username"] == $_POST["email"]) {
            $to = $result["username"];
            $subject = "Wachtwoord veranderen aanvraag";
            $txt = "Er is een wachtwoord veranderen aanvraag gedaan voor het account:\n" .
                    $result["username"] ."\n
                    Klik op de link hieronder om uw wachtwoord de veranderen:\n
                    http://localhost/windesheim/KBS-groep-2/views/login/forgot-password-reset.php";
            $headers = "From: webmaster@example.com" . "\r\n";

            print_r(mail($to,$subject,$txt,$headers));
            die();
        }

        $_SESSION["mailsend"] = "Er is een mail verstuurd naar dit emailadres: " . $_POST["email"];
        header("Location: " . $_SERVER['HTTP_REFERER']);
        die();
    } catch(PDOException $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

if(isset($_POST['email'])) {
    forgotPasswordAction();
}

die();