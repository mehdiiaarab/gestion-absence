<?php require_once "header.php" ?>
<div class="container">
    <div class="text-center">
        <h1><i class="fa fa-graduation-cap"></i></h1>
        <h2>Gestion d'absence</h2>
        <h3>ENSA TETOUAN - 2017</h3>
    </div>

    <!-- Professeur -->
    <?php if(isset($_SESSION["type"]) && $_SESSION["type"] == "professeur" ): ?>
        <a href="etudiants.php" class="btn btn-sm btn-primary">Liste des étudiants</a>
        <hr>
        <?php include "alerts.php"; ?>
    <?php endif ?>

    <!-- Administrateur -->
    <?php if(isset($_SESSION["type"]) && $_SESSION["type"] == "admin" ): ?>

        <?php include "alerts.php"; ?>
    <?php endif ?>

    <!-- Etudiant -->
    <?php if(isset($_SESSION["type"]) && $_SESSION["type"] == "etudiant" ): ?>
        <a href="absence.php" class="btn btn-lg btn-primary">Mes absences</a>
    <?php endif ?>

    <?php if(!isset($_SESSION["id"])) :?>
        <div class="text-center">
            <a href="login.php" class="btn btn-lg btn-primary">Se connecter</a>
            <a href="signup.php" class="btn btn-lg btn-default">S'inscrire</a>
        </div>
        <hr>
    <?php endif ?>



</div>
<?php require_once "footer.php" ?>
