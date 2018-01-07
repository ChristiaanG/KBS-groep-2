<nav id="side-menu">
    <div class="navbar-fixed-top sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="#"><i class="fa fa-tachometer fa-fw"></i> Dashboard<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?= (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] ?>/views/dashboard/index.php">Home</a>
                        </li>
                        <?php if ($_SESSION["function"] == "admin" or $_SESSION["function"] == "medewerker") { ?>
                            <li>
                                <a href="<?= (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] ?>/views/dashboard/repairstats.php">Reparatie stats</a>
                            </li>
                            <li>
                                <a href="<?= (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] ?>/views/dashboard/klantstats.php">Klant stats</a>
                            </li>
                        <?php } ?>
                    </ul>

                </li>
                <?php if ($_SESSION["function"] == "admin" or $_SESSION["function"] == "medewerker") { ?>
                    <li>
                        <a href="#"><i class="fa fa-users fa-fw"></i> Klanten<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?= (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] ?>/views/klant/overzicht.php">Klant overzicht</a>
                            </li>
                            <li>
                                <a href="<?= (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] ?>/views/klant/addklant.php">Klant toevoegen</a>
                            </li>
                        </ul>

                    </li>
                <?php } ?>

                <li>
                    <a href="#"><i class="fa fa-wrench fa-fw"></i>Reparaties<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?= (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] ?>/views/reparaties/repairoverzicht.php">Reparatie overzicht</a>
                        </li>
                        <?php if ($_SESSION["function"] == "admin" or $_SESSION["function"] == "medewerker") { ?>
                            <li>
                                <a href="<?= (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] ?>/views/reparaties/reparatieToevoegenStap1.php">Reparatie toevoegen</a>
                            </li>
                        <?php } ?>
                    </ul>

                </li>
                <li>
                    <a href="#"><i class="fa fa-user fa-fw"></i>Account<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?= (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] ?>/views/account/mijnaccount.php">Mijn account</a>
                        </li>
                        <li>
                            <a href="<?= (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] ?>/views/account/bewerkaccount.php">Bewerk account</a>
                        </li>
                        <li>
                            <a href="<?= (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] ?>/views/account/bewerkpassword.php">Bewerk password</a>
                        </li>
                        <li>
                            <a href="<?= (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] ?>/src/login/login.php?logout=true">Uitloggen</a>
                        </li>
                    </ul>

                </li>
                <?php if ($_SESSION["function"] == "admin") : ?>
                    <li>
                        <a href="#"><i class="fa fa-user fa-fw"></i>Beheer<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?= (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] ?>/views/medewerkers/index.php">Account beheer</a></li>

                            <li><a href="<?= (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER["HTTP_HOST"] ?>/views/medewerkers/apparaatcategorie.php">Categorieën toevoegen</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>