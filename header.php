<?php

    session_start();
    require "./files/database.php";
    require "./files/functions.php";

?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestion Absence</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css" >
    <link rel="stylesheet"  href="./css/styles.css" >
</head>
<body>
<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Gestion Absence</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Accueil</a></li>
                <?php if(isset($_SESSION["login"]) && $_SESSION["type"] == "admin" ): ?>
                    <li><a href="admin.php"> <i class="fa fa-dashboard"></i> Administration</a></li>
                <?php elseif(isset($_SESSION["type"]) && $_SESSION["type"] == "etudiant" ): ?>
                    <li><a href="etudiant.php"> <i class="fa fa-dashboard"></i> Mes absences</a></li>
                <?php elseif(isset($_SESSION["type"]) && $_SESSION["type"] == "professeur" ): ?>
                    <li><a href="professeur.php"> <i class="fa fa-dashboard"></i> Professeur</a></li>
                <?php elseif(isset($_SESSION["id"])): ?>
                    <li><a href="disconnect.php"> <i class="fa fa-dashboard"></i> <i class="fa fa-logout"></i> Se déconnecter</a></li>
                <?php endif ?>
                <?php if(!isset($_SESSION["login"])): ?>
                    <li><a href="signup.php">Inscription</a></li>
                    <li><a href="login.php">Connexion</a></li>
                <?php endif ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<?php if(isset($_SESSION["message"])): ?>
    <div class="container">
        <div class="row">
            <div class="alert alert-info" >
                <?php echo $_SESSION["message"] ?>
            </div>
        </div>
    </div>
<?php endif ?>
