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
<script src="./js/jspdf.min.js" ></script>
<script src="./js/jspdf.plugin.autotable.js" ></script>
<script src="./js/app.js" ></script>

<script>
    var columns = ["Module", "Date absence", "Créneau horaire", "Justification"];
    var rows = [];

    <?php foreach ($absences as $a): ?>
      var row = ["<?=$a['module'] ?>","<?=$a['date_absence'] ?>", "<?=$a['crn_horaire'] ?>", "<?=$a['type_absence'] ?>"];
      rows.push(row);
    <?php endforeach; ?>

    var doc = jsPDF();
    doc.autoTable(columns, rows, {
        margin: {top: 50},
        addPageContent: function(data) {
            doc.text("<?=$etudiant['nom'].' '.$etudiant['prenom'] ?>", 40, 30);
        }
    });

    doc.save("<?=$etudiant['nom'].' '.$etudiant['prenom'] ?>");
</script>

</body>
</html>




