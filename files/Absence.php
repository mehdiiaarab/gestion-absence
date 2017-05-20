<?php


class Absence extends Db
{

    private $id, $etudiant, $crn_horaire, $type_absence, $is_old, $professeur, $module, $date_absence;
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
    public function getDateAbsence()
    {
        return $this->date_absence;
    }

    /**
     * @param mixed $date_absence
     */
    public function setDateAbsence($date_absence)
    {
        $this->date_absence = $date_absence;
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
        $sttm = $this->db->prepare("INSERT INTO absence (id_etudiant, crn_horaire, type_absence, module, professeur, date_absence) VALUE (:id_etudiant, :crn_horaire, :type_absence, :module, :professeur, :date_absence)");

        $sttm->bindParam(':id_etudiant', $this->etudiant);
        $sttm->bindParam(':crn_horaire', $this->crn_horaire);
        $sttm->bindParam(':type_absence', $this->type_absence);
        $sttm->bindParam(':module', $this->module);
        $sttm->bindParam(':professeur', $this->professeur);
        $sttm->bindParam(':date_absence', $this->date_absence);


        if($sttm->execute())
        {
            return true;
        }

        return false;


    }


    public function listerAbsencesParProf()
    {

        /*
        on initialise 2 tableau absences, '_' c'est le tableau temporaire
         */

        $absences_ = $absences =  [];

        $sttm = $this->db->prepare("SELECT * FROM absence where professeur=:id and is_old=0");
        $sttm->bindParam(":id", $_SESSION["id"]);

        if($sttm->execute())
        {
            $absences_ = $sttm->fetchAll();

            foreach ($absences_ as $a)
            {
                $sttm2 = $this->db->prepare("SELECT * FROM etudiant where id=:id");
                $sttm2->bindParam(":id", $a["id_etudiant"]);

                if($sttm2->execute())
                {

                    $etudiant = $sttm2->fetch(PDO::FETCH_ASSOC);
                    $a["nom"] = $etudiant["nom"];
                    $a["prenom"] = $etudiant["prenom"];
                    $a["cne"] = $etudiant["cne"];
                    $a["email"] = $etudiant["email"];

                    $absences [] = $a;


                }

            }

            return $absences;
        }

        return $absences;


    }

    public function deleteAbsence($id)
    {
        $sttm = $this->db->prepare("UPDATE absence SET is_old=1 where id=:id");
        $sttm->bindParam(":id", $id);

        if($sttm->execute())
        {
            return true;
        }else{
            return false;
        }

    }

    public function listAbsences()
    {

        $absences_ = $absences =  [];

        $sttm = $this->db->prepare("SELECT * FROM absence where is_old=0");

        if($sttm->execute())
        {
            $absences_ = $sttm->fetchAll();

            foreach ($absences_ as $a)
            {
                $sttm2 = $this->db->prepare("SELECT * FROM etudiant where id=:id");
                $sttm2->bindParam(":id", $a["id_etudiant"]);

                if($sttm2->execute())
                {

                    $etudiant = $sttm2->fetch(PDO::FETCH_ASSOC);
                    $a["nom"] = $etudiant["nom"];
                    $a["prenom"] = $etudiant["prenom"];
                    $a["cne"] = $etudiant["cne"];
                    $a["email"] = $etudiant["email"];

                    $absences [] = $a;


                }

            }

            return $absences;
        }

        return $absences;

    }


    public function listAbsenceParEtudiant($id)
    {

        $absences_ = $absences =  [];

        $sttm = $this->db->prepare("SELECT * FROM absence where id_etudiant=:id and is_old=0");
        $sttm->bindParam(":id", $id);

        if($sttm->execute())
        {
            $absences_ = $sttm->fetchAll();

            foreach ($absences_ as $a)
            {
                $sttm2 = $this->db->prepare("SELECT * FROM etudiant where id=:id");
                $sttm2->bindParam(":id", $a["id_etudiant"]);

                if($sttm2->execute())
                {

                    $etudiant = $sttm2->fetch(PDO::FETCH_ASSOC);
                    $a["nom"] = $etudiant["nom"];
                    $a["prenom"] = $etudiant["prenom"];
                    $a["cne"] = $etudiant["cne"];
                    $a["email"] = $etudiant["email"];

                    $absences [] = $a;


                }

            }

            return $absences;
        }

        return $absences;

    }

    public function listAbsencesOld()
    {

        $absences_ = $absences =  [];

        $sttm = $this->db->prepare("SELECT * FROM absence where is_old=1");

        if($sttm->execute())
        {
            $absences_ = $sttm->fetchAll();

            foreach ($absences_ as $a)
            {
                $sttm2 = $this->db->prepare("SELECT * FROM etudiant where id=:id");
                $sttm2->bindParam(":id", $a["id_etudiant"]);

                if($sttm2->execute())
                {

                    $etudiant = $sttm2->fetch(PDO::FETCH_ASSOC);
                    $a["nom"] = $etudiant["nom"];
                    $a["prenom"] = $etudiant["prenom"];
                    $a["cne"] = $etudiant["cne"];
                    $a["email"] = $etudiant["email"];

                    $absences [] = $a;


                }

            }

            return $absences;
        }

        return $absences;

    }


    public function alertsAbsence()
    {
        /* Tableau */
        $alerts = [];

        $sttm = $this->db->prepare("SELECT count(a.id), a.id_etudiant, a.is_old, e.nom, e.prenom FROM absence a LEFT JOIN etudiant e on a.id_etudiant = e.id where a.is_old=0 and a.type_absence='Absence non-justifiée' GROUP BY a.id_etudiant");

        if($sttm->execute()){

            $alerts = $sttm->fetchAll();
            return $alerts;

        }

        return $alerts;


    }

}