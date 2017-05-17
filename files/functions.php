<?php

spl_autoload_register(function ($class_name) {
    require_once $class_name . '.php';
});


/* Connexion */

if(isset($_POST["connexion"])){

    if(!empty($_POST["username"]) && !empty($_POST["password"])){


        $utilisteur = new Utilisateur();
        extract($_POST);
        $utilisteur->setLogin($username);
        $utilisteur->setPassword($password);
        if($utilisteur->connexion()){
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


        if($utilisteur->inscription())
        {

            if($_POST["type"] == "etudiant"){

                $etudiant = new Etudiant();
                $etudiant->setNom($_POST["nom"]);
                $etudiant->setPrenom($_POST["prenom"]);
                $etudiant->setCin($_POST["cin"]);
                $etudiant->setCne($_POST["cne"]);
                $etudiant->setDateNaissance($_POST["date_naissance"]);
                $etudiant->setEmail($_POST["email"]);
                $etudiant->setLieuNaissance($_POST["lieu_naissance"]);
                $etudiant->setAdresse($_POST["adresse"]);
                $etudiant->setTelephone($_POST["telephone"]);
                $etudiant->setIdUser($utilisteur->getId());



                if($etudiant->signup()){
                    $_SESSION["message"] = "Vous êtes maintenant inscrit ! merci de se connecter utilisant votre username et mot de passe";
                    header("Location: login.php");
                    exit();
                }


            }elseif($_POST["type"] == "professeur" ){

                /* same thing for professeur */
                $professeur = new Professeur();


                if($professeur->signup()){
                    $_SESSION["message"] = "Vous êtes maintenant inscrit ! merci de se connecter utilisant votre username et mot de passe";
                    header("Location: login.php");
                    exit();
                }


            }



        }else{

            $_SESSION["message"] = "Erreur lors de votre action, veuillez réessayer.";

        }

    }else{
        $_SESSION["message"] = "Vous avez laisser des champs vides !";
    }

}
