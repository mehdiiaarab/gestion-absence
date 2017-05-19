<?php

class Etudiant extends Db {

    private $id, $id_user, $cin, $nom, $cne, $prenom, $date_naissance, $adresse, $lieu_naissance, $telephone, $email;

    /**
     * Etudiant constructor.
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
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * @param mixed $cin
     */
    public function setCin($cin)
    {
        $this->cin = $cin;
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
    public function getCne()
    {
        return $this->cne;
    }

    /**
     * @param mixed $cne
     */
    public function setCne($cne)
    {
        $this->cne = $cne;
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
    public function getDateNaissance()
    {
        return $this->date_naissance;
    }

    /**
     * @param mixed $date_naissance
     */
    public function setDateNaissance($date_naissance)
    {
        $this->date_naissance = $date_naissance;
    }

    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return mixed
     */
    public function getLieuNaissance()
    {
        return $this->lieu_naissance;
    }

    /**
     * @param mixed $lieu_naissance
     */
    public function setLieuNaissance($lieu_naissance)
    {
        $this->lieu_naissance = $lieu_naissance;
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


    public function listEtudiants()
    {

        $students = [];

        $sttm = $this->db->prepare("SELECT e.id, e.nom, e.prenom, e.email, e.cne, e.date_naissance, e.telephone, e.email FROM etudiant e LEFT JOIN module m on m.enseigne_par=:id_enseignant");
        $sttm->bindParam(':id_enseignant', $_SESSION["id"]);
        if($sttm->execute())
        {
            $students = $sttm->fetchAll();
            return $students;
        }

        return $students;
    }

    public function toutEtudiants(){
        $students = [];

        $sttm = $this->db->prepare("SELECT * FROM etudiant");
        if($sttm->execute())
        {
            $students = $sttm->fetchAll();
            return $students;
        }

        return $students;
    }

    public function signup()
    {

        $sttm = $this->db->prepare("INSERT INTO etudiant (id_user, cin, nom, cne, prenom, date_naissance, adresse, lieu_naissance, telephone, email) VALUE (:id_user, :cin, :nom, :cne, :prenom, :date_naissance, :adresse, :lieu_naissance, :telephone, :email)");

        $sttm->bindParam(':id_user', $this->id_user);
        $sttm->bindParam(':cin', $this->cin);
        $sttm->bindParam(':nom', $this->nom);
        $sttm->bindParam(':cne', $this->cne);
        $sttm->bindParam(':prenom', $this->prenom);
        $sttm->bindParam(':date_naissance', $this->date_naissance);
        $sttm->bindParam(':adresse', $this->adresse);
        $sttm->bindParam(':lieu_naissance', $this->lieu_naissance);
        $sttm->bindParam(':telephone', $this->telephone);
        $sttm->bindParam(':email', $this->email);

        if($sttm->execute())
        {
            return true;
        }

        return false;

    }

    public function getEtudiant($id)
    {
        $student = "";

        $sttm = $this->db->prepare("SELECT * FROM etudiant where id=:id");
        $sttm->bindParam(':id', $id);
        if($sttm->execute())
        {
            $student = $sttm->fetch(PDO::FETCH_ASSOC);
            return $student;
        }

        return $student;
    }


    public function calculerAbsences($id)
    {

        $nombreAbsences = 0;

        $sttm = $this->db->prepare("SELECT count(id_etudiant) FROM absence where id_etudiant=:id and is_old=0 ");
        $sttm->bindParam(':id', $id);
        if($sttm->execute())
        {
            $nombreAbsences = $sttm->fetch(PDO::FETCH_ASSOC);
            return $nombreAbsences;
        }

        return $nombreAbsences;
    }


}