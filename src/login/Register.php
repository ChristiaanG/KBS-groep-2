<?php
/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 16-11-2017
 * Time: 15:47
 */

include_once "../../config/Config.php";
include_once "../../config/Database.php";


function registerAction()
{
    $username = $_GET["username"];
    $password = $_GET["password"];
    $name = $_GET["name"];

    $config = config();

    try {
        $conn = getDbConnection();
        $stmt = $conn->prepare("INSERT INTO user (username, password, name) VALUES (?, ?, ?)");
        $result = $stmt->execute(array($username, $password, $name));

        if($result == true) {
            $conn = null;
            header("Location: " . $config["home"]);
            die();
        } else {
            $conn = null;
            $_GET["registerfailed"] = "Uw wachtwoord en of gebruikersnaam voldoen niet aan de eisen";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            die();
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if(isset($_GET['submit']))
{
    registerAction();
}
