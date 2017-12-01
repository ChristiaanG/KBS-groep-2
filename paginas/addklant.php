<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <?php include 'nav.php'; ?>
    </head>
    <body>
        <?php include 'sideklant.php'; ?>
        <div id="page-wrapper">
            <table class="table table-striped table-bordered table-hover">
                <tr>
                    <td>ID</td>
                    <td>voornaam</td>
                    <td>achternaam</td>
                    <td>adres</td>
                    <td>woonplaats</td>
                    <td>email</td>
                    <td>telefoon nummer</td>
                    <td>mobiel nummer</td>
                    <td>profiel</td>

                </tr>
                <tr>
                <form method="get" action="overzicht.php">
                    <td><input type="hidden" name="test"></td>
                    <td> <input type="text" name="voornaam" required></td>
                    <td> <input type="text" name="achternaam" required></td>
                    <td> <input type="text" name="adres" required></td>
                    <td> <input type="text" name="woonplaats" required></td>
                    <td> <input type="text" name="email" required></td>
                    <td><input type="text" name="phonenr" required></td>
                    <td> <input type="text" name="cellphoneNr" required></td>
                    <td> <input type="submit" name="toevoegen" class="btn btn-primary" value="Toevoegen"></td>

                </form>
                </tr>
            </table>
        </div>
    </body>
</html>
