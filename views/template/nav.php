<meta charset="utf-8">
<title>project groep 2 ICTm1e</title>
<link rel="icon" href="../../resources/img/klant/favicon.ico.jpg" type="image/ico">

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
    <ul class=" nav navbar-nav navbar-right navbar-top-links">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <?php echo $_SESSION["username"] ?> <b class="caret"></b>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="../account/mijnaccount.php"><i class="fa fa-gear fa-fw"></i>mijn account</a>
                </li>
                <li class="divider"></li>
                <li><a href="../../src/login/Login.php?logout=true"><i class="fa fa-sign-out fa-fw"></i>uitloggen</a>
                </li>
            </ul>
        </li>
    </ul>

</nav>

