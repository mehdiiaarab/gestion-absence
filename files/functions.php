<?php

/* functions */


/* Connexion a la base donnée */
function database()
{

    /* Base donnée */
    $host = "127.0.0.1";
    $username  = "root";
    $password = "";
    $database = "gab";

    $db = new PDO("mysql:host=".$host .";dbname=".$database, $username, $password,
        array (
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
        )
    );

    return $db;

}


/*  */

function connexion($username, $password)
{

    $db = database();

    $sttm = $db->prepare("SELECT * FROM utilisateur WHERE login = :login AND password = :password");
    $sttm->bindParam(':login', $username);
    $sttm->bindParam(':password', $password);
    if($sttm->execute())
    {
        $user = $sttm->fetch(PDO::FETCH_ASSOC);
        if(!empty($user))
        {
            extract($user);
            $_SESSION["id"] = $id;
            $_SESSION["login"] = $login;
            $_SESSION["type"] = $type;

            switch ($type){
                case "professeur":
                    $sttm2 = $db->prepare("SELECT * FROM professeur WHERE id_user = :id");
                    $sttm2->bindParam(':id', $id);
                    if($sttm2->execute()):
                        $professeur = $sttm2->fetch(PDO::FETCH_ASSOC);
                        extract($professeur);
                        $_SESSION["nom"] = $nom;
                        $_SESSION["prenom"] = $prenom;
                        $_SESSION["som"] = $som;
                    endif;
                    break;

                case "etudiant":
                    $sttm2 = $db->prepare("SELECT * FROM etudiant WHERE id_user = :id");
                    $sttm2->bindParam(':id', $id);
                    if($sttm2->execute()):
                        $etudiant = $sttm2->fetch(PDO::FETCH_ASSOC);
                        extract($etudiant);
                        $_SESSION["nom"] = $nom;
                        $_SESSION["prenom"] = $prenom;
                        $_SESSION["cne"] = $cne;
                        $_SESSION["id_etudiant"] = $id;
                    endif;
                    break;

            }


            return true;
        }else{
            return false;
        }
    }

    return false;

}

/* Inscription */

function inscription($login, $password, $type){

    $db = database();

    $sttm = $db->prepare("INSERT INTO utilisateur (login, password, type) VALUE (:login, :password, :type)");
    $sttm->bindParam(':login', $login);
    $sttm->bindParam(':password', $password);
    $sttm->bindParam(':type', $type);

    $sttm->execute();

    $id = $db->lastInsertId();


    return $id;

}

/* Inscription étudiant */
function inscriptionEtudiant($id_user, $cin, $nom, $cne, $prenom, $date_naissance, $adresse, $lieu_naissance, $telephone, $email)
{

    $db = database();

    $sttm = $db->prepare("INSERT INTO etudiant (id_user, cin, nom, cne, prenom, date_naissance, adresse, lieu_naissance, telephone, email) VALUE (:id_user, :cin, :nom, :cne, :prenom, :date_naissance, :adresse, :lieu_naissance, :telephone, :email)");

    $sttm->bindParam(':id_user', $id_user);
    $sttm->bindParam(':cin', $cin);
    $sttm->bindParam(':nom', $nom);
    $sttm->bindParam(':cne', $cne);
    $sttm->bindParam(':prenom', $prenom);
    $sttm->bindParam(':date_naissance', $date_naissance);
    $sttm->bindParam(':adresse', $adresse);
    $sttm->bindParam(':lieu_naissance', $lieu_naissance);
    $sttm->bindParam(':telephone', $telephone);
    $sttm->bindParam(':email', $email);

    if($sttm->execute())
    {
        return true;
    }

    return false;

}


/* Inscription Professeur */


function inscriptionProfesseur($id_user, $som, $nom, $prenom, $telephone, $email){

    $db = database();

    $sttm = $db->prepare("INSERT INTO professeur (id_user, som, nom, prenom, email, telephone) VALUE (:id_user, :som, :nom, :prenom, :email, :telephone)");

    $sttm->bindParam(':id_user', $id_user);
    $sttm->bindParam(':som', $som);
    $sttm->bindParam(':nom', $nom);
    $sttm->bindParam(':prenom', $prenom);
    $sttm->bindParam(':telephone', $telephone);
    $sttm->bindParam(':email', $email);

    if($sttm->execute())
    {
        return true;
    }

    return false;
}


/* Utilisateur déja exist */
function utilisateurDejaExist($email, $login){

    $db = database();

    $sttm = $db->prepare("SELECT * FROM (
            SELECT utilisateur.login from utilisateur
            union all
            SELECT email FROM professeur
            union all
            SELECT email FROM etudiant) utilisateur, professeur, etudiant
            WHERE login = :login or professeur.email = :email or etudiant.email=:email");

    $sttm->bindParam(':login', $login);
    $sttm->bindParam(':email', $email);
    if($sttm->execute())
    {
        $user = $sttm->fetch(PDO::FETCH_ASSOC);
        if(!empty($user))
        {
            return true;
        }else{
            return false;
        }
    }
}

