<?php


class Professeur extends Db {

    private $id, $id_user, $som, $nom, $prenom, $email, $telephone;

    /**
     * Professeur constructor.
     */
    public function __construct()
    {
        parent::__construct();
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

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    /**
     * @return mixed
     */
    public function getSom()
    {
        return $this->som;
    }

    /**
     * @param mixed $som
     */
    public function setSom($som)
    {
        $this->som = $som;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    public function signup(){

        $sttm = $this->db->prepare("INSERT INTO professeur (id_user, som, nom, prenom, email, telephone) VALUE (:id_user, :som, :nom, :prenom, :email, :telephone)");

        $sttm->bindParam(':id_user', $this->id_user);
        $sttm->bindParam(':som', $this->som);
        $sttm->bindParam(':nom', $this->nom);
        $sttm->bindParam(':prenom', $this->prenom);
        $sttm->bindParam(':telephone', $this->telephone);
        $sttm->bindParam(':email', $this->email);

        if($sttm->execute())
        {
            return true;
        }

        return false;
    }

    public function exists($email){

    }
}