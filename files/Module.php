<?php

class Module extends Db{


    private $id, $nom, $nature, $enseigne_par;

    /**
     * Module constructor.
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
    public function getNature()
    {
        return $this->nature;
    }

    /**
     * @param mixed $nature
     */
    public function setNature($nature)
    {
        $this->nature = $nature;
    }

    /**
     * @return mixed
     */
    public function getEnseignePar()
    {
        return $this->enseigne_par;
    }

    /**
     * @param mixed $enseigne_par
     */
    public function setEnseignePar($enseigne_par)
    {
        $this->enseigne_par = $enseigne_par;
    }




}