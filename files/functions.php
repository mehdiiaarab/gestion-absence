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
            $_SESSION["message"] = "Mot de pass / Email Invalid !";
        }

    }

}


/* Inscription */
if(isset($_POST['signup']))
{

    require "Utilisateur.php";
    if( !empty($_POST["username"]) && !empty($_POST["password"]))
    {

        $utilisteur = new Utilisateur(
            $_POST["username"], $_POST["password"]
        );

        if ($utilisteur->inscription()){
            $_SESSION["message"] = "vous êtes maintenant inscrit !";
            header("Location: login.php");
            exit();
        }

    }

}
