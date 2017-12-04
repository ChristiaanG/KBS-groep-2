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
            $_SESSION["email"] = $result["username"];

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

            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $mail->isHTML(true);
//
//            $mail->Body = $mail->Body = "Er is een wachtwoord veranderen aanvraag gedaan voor het account:\n" .
//                           $result["username"] ."\n
//                           Klik op de link hieronder om uw wachtwoord de veranderen:\n
//                           http://localhost/windesheim/KBS-groep-2/views/login/forgot-password-reset.php";


            ob_start(); // Start output buffer capture.
            include("../../views/email/email.php"); // Include your template.
            $email = ob_get_contents(); // This contains the output of yourtemplate.php
            // Manipulate $output...
            ob_end_clean(); // Clear the buffer.
            $mail->msgHTML($email);

            $mail->AltBody = "Er is een wachtwoord veranderen aanvraag gedaan voor het account:\n" .
                           $result["username"] ."\n
                           Klik op de link hieronder om uw wachtwoord de veranderen:\n
                           http://localhost/windesheim/KBS-groep-2/views/login/forgot-password-reset.php";

            //Replace the plain text body with one created manually
//            $mail->AltBody = 'This is a plain-text message body';

            //Attach an image file
//            $mail->addAttachment('images/phpmailer_mini.png');

            //send the message, check for errors
//            $mail->send();

            if (!$mail->send()) {
                $_SESSION["mailerror"] = "Er is een fout opgetreden met het versturen van de mail: " . $mail->ErrorInfo;
                header("Location: " . $_SERVER['HTTP_REFERER']);
                die();
            } else {
                $_SESSION["mailsend"] = "Er is een mail verstuurd naar dit emailadres: " . $_POST["email"];
                header("Location: " . $_SERVER['HTTP_REFERER']);
                die();
                //Section 2: IMAP
                //Uncomment these to save your message in the 'Sent Mail' folder.
                #if (save_mail($mail)) {
                #    echo "Message saved!";
                #}
            }
        }
    } catch(PDOException $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

if(isset($_POST['email'])) {
    forgotPasswordAction();
}

die();