function marquerAbsence($etudiant, $crn_horaire, $type_absence, $module, $professeur, $date_absence)
{

    $db = database();

    $sttm = $db->prepare("INSERT INTO absence (id_etudiant, crn_horaire, type_absence, module, professeur, date_absence) VALUE (:id_etudiant, :crn_horaire, :type_absence, :module, :professeur, :date_absence)");

    $sttm->bindParam(':id_etudiant', $etudiant);
    $sttm->bindParam(':crn_horaire', $crn_horaire);
    $sttm->bindParam(':type_absence', $type_absence);
    $sttm->bindParam(':module', $module);
    $sttm->bindParam(':professeur', $professeur);
    $sttm->bindParam(':date_absence', $date_absence);


    if($sttm->execute())
    {
        return true;
    }

    return false;


}


/* Marquer l'absence */

if(isset($_POST["marquer-absence"]))
{

    if(!empty($_POST["module"]) && !empty($_POST["date_absence"])
        && !empty($_POST["crn_horaire"]) && !empty($_POST["type_absence"]) ){


        if(marquerAbsence($_POST['id'], $_POST["crn_horaire"], $_POST["type_absence"], $_POST["module"], $_SESSION['id'], $_POST['id'])){

            $_SESSION["message"] = "L'absence a été bien marquer";
            header("Location: etudiants.php");
            exit();

        }else{
            $_SESSION["message"] = "Erreur lors de votre action, veuillez réessayer.";
        }


    }else{
        $_SESSION["message"] = "Vous avez laisser des champs vides !";
    }

}




/* Connexion */

if(isset($_POST["connexion"])){

    if(!empty($_POST["username"]) && !empty($_POST["password"])){

        $username = $_POST["username"];
        $password = $_POST["password"];

        if(connexion($username, $password)){
            $_SESSION["message"] = "vous êtes maintenant Connecté !";
            header("Location: index.php");
            exit();
        }else{
            $_SESSION["message"] = "Mot de pass / username Invalid !";
        }

    }

}


/* Inscription */
if(isset($_POST['signup']))
{

    if( !empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["type"]) && !empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["email"]) && !empty($_POST["telephone"])  )
    {

        $utilisteur = new Utilisateur(
            $_POST["username"], $_POST["password"], $_POST["type"]
        );

        if(utilisateurDejaExist($_POST["email"], $_POST["username"])){
            $_SESSION["message"] = "Ce compte existe déjà.";
        }else{

            $id_user = null;
            $id_user = inscription($_POST["username"], $_POST["password"], $_POST["type"]);

            if($id_user != null)
            {
                if($_POST["type"] == "etudiant"){


                    if(inscriptionEtudiant($id_user, $_POST["cin"], $_POST["nom"], $_POST["cne"], $_POST["prenom"], $_POST["date_naissance"], $_POST["adresse"], $_POST["lieu_naissance"], $_POST["telephone"], $_POST["email"])){

                        $_SESSION["message"] = "Vous êtes maintenant inscrit ! merci de se connecter utilisant votre username et mot de passe";
                        header("Location: login.php");
                        exit();
                    }

                }elseif($_POST["type"] == "professeur" ){

                    if(inscriptionProfesseur($id_user, $_POST["som"], $_POST["nom"], $_POST["prenom"], $_POST["telephone"], $_POST["email"])){
                        $_SESSION["message"] = "Vous êtes maintenant inscrit ! merci de se connecter utilisant votre username et mot de passe";
                        header("Location: login.php");
                        exit();
                    }
            }

            }else{

                $_SESSION["message"] = "Erreur lors de votre action, veuillez réessayer.";

            }
        }
    }else{
        $_SESSION["message"] = "Vous avez laisser des champs vides !";
    }


}




function listEtudiants()
{

    $students = [];

    $db = database();

    $sttm = $db->prepare("SELECT e.id, e.nom, e.prenom, e.email, e.cne, e.date_naissance, e.telephone, e.email FROM etudiant e LEFT JOIN module m on m.enseigne_par=:id_enseignant");
    $sttm->bindParam(':id_enseignant', $_SESSION["id"]);
    if($sttm->execute())
    {
        $students = $sttm->fetchAll();
        return $students;
    }

    return $students;
}

function toutEtudiants(){

    $students = [];

    $db = database();

    $sttm = $db->prepare("SELECT * FROM etudiant");
    if($sttm->execute())
    {
        $students = $sttm->fetchAll();
        return $students;
    }

    return $students;
}



function getEtudiant($id)
{
    $student = "";

    $db = database();

    $sttm = $db->prepare("SELECT * FROM etudiant where id=:id");
    $sttm->bindParam(':id', $id);
    if($sttm->execute())
    {
        $student = $sttm->fetch(PDO::FETCH_ASSOC);
        return $student;
    }

    return $student;
}


function calculerAbsences($id)
{

    $nombreAbsences = 0;

    $db = database();

    $sttm = $db->prepare("SELECT count(id_etudiant) FROM absence where id_etudiant=:id and is_old=0 ");
    $sttm->bindParam(':id', $id);
    if($sttm->execute())
    {
        $nombreAbsences = $sttm->fetch(PDO::FETCH_ASSOC);
        return $nombreAbsences;
    }

    return $nombreAbsences;
}



function listModules(){

    $modules = [];

    $db = database();

    $sttm = $db->prepare("SELECT * FROM module");
    if($sttm->execute())
    {
        $modules = $sttm->fetchAll();
        return $modules;
    }

    return $modules;

}


function listAbsenceParEtudiant($id)
{

    $absences_ = $absences =  [];

    $db = database();

    $sttm = $db->prepare("SELECT * FROM absence where id_etudiant=:id and is_old=0");
    $sttm->bindParam(":id", $id);

    if($sttm->execute())
    {
        $absences_ = $sttm->fetchAll();

        foreach ($absences_ as $a)
        {
            $sttm2 = $db->prepare("SELECT * FROM etudiant where id=:id");
            $sttm2->bindParam(":id", $a["id_etudiant"]);

            if($sttm2->execute())
            {

                $etudiant = $sttm2->fetch(PDO::FETCH_ASSOC);
                $a["nom"] = $etudiant["nom"];
                $a["prenom"] = $etudiant["prenom"];
                $a["cne"] = $etudiant["cne"];
                $a["email"] = $etudiant["email"];

                $absences [] = $a;

            }

        }

        return $absences;
    }

    return $absences;

}

function listAbsences()
{

    $absences_ = $absences =  [];

    $db = database();

    $sttm = $db->prepare("SELECT * FROM absence where is_old=0");

    if($sttm->execute())
    {
        $absences_ = $sttm->fetchAll();

        foreach ($absences_ as $a)
        {
            $sttm2 = $db->prepare("SELECT * FROM etudiant where id=:id");
            $sttm2->bindParam(":id", $a["id_etudiant"]);

            if($sttm2->execute())
            {

                $etudiant = $sttm2->fetch(PDO::FETCH_ASSOC);
                $a["nom"] = $etudiant["nom"];
                $a["prenom"] = $etudiant["prenom"];
                $a["cne"] = $etudiant["cne"];
                $a["email"] = $etudiant["email"];

                $absences [] = $a;


            }

        }

        return $absences;
    }

    return $absences;

}


function listAbsencesOld()
{

    $absences_ = $absences =  [];

    $db = database();

    $sttm = $db->prepare("SELECT * FROM absence where is_old=1");

    if($sttm->execute())
    {
        $absences_ = $sttm->fetchAll();

        foreach ($absences_ as $a)
        {
            $sttm2 = $db->prepare("SELECT * FROM etudiant where id=:id");
            $sttm2->bindParam(":id", $a["id_etudiant"]);

            if($sttm2->execute())
            {

                $etudiant = $sttm2->fetch(PDO::FETCH_ASSOC);
                $a["nom"] = $etudiant["nom"];
                $a["prenom"] = $etudiant["prenom"];
                $a["cne"] = $etudiant["cne"];
                $a["email"] = $etudiant["email"];

                $absences [] = $a;


            }

        }

        return $absences;
    }

    return $absences;

}

/* Cette fonction permet de calculer le nombre des absences pour chaque étudiant */

function alertsAbsence()
{
    /* Tableau */
    $alerts = [];

    $db = database();

    $sttm = $db->prepare("SELECT count(a.id), a.id_etudiant, a.is_old, e.nom, e.prenom FROM absence a LEFT JOIN etudiant e on a.id_etudiant = e.id where a.is_old=0 and a.type_absence='Absence non-justifiée' GROUP BY a.id_etudiant");

    if($sttm->execute()){

        $alerts = $sttm->fetchAll();
        return $alerts;

    }

    return $alerts;


}


function remettreZeroAbsences()
{

    $db = database();

    $sttm = $db->prepare("UPDATE absence set is_old=1");
    if($sttm->execute())
    {
        return true;
    }else{
        return false;
    }

}

function listerAbsencesParProf()
{

    /*
    on initialise 2 tableau absences, '_' c'est le tableau temporaire
     */

    $absences_ = $absences =  [];

    $db = database();

    $sttm = $db->prepare("SELECT * FROM absence where professeur=:id and is_old=0");
    $sttm->bindParam(":id", $_SESSION["id"]);

    if($sttm->execute())
    {
        $absences_ = $sttm->fetchAll();

        foreach ($absences_ as $a)
        {
            $sttm2 = $db->prepare("SELECT * FROM etudiant where id=:id");
            $sttm2->bindParam(":id", $a["id_etudiant"]);

            if($sttm2->execute())
            {

                $etudiant = $sttm2->fetch(PDO::FETCH_ASSOC);
                $a["nom"] = $etudiant["nom"];
                $a["prenom"] = $etudiant["prenom"];
                $a["cne"] = $etudiant["cne"];
                $a["email"] = $etudiant["email"];

                $absences [] = $a;


            }

        }

        return $absences;
    }

    return $absences;


}


function deleteAbsence($id)
{

    $db = database();

    $sttm = $db->prepare("UPDATE absence SET is_old=1 where id=:id");
    $sttm->bindParam(":id", $id);

    if($sttm->execute())
    {
        return true;
    }else{
        return false;
    }

}

