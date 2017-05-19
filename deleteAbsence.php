<?php

require "header.php";

$absence = new Absence();
if($absence->deleteAbsence($_GET["id"])):
    $_SESSION["message"] = "L'absence a était bien supprimer";
    if($_SESSION["type"] == "professeur"):
        header("Location: absences_par_prof.php");
        exit();
    endif;

endif;

?>