<?php
/**
 * Created by PhpStorm.
 * User: Christiaan Goslinga
 * Date: 28-11-2017
 * Time: 12:08
 */

session_start();

if(!isset($_SESSION["loggedin"])) {
    die();
}

include_once "../../config/Database.php";

function getUserAction()
{
    try {
        $conn = getDbConnection();

        $stmt = $conn->prepare("SELECT username, name, function, approved FROM user where deleted != 1");
        $stmt->execute();
        $databaseResult = $stmt->fetchAll();

        $result = "";

        foreach($databaseResult as $array) {
            $result .= "<tr>";
            $result .= "<td>" . $array["username"] . "</td>";
            $result .= "<td>" . $array["name"] . "</td>";
            $result .= "<td>";
            $result .= "<select class='function' data-username='" .  $array["username"] . "'>";
            $result .= "<option value='stagair' ";
            $result .= $array['function'] == 'stagair' ? 'selected="selected"' : '';
            $result .= ">Stagair</option>";
            $result .= "<option value='medewerker' ";
            $result .= $array['function'] == 'medewerker' ? 'selected="selected"' : '';
            $result .= ">Medewerker</option>";
            $result .= "<option value='admin' ";
            $result .= $array['function'] == 'admin' ? 'selected="selected"' : '';
            $result .= ">Administrator</option>";
            $result .= "</select>";
            $result .= "</td>";
            $result .= "<td>";
            $result .= $array['approved'] == 0 ? "<button class='approve btn-success' value='" . $array["username"] . "'>Geef toegang</button>" : "Heeft al toegang tot het systeem.";
            $result .= "</td>";
            $result .= "<td><button class='delete btn-danger' value='" . $array["username"] . "'>Verwijderen</button></td>";
            $result .= "</tr>";
        }
        return $result;
    } catch(PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}

function changeUserFunctionAction()
{
    try {
        $conn = getDbConnection();

        $stmt = $conn->prepare("UPDATE user SET function = ? WHERE username = ?");
        $stmt->execute(array($_POST['functie'], $_POST["username"]));

        return "<div class='alert alert-success'>" . $_POST['username'] . " heeft nu functie " . $_POST['functie'] . ".</div>";
    } catch(PDOException $e) {
        return "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

function approveUserAction()
{
    try {
        $conn = getDbConnection();

        $stmt = $conn->prepare("UPDATE user SET approved = 1 WHERE username = ?");
        $stmt->execute(array($_POST["username"]));

        return "<div class='alert alert-success'>" . $_POST['username'] . " heeft nu toegang tot het systeem";
    } catch(PDOException $e) {
        return "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

function deleteUserAction()
{
    try {
        $conn = getDbConnection();

        $stmt = $conn->prepare("UPDATE user SET deleted = 1 WHERE username = ?");
        $stmt->execute(array($_POST["username"]));

        return "<div class='alert alert-success'>" . $_POST['username'] . " is nu verwijderd uit het systeem";
    } catch(PDOException $e) {
        return "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'get' :
            echo getUserAction();
            break;
        case 'change' :
            echo changeUserFunctionAction();
            break;
        case 'approve' :
            echo approveUserAction();
            break;
        case 'delete' :
            echo deleteUserAction();
            break;
    }
}