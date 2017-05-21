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




/* Marquer l'absence */

if(isset($_POST["marquer-absence"]))
{

    if(!empty($_POST["module"]) && !empty($_POST["date_absence"])
        && !empty($_POST["crn_horaire"]) && !empty($_POST["type_absence"]) ){

        $absence = new Absence();
        $absence->setEtudiant($_POST["id"]);
        $absence->setTypeAbsence($_POST["type_absence"]);
        $absence->setCrnHoraire($_POST["crn_horaire"]);
        $absence->setProfesseur($_SESSION["id"]);
        $absence->setModule($_POST["module"]);
        $absence->setDateAbsence($_POST["date_absence"]);

        if($absence->marquerAbsence()){

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
