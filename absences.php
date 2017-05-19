<?php

require_once "header.php";

$absences = new Absence();
$absences = $absences->listAbsences();

?>


<div class="container">
    <h3>Liste des absences des étudiants</h3>
    <hr>
    <table class="table">
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>CNE</th>
            <th>Module</th>
            <th>Date absence</th>
            <th>Justification</th>
            <?php if($_SESSION["type"] == "admin"): ?>
                <th><i class="fa fa-trash-o"></i> Suppr.</th>
            <?php endif; ?>
        </tr>
        <?php foreach($absences as $a): ?>
            <tr>
                <td><?=$a["nom"] ?></td>
                <td><?=$a["prenom"] ?></td>
                <td><?=$a["email"] ?></td>
                <td><?=$a["cne"] ?></td>
                <td><?=$a["module"] ?></td>
                <td><?=$a["date_absence"] ?></td>
                <td><?=$a["type_absence"] ?></td>
                <?php if($_SESSION["type"] == "admin"): ?>
                    <td><a href="deleteAbsence.php?id=<?=$a['id'] ?>"><i class="fa fa-trash-o"></i></a></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php require_once "footer.php"?>