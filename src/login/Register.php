<?php
/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 16-11-2017
 * Time: 15:47
 */

include_once "../config/Database.php";

function registerAction()
{
    $username = $_POST["username"];
    $password = $_POST["password"];
    $name = $_POST["name"];

    $con = getDbConnection();

    $sql = "INSERT INTO user (username, password, name) VALUES ('" . $username . "', '" . $password . "', '" . $name . "')";

    if (mysqli_query($con, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }

    mysqli_close($con);
}

if(isset($_POST['submit']))
{
    registerAction();
}
