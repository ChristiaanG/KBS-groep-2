<?php
require_once "Role.php";
require_once "PrivilegedUser.php";

$db ="mysql:host=localhost;dbmy=cursus;port=3306";
$user = "root";
$pass = "";
$pdo = new PDO($db, $user, $pass);

session_start();

if (isset($_SESSION["loggedin"])) {
    $u = PrivilegedUser::getByUsername($_SESSION["loggedin"]);
}

if ($u->hasPrivilege("thisPermission")) {
    // wat mag hij doen
}