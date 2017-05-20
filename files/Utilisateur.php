<?php


class Utilisateur extends Db
{

    private $login, $password, $type, $active, $id;

    /**
     * Utilisateur constructor.
     * @param $login
     * @param $password
     */
    public function __construct($login = null, $password = null, $type = "etudiant")
    {
        parent::__construct();
        $this->login = $login;
        $this->password = $password;
        $this->type = $type;
        $this->active = 0;
    }


    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return int
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param int $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }



    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param null $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }



    public function connexion()
    {

        $sttm = $this->db->prepare("SELECT * FROM utilisateur WHERE login = :login AND password = :password");
        $sttm->bindParam(':login', $this->login);
        $sttm->bindParam(':password', $this->password);
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
                        $sttm2 = $this->db->prepare("SELECT * FROM professeur WHERE id_user = :id");
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
                        $sttm2 = $this->db->prepare("SELECT * FROM etudiant WHERE id_user = :id");
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

    }

    public function exists($email){
        $sttm = $this->db->prepare("SELECT * FROM (
            SELECT utilisateur.login from utilisateur
            union all
            SELECT email FROM professeur
            union all
            SELECT email FROM etudiant) utilisateur, professeur, etudiant
            WHERE login = :login or professeur.email = :email or etudiant.email=:email");
        $sttm->bindParam(':login', $this->login);
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


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }



    public function inscription(){

        $sttm = $this->db->prepare("INSERT INTO utilisateur (login, password, type) VALUE (:login, :password, :type)");
        $sttm->bindParam(':login', $this->login);
        $sttm->bindParam(':password', $this->password);
        $sttm->bindParam(':type', $this->type);

        $sttm->execute();

        $this->id = $this->db->lastInsertId();


        return true;

    }


}