<?php


class Absence extends Db
{

    private $id, $etudiant, $crn_horaire, $type_absence, $is_old;
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







}