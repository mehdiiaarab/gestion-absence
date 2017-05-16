<?php

    require_once "header.php";
    require "./files/Etudiant.php";
    $student = new Etudiant();

    $students = $student->listEtudiants();

?>
<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <h3>Liste des étudiants</h3>
        <table class="table">
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Tél</th>
                <th>Email</th>
                <th>Date naissance</th>
                <th>Action</th>
            </tr>
            <?php foreach($students as $s): ?>
            <tr>
                <td><?=$s["id"] ?></td>
                <td><?=$s["nom"] ?></td>
                <td><?=$s["prenom"] ?></td>
                <td><?=$s["telephone"] ?></td>
                <td><?=$s["email"] ?></td>
                <td><?=$s["date_naissance"] ?></td>
                <td><a href="marquer_absence.php?id=<?=$s['id'] ?>" class="btn btn-sm btn-warning"><i class="fa fa-flag-o"></i> Marquer absence</a></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
<?php require_once "footer.php" ?>