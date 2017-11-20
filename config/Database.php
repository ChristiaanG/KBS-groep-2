<?php
/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 16-11-2017
 * Time: 10:40
 */

function getDbConnection()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "kbs";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}
?>
