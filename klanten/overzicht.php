<!DOCTYPE html>

<?php
$pdo = new PDO("mysql:host=localhost; dbname=mydb; port=3306", "root", "");
// Eerst toevoegen als daar op is geklikt
if (isset($_GET["toevoegen"])) {
    // op toevoegen geklikt, nummer bestaat en nummer is niet leeg
    $stmt = $pdo->prepare("INSERT INTO customer (first_name, last_name, address, email, phoneNr, cellphoneNr,description) VALUES(?,?,?,?,?,?,?)");
    $stmt->execute(array($_GET["voornaam"], $_GET["achternaam"], $_GET["adres"], $_GET["email"], $_GET["phonenr"], $_GET["cellphoneNr"], $_GET["description"]));
}
// daarna pas alle klanten uit de database selecteren zodat je de toegevoegde klant ook ziet
$stmt = $pdo->prepare("SELECT * FROM customer");
$stmt->execute();
$klanten = $stmt->fetchAll();
$pdo = NULL;
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Klantenoverzicht v0.1</title>
    </head>
    <body>
        <h1>Klantenoverzicht v0.1</h1>
        <form method="get" action="overzicht.php">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Naam</th>
                    <th>achternaam</th>
                    <th>adres</th>
                    <th>email</th>
                    <th>telefoon nummer</th>
                    <th>mobiel nummer</th>
                    <th>opmerking</th>
                </tr>
                <tr>
                    <td><input type="hidden" name="test"></td>
                    <td><input type="text" name="voornaam"></td>
                    <td><input type="text" name="achternaam"></td>
                    <td><input type="text" name="adres"></td>
                    <td><input type="text" name="email"></td>
                    <td><input type="text" name="phonenr"></td>
                    <td><input type="text" name="cellphoneNr"></td>
                    <td><input type="text" name="description"></td>
                    <td><input type="submit" name="toevoegen" value="Toevoegen"></td>
                </tr>
                <?php
                foreach ($klanten as $klant) {
                    print("\n\t<tr>");
                    print("\n\t\t<td>" . $klant["customerID"] . "</td>");
                    print("\n\t\t<td>" . $klant["first_name"] . "</td>");
                    print("\n\t\t<td>" . $klant["last_name"] . "</td>");
                    print("\n\t\t<td>" . $klant["address"] . "</td>");
                    print("\n\t\t<td>" . $klant["email"] . "</td>");
                    print("\n\t\t<td>" . $klant["phoneNr"] . "</td>");
                    print("\n\t\t<td>" . $klant["cellphoneNr"] . "</td>");
                    print("\n\t\t<td>" . $klant["description"] . "</td>");
                    print("<td><a href=\"klant.php?nummer=" . $klant["customerID"] . "\">ga naar klant</a></td>");
                    print("\n\t</tr>");
                }
                ?>

            </table>
        </form>
    </body>
</html>
