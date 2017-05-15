<?php


class Utilisateur extends Db
{

    private $login, $password, $type, $active;

    /**
     * Utilisateur constructor.
     * @param $login
     * @param $password
     */
    public function __construct($login = null, $password = null, $type = null)
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
                return true;
            }else{
                return false;
            }
        }

    }

    public function inscription(){

        $sttm = $this->db->prepare("INSERT INTO utilisateur (login, password) VALUE (:login, :password)");
        $sttm->bindParam(':login', $this->login);
        $sttm->bindParam(':password', $this->password);

        $sttm->execute();
        return true;

    }


}