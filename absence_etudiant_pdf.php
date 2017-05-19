<?php

session_start();
require "./files/database.php";
require "./files/functions.php";

$e = new Etudiant();
$etudiant = $e->getEtudiant($_GET["id"]);
$a = new Absence();
$absences = $a->listAbsenceParEtudiant($_GET["id"]);


?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestion Absence</title>
</head>
<body>
<div class="container-fluid">
    <h3><?= $etudiant["nom"] ?> <?= $etudiant["prenom"] ?></h3>
    <table class="table" border="1" >
        <tr>
            <th>Module</th>
            <th>Date absence</th>
            <th>Créneau horaire</th>
            <th>Justification</th>
        </tr>
        <?php foreach ($absences as $ab): ?>
            <tr>
                <td><?= $ab["module"] ?></td>
                <td><?= $ab["date_absence"] ?></td>
                <td><?= $ab["crn_horaire"] ?></td>
                <td><?= $ab["type_absence"] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<script src="./js/jquery-3.2.1.min.js" ></script>
<script src="./js/bootstrap.min.js" ></script>
<script src="./js/jspdf.debug.js" ></script>
<script src="./js/app.js" ></script>

<script>
    var doc = new jsPDF();

    // We'll make our own renderer to skip this editor
    var specialElementHandlers = {
        '#editor': function(element, renderer){
            return true;
        }
    };

    // All units are in the set measurement for the document
    // This can be changed to "pt" (points), "mm" (Default), "cm", "in"
    doc.fromHTML($('body').get(0), 15, 15, {
        'width': 170,
        'elementHandlers': specialElementHandlers
    });

    doc.save('absences-<?=$etudiant["nom"]; ?>.pdf');

</script>

</body>
</html>




