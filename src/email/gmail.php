<?php
/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 30-11-2017
 * Time: 13:19
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../lib/PHPMailer/src/Exception.php';
require '../../lib/PHPMailer/src/PHPMailer.php';
require '../../lib/PHPMailer/src/SMTP.php';

include_once '../../config/EmailConfig.php';

function getGmailConfigAction()
{
    //Create a new PHPMailer instance
    $mail = new PHPMailer;

//    $mail->setLanguage('nl');

    //Tell PHPMailer to use SMTP
    $mail->isSMTP();

    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;

    //Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
    // use
    // $mail->Host = gethostbyname('smtp.gmail.com');
    // if your network does not support SMTP over IPv6

    //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 587;

    //Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'tls';

    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    //Get gmail configuration
    $mailConfig = emailConfig();

    //Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = $mailConfig["username"];

    //Password to use for SMTP authentication
    $mail->Password = $mailConfig["password"];

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    return $mail;
}