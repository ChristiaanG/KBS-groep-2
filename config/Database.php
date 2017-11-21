<?php
/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 16-11-2017
 * Time: 10:40
 */

include_once "Config.php";

function getDbConnection()
{
    $config = config();
    $conn = null;

    $servername = $config["host"];
    $username = $config["username"];
    $password = $config["password"];
    $dbname = $config["dbname"];
    $port = $config["port"];

    $conn = new PDO("mysql:host=$servername;dbname=$dbname;port=$port", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn;
}
?>
