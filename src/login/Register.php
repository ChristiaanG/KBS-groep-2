<?php
/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 16-11-2017
 * Time: 15:47
 */

include_once "../../config/Config.php";
include_once "../../config/Database.php";
include_once "../../config/GlobalVariables.php";


function registerAction()
{
    $username = $_POST["username"];
    $password = $_POST["password"];
    $name = $_POST["name"];

    try {
        $conn = getDbConnection();
        $stmt = $conn->prepare("INSERT INTO user (username, password, name) VALUES (?, ?, ?)");
        $stmt->execute(array($username, $password, $name));

        header("Location: " . $_SESSION["home"]);
        die();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

if(isset($_POST['submit']))
{
    registerAction();
}
