

<?php

$info = pathinfo($_FILES['fileToUpload']['name']);
$ext = $info['extension']; // hier checkt hij de extentie van de file
$newname = $_POST["nummer"] . "." . $ext;

$target = '../klant/' . $newname;
if ($ext != "jpg") {
    print("<h3>error</h3></div><div class=\"panel-body\">");
    print ("<h3>error bestand is geen .jpg foto.</h3><br>");
    print("<a href=\"bewerkklant.php?nummer=" . $_POST["nummer"] . "\"class=\"btn btn-primary\">terug naar bewerk klant</a>");
    print("  ");
    print("<a href=\"klant.php?nummer=" . $_POST["nummer"] . "\"class=\"btn btn-primary\">terug naar klant pagina</a>");
}
if ($_FILES["fileToUpload"]["size"] > 900000) {
    print("<h3>error</h3>");
    print "<h3>de foto die uw wil uploaden is te groot.</h3>";
} else {
    move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target);
}
?>