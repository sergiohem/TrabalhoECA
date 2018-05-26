<?php
/**
 * Created by PhpStorm.
 * User: aluno
 * Date: 24/05/2018
 * Time: 19:49
 */

class region
{
    private $idRegion;
    private $nameRegion;

    /**
     * region constructor.
     * @param $idRegion
     * @param $nameRegion
     */
    public function __construct($idRegion, $nameRegion)
    {
        $this->idRegion = $idRegion;
        $this->nameRegion = $nameRegion;
    }

    /**
     * @return mixed
     */
    public function getIdRegion()
    {
        return $this->idRegion;
    }

    /**
     * @param mixed $idRegion
     */
    public function setIdRegion($idRegion): void
    {
        $this->idRegion = $idRegion;
    }

    /**
     * @return mixed
     */
    public function getNameRegion()
    {
        return $this->nameRegion;
    }

    /**
     * @param mixed $nameRegion
     */
    public function setNameRegion($nameRegion): void
    {
        $this->nameRegion = $nameRegion;
    }
}