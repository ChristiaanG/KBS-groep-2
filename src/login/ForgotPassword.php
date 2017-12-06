<?php
/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 30-11-2017
 * Time: 11:07
 */

include_once "../../config/Database.php";
include_once "../email/gmail.php";

function forgotPasswordAction()
{
    session_start();

    try {
        $conn = getDbConnection();

        $stmt = $conn->prepare("SELECT username FROM user WHERE username = ?");
        $stmt->execute(array($_POST["email"]));
        $result = $stmt->fetch();

        if($result["username"] == $_POST["email"]) {
            $token = bin2hex(openssl_random_pseudo_bytes(16));

            $stmt = $conn->prepare("UPDATE user SET reset_token = ? WHERE username = ?");
            $stmt->execute(array($token, $result["username"]));
            $conn = null;

            $to = $result["username"];
            $subject = "Wachtwoord veranderen aanvraag";
            $txt = "Er is een wachtwoord veranderen aanvraag gedaan voor het account:\n" .
                    $result["username"] ."\n
                    Klik op de link hieronder om uw wachtwoord de veranderen:\n
                    http://localhost/windesheim/KBS-groep-2/views/login/forgot-password-reset.php";
            $headers = "From: webmaster@example.com" . "\r\n";

            mail($to,$subject,$txt,$headers);

            $mail = getGmailConfigAction();

            //Set who the message is to be sent from
            $mail->setFrom('christiaangoslinga@gmail.com', 'Christiaan Goslinga');

            //Set who the message is to be sent to
            $mail->addAddress('christiaangoslinga@gmail.com');

            //Set the subject line
            $mail->Subject = 'Wachtwoord veranderen aanvraag';

            //Set email format to HTML
            $mail->isHTML(true);

            ob_start(); // Start output buffer capture.
            include("../../views/email/email.php"); // Include your template.
            $email = ob_get_contents(); // This contains the output of yourtemplate.php
            // Manipulate $output...
            ob_end_clean(); // Clear the buffer.

            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $mail->msgHTML($email);

            //Replace the plain text body with one created manually
            $mail->AltBody = "Er is een wachtwoord veranderen aanvraag gedaan voor het account:\n" .
                           $result["username"] ."\n
                           Klik op de link hieronder om uw wachtwoord de veranderen:\n
                           http://localhost/windesheim/KBS-groep-2/views/login/forgot-password-reset.php?token=" . $token;

            if (!$mail->send()) {
                $_SESSION["mailerror"] = "Er is een fout opgetreden met het versturen van de mail: " . $mail->ErrorInfo;
                header("Location: " . $_SERVER['HTTP_REFERER']);
                die();
            } else {
                $_SESSION["mailsend"] = "Er is een mail verstuurd naar dit emailadres: " . $_POST["email"];
                header("Location: " . $_SERVER['HTTP_REFERER']);
                die();
            }
        }
    } catch(PDOException $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div><br><a href='" . $_SERVER['HTTP_REFERER'] . "'>terug naar wachtwoord vergeten pagina</a>";
    }
}

if(isset($_POST['email'])) {
    forgotPasswordAction();
}

die();