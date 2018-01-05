<?php
/**
 * GoogleAuthenticator
 *
 * PHP version 5
 *
 * @package  Johnstyle\GoogleAuthenticator
 * @author   Jonathan Sahm <contact@johnstyle.fr>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/johnstyle/google-authenticator
 */

session_start();

include_once "../../src/login/check/Check2faRedirect.php";

require_once "../../lib/base32/src/Base32.php";
require_once "../../lib/google-authenticator/src/Johnstyle/GoogleAuthenticator/GoogleAuthenticator.php";
require_once "../../lib/google-authenticator/src/Johnstyle/GoogleAuthenticator/GoogleAuthenticatorException.php";

use Johnstyle\GoogleAuthenticator\GoogleAuthenticator;

if (!isset($_SESSION['2fa_qr']) && !isset($_SESSION['2fa_secret'])) {
    $gAuth = new GoogleAuthenticator();

    // Register application
    $_SESSION["2fa_qr"] = $gAuth->getQRCodeUrl('Fixitallcomputers');

    // Save secret Key
    $_SESSION['2fa_secret'] = $gAuth->getSecretKey();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Google Authenticator</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="<?= (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] ?>/resources/css/google-authenticator.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
    <h1>Registreer applicatie</h1>
    <h2>a. Scan de QRCode met uw smarphone</h2>
    <p>
        Gebruike de Google Authenticator app voor smartphones
        <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" target="_blank">Android</a>
        of
        <a href="https://itunes.apple.com/fr/app/google-authenticator/id388497605" target="_blank">iPhone</a>
    </p>
    <div class="qrcode"><img src="<?php echo $_SESSION["2fa_qr"]; ?>" alt=""/></div>
    <h2>b. Kopieer/plak verificatie code</h2>
    <?php echo $_SESSION["2fa_secret"]; ?>
    <?php
    if(isset($_SESSION["twofaregisterfailed"])) {
        ?>
        <div class="alert alert-danger">
            <?php
                echo $_SESSION["twofaregisterfailed"];
                $_SESSION['twofaregisterfailed'] = NULL;
            ?>
        </div>
        <?php
    }
    ?>
    <form method="post" action="../../src/login/TwoStepAuthentication.php">
        <input placeholder="Code" type="text" name="2fa_code" maxlength="6" autofocus="autofocus"/>
        <button type="submit" name="register">Registreer</button>
        <div style="clear:both"></div>
    </form>
</div>
</body>
</html>
