<?php

/* Connexion */

if(isset($_POST["connexion"])){

    if(!empty($_POST["username"]) && !empty($_POST["password"])){

        require "Utilisateur.php";
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

    require "Utilisateur.php";
    if( !empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["type"]))
    {

        $utilisteur = new Utilisateur(
            $_POST["username"], $_POST["password"], $_POST["type"]
        );

        if($utilisteur->inscription())
        {
            $_SESSION["message"] = "Vous êtes maintenant inscrit ! merci de se connecter utilisant votre username et mot de passe";
            header("Location: login.php");
            exit();
        }

    }

}
