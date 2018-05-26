<?php
/**
 * Created by PhpStorm.
 * User: lucas 3
 * Date: 26/05/2018
 * Time: 15:29
 */

class city
{
    private $idCity;
    private $nameCity;
    private $codSiafiCity;
    private $cityState;

    /**
     * city constructor.
     * @param $idCity
     * @param $nameCity
     * @param $codSiafiCity
     * @param $cityState
     */
    public function __construct($idCity, $nameCity, $codSiafiCity, $cityState)
    {
        $this->idCity = $idCity;
        $this->nameCity = $nameCity;
        $this->codSiafiCity = $codSiafiCity;
        $this->cityState = $cityState;
    }

    /**
     * @return mixed
     */
    public function getIdCity()
    {
        return $this->idCity;
    }

    /**
     * @param mixed $idCity
     */
    public function setIdCity($idCity): void
    {
        $this->idCity = $idCity;
    }

    /**
     * @return mixed
     */
    public function getNameCity()
    {
        return $this->nameCity;
    }

    /**
     * @param mixed $nameCity
     */
    public function setNameCity($nameCity): void
    {
        $this->nameCity = $nameCity;
    }

    /**
     * @return mixed
     */
    public function getCodSiafiCity()
    {
        return $this->codSiafiCity;
    }

    /**
     * @param mixed $codSiafiCity
     */
    public function setCodSiafiCity($codSiafiCity): void
    {
        $this->codSiafiCity = $codSiafiCity;
    }

    /**
     * @return mixed
     */
    public function getCityState()
    {
        return $this->cityState;
    }

    /**
     * @param mixed $cityState
     */
    public function setCityState($cityState): void
    {
        $this->cityState = $cityState;
    }



}