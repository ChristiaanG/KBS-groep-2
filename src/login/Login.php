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

    //Check if username and/or password are filled in
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

            $stmt = $conn->prepare("SELECT * FROM user WHERE username = ? AND deleted != 1");
            $stmt->execute(array($username));
            $result = $stmt->fetch();

            if($result == false) {
                $conn = null;
                $_SESSION["loginfailed"] = "U heeft uw gebruikersnaam en/of wachtwoord fout ingevoerd";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                die();
            } else {
                //Check if account has been locked because of to many failed login attempts
                if($result["is_locked"] == true) {
                    $stmt = $conn->prepare("SELECT * FROM login_attempt WHERE username = ?");
                    $stmt->execute(array($username));
                    $lockedUser = $stmt->fetch();

                    //If the locked time has been 15 minutes or longer, unlock the account and continue the login process or else keep it locked
                    if(strtotime($lockedUser["time"]) < strtotime("-15 minutes")) {
                        $stmt = $conn->prepare("UPDATE user SET is_locked = 0 WHERE username = ?");
                        $stmt->execute(array($username));

                        $stmt = $conn->prepare("UPDATE login_attempt SET time = NULL, attempt = 0 WHERE username = ?");
                        $stmt->execute(array($username));
                    } else {
                        $_SESSION["loginfailed"] = "Uw account geblokkeerd omdat er te vaak fout is geprobeerd om in te loggen. Probeer het over een paar minuten nog een keer.";
                        header("Location: " . $_SERVER['HTTP_REFERER']);
                        die();
                    }
                }

                //Check if the given password is the correct password
                $passwordTrue = password_verify($password, $result["password"]);

                if($passwordTrue && $result["approved"] == true) {
                    $conn = null;

                    //See if the two factor authentication cookie has been set for users with the function "medewerker" or "admin" and see if they have already enabled two factor authentication.
                    //Lastly check if the logged in account has been approved by the administrator
                    if((!isset($_COOKIE["2fa_set"]) || $_COOKIE["2fa_set"] != $username || $result["2fa_enabled"] == false) && ($result["function"] == "admin" || $result["function"] == "medewerker")) {
                        if($result["2fa_enabled"] == false) {
                            $_SESSION["username"] = $username;
                            $_SESSION["function"] = $result["function"];
                            $_SESSION["2fa_redirect"] = true;
                            header("Location: " . $config["2fa_re"]);
                            die();
                        } elseif($result["2fa_enabled"] == true) {
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
                } elseif($result["approved"] == false && $result["approved"] == 0) {
                    $_SESSION["loginfailed"] = "Uw account is nog niet geactiveerd door de administrator";
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    die();
                } else {
                    if($result != false) {
                        //Set number of failed login attempts for the specific account if account exists
                        $stmt = $conn->prepare("SELECT * FROM login_attempt WHERE username = ?");
                        $stmt->execute(array($username));
                        $loginAttemptResult = $stmt->fetch();

                        //If it's first failed login attempt on the account then insert new record else update current record
                        if(!$loginAttemptResult) {
                            $firstLoginAttempt = 1;
                            $loginTime = date("Y-m-d H:i:s");

                            $stmt = $conn->prepare("INSERT INTO login_attempt VALUES (?, ?, ?)");
                            $stmt->execute(array($username, $firstLoginAttempt, $loginTime));
                        } else {
                            $currentLoginAttempts = $loginAttemptResult["attempt"]++;

                            if($currentLoginAttempts == 1) {
                                $loginTime = date("Y-m-d H:i:s");

                                $stmt = $conn->prepare("UPDATE login_attempt SET attempt = ?, time = ? WHERE username = ?");
                                $stmt->execute(array($currentLoginAttempts, $loginTime, $username));
                            } else {
                                $stmt = $conn->prepare("UPDATE login_attempt SET attempt = ? WHERE username = ?");
                                $stmt->execute(array($currentLoginAttempts, $username));
                            }

                            if($loginAttemptResult["attempt"] >= 5) {
                                $stmt = $conn->prepare("UPDATE user SET is_locked = 1 WHERE username = ?");
                                $stmt->execute(array($username));
                            }
                        }
                    }

                    $conn = null;
                    $_SESSION["loginfailed"] = "U heeft uw gebruikersnaam en/of wachtwoord fout ingevoerd";
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    die();
                }
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