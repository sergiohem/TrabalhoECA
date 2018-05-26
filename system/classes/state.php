<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 26/05/2018
 * Time: 00:46
 */

class state
{
    private $idState;
    private $uf;
    private $nameState;
    private $regionState;

    /**
     * state constructor.
     * @param $idState
     * @param $uf
     * @param $nameState
     * @param $regionState
     */
    public function __construct($idState, $uf, $nameState, $regionState)
    {
        $this->idState = $idState;
        $this->uf = $uf;
        $this->nameState = $nameState;
        $this->regionState = $regionState;
    }

    /**
     * @return mixed
     */
    public function getIdState()
    {
        return $this->idState;
    }

    /**
     * @param mixed $idState
     */
    public function setIdState($idState): void
    {
        $this->idState = $idState;
    }

    /**
     * @return mixed
     */
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * @param mixed $uf
     */
    public function setUf($uf): void
    {
        $this->uf = $uf;
    }

    /**
     * @return mixed
     */
    public function getNameState()
    {
        return $this->nameState;
    }

    /**
     * @param mixed $nameState
     */
    public function setNameState($nameState): void
    {
        $this->nameState = $nameState;
    }

    /**
     * @return mixed
     */
    public function getRegionState()
    {
        return $this->regionState;
    }

    /**
     * @param mixed $regionState
     */
    public function setRegionState($regionState): void
    {
        $this->regionState = $regionState;
    }
}