<?php
    include_once "config/Config.php";

    $config = config();

    header('Location: ' . $config["login"]);
    die();
?>