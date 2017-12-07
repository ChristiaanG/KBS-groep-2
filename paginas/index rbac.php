<?php
require_once "Role.php";
require_once "PrivilegedUser.php";

// connect to database
$db ="mysql:host=localhost;dbname=oop_rbac;port=3306";


session_start();

if (isset($_SESSION["loggedin"])) {
    $u = PrivilegedUser::getByUsername($_SESSION["loggedin"]);
}

if ($u->hasPrivilege("thisPermission")) {
    // do something
    print("hallo");
}