<meta charset="utf-8">
<title>project groep 2 ICTm1e</title>
<link rel="icon" href="../../klant/favicon.ico.jpg" type="image/ico">

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="index.php">Fixitallcomputers</a>
    </div>

    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <ul class="nav navbar-nav navbar-left navbar-top-links">
        <li><a href="../dashboard/index.php"><i class="fa   fa-tachometer  fa-fw"></i>dashboard</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-left navbar-top-links">
        <li><a href="../reparaties/repairoverzicht.php"><i class="fa  fa-wrench  fa-fw"></i>reparaties</a></li>
    </ul>
    <?php if ($_SESSION["function"] == "admin" or $_SESSION["function"] == "medewerker") { ?>
        <ul class="nav navbar-nav navbar-left navbar-top-links">
            <li><a href="../klant/overzicht.php"><i class="fa fa-users  fa-fw"></i>klanten</a></li>
        </ul>
    <?php } ?>
    <?php if ($_SESSION["function"] == "admin") { ?>
        <ul class="nav navbar-nav navbar-left navbar-top-links">
            <li><a href="../medewerkers/index.php"><i class="fa fa-edit  fa-fw"></i>beheerpaneel</a></li>

        </ul>
    <?php } ?>
    <ul class="nav navbar-nav navbar-right navbar-top-links">
        <li><a href="../account/mijnaccount.php"><i class="fa fa-user  fa-fw"></i><?php echo $_SESSION["username"] ?></a></li>
    </ul>

</nav>

