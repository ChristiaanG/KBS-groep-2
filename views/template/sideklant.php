<nav id="side-menu">
    <div class="navbar-fixed-top sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="#"><i class="fa fa-tachometer fa-fw"></i> dashboard<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="../dashboard/index.php">home</a>
                        </li>
                        <?php if ($_SESSION["function"] == "admin" or $_SESSION["function"] == "medewerker") { ?>
                            <li>
                                <a href="../dashboard/repairstats.php">reparatie stats</a>
                            </li>
                            <li>
                                <a href="../dashboard/klantstats.php">klant stats</a>
                            </li>
                        <?php } ?>
                    </ul>

                </li>
                <?php if ($_SESSION["function"] == "admin" or $_SESSION["function"] == "medewerker") { ?>
                    <li>
                        <a href="#"><i class="fa fa-users fa-fw"></i> klanten<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="../klant/overzicht.php">klant overzicht</a>
                            </li>
                            <li>
                                <a href="../klant/addklant.php">klant toevoegen</a>
                            </li>
                        </ul>

                    </li>
                <?php } ?>

                <li>
                    <a href="#"><i class="fa fa-wrench fa-fw"></i>reparaties<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="../reparaties/repairoverzicht.php">reparatie overzicht</a>
                        </li>
                        <?php if ($_SESSION["function"] == "admin" or $_SESSION["function"] == "medewerker") { ?>
                            <li>
                                <a href="../reparaties/reparatieToevoegenStap1.php">reparatie toevoegen</a>
                            </li>
                        <?php } ?>
                    </ul>

                </li>
                <li>
                    <a href="#"><i class="fa fa-user fa-fw"></i>account<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="../account/mijnaccount.php">mijn account</a>
                        </li>
                        <li>
                            <a href="../account/bewerkaccount.php">bewerk account</a>
                        </li>
                        <li>
                            <a href="../account/bewerkpassword.php">bewerk password</a>
                        </li>
                        <li>
                            <a href="../../src/login/login.php?logout=true">uitloggen</a>
                        </li>
                    </ul>

                </li>
                <?php if ($_SESSION["function"] == "admin") : ?>
                    <li>
                        <a href="#"><i class="fa fa-user fa-fw"></i>beheer<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="../medewerkers/index.php">account activatie</a></li>

                            <li><a href="../medewerkers/apparaatcategorie.php">catagorieën toevoegen</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>