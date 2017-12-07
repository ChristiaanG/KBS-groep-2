<?php
/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 6-12-2017
 * Time: 09:44
 */

function checkPasswordResetAction()
{
    if(isset($_GET["token"])) {
        try {
            include_once "../../config/Database.php";
            $conn = getDbConnection();

            $stmt = $conn->prepare("SELECT username FROM user WHERE reset_token = ?");
            $stmt->execute(array($_GET["token"]));
            $result = $stmt->fetch();

            if(empty($result)) {
                if(isset($_SERVER['HTTP_REFERER'])) {
                    echo "<div class='alert alert-danger'>Error: uw reset token is niet geldig</div><br><a href='" . $_SERVER['HTTP_REFERER'] . "'>terug naar wachtwoord vergeten pagina</a>";
                    exit();
                } else {
                    include "../../config/Config.php";
                    $config = config();
                    echo "<div class='alert alert-danger'>Error: uw reset token is niet geldig</div><br><a href='" . $config["login"] . "'>terug naar loginpagina</a>";
                    exit();
                }
            } else {
                $_SESSION["usernameResetToken"] = $result["username"];
            }
        } catch(PDOException $e) {
            if(isset($_SERVER['HTTP_REFERER'])) {
                echo "<div class='alert alert-danger'>Error: uw reset token is niet geldig</div><br><a href='" . $_SERVER['HTTP_REFERER'] . "'>terug naar wachtwoord vergeten pagina</a>";
                exit();
            } else {
                include "../../config/Config.php";
                $config = config();
                echo "<div class='alert alert-danger'>Error: uw reset token is niet geldig</div><br><a href='" . $config["login"] . "'>terug naar loginpagina</a>";
                exit();
            }
        }
    } else {
        include_once "../../config/Config.php";

        $config = config();

        header("Location: " . $config["login"]);
        die();
    }
}

checkPasswordResetAction();