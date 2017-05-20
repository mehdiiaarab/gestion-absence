<?php

session_start();
require "./files/database.php";
require "./files/functions.php";

$a = new Absence();
if($a->remettreZeroAbsences()){
    $_SESSION["message"] = "Les absences sont initalisés a Zero";
}else{
    $_SESSION["message"] = "Erreur lors de votre action";
}

header("Location: index.php");
exit();

?>
