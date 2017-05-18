<?php


class Absence extends Db
{

    private $id, $etudiant, $crn_horaire, $type_absence, $is_old, $professeur, $module;
    /**
     * Utilisateur constructor.
     * @param $login
     * @param $password
     */
    public function __construct()
    {
        parent::__construct();
        $this->is_old = 0;
    }

    /**
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param mixed $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }




    /**
     * @return mixed
     */
    public function getEtudiant()
    {
        return $this->etudiant;
    }

    /**
     * @param mixed $etudiant
     */
    public function setEtudiant($etudiant)
    {
        $this->etudiant = $etudiant;
    }

    /**
     * @return mixed
     */
    public function getCrnHoraire()
    {
        return $this->crn_horaire;
    }

    /**
     * @param mixed $crn_horaire
     */
    public function setCrnHoraire($crn_horaire)
    {
        $this->crn_horaire = $crn_horaire;
    }

    /**
     * @return mixed
     */
    public function getTypeAbsence()
    {
        return $this->type_absence;
    }

    /**
     * @param mixed $type_absence
     */
    public function setTypeAbsence($type_absence)
    {
        $this->type_absence = $type_absence;
    }

    /**
     * @return int
     */
    public function getIsOld()
    {
        return $this->is_old;
    }

    /**
     * @param int $is_old
     */
    public function setIsOld($is_old)
    {
        $this->is_old = $is_old;
    }

    /**
     * @return mixed
     */
    public function getProfesseur()
    {
        return $this->professeur;
    }

    /**
     * @param mixed $professeur
     */
    public function setProfesseur($professeur)
    {
        $this->professeur = $professeur;
    }

    public function marquerAbsence()
    {
        $sttm = $this->db->prepare("INSERT INTO absence (id_etudiant, crn_horaire, type_absence, module, professeur) VALUE (:id_etudiant, :crn_horaire, :type_absence, :module, :professeur)");

        $sttm->bindParam(':id_etudiant', $this->etudiant);
        $sttm->bindParam(':crn_horaire', $this->crn_horaire);
        $sttm->bindParam(':type_absence', $this->type_absence);
        $sttm->bindParam(':module', $this->module);
        $sttm->bindParam(':professeur', $this->professeur);


        if($sttm->execute())
        {
            return true;
        }

        return false;


    }


}