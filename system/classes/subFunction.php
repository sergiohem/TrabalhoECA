<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 26/05/2018
 * Time: 01:16
 */

class subFunction
{
    private $idSubFunction;
    private $codeSubFunction;
    private $nameSubFunction;

    /**
     * subFunction constructor.
     * @param $idSubFunction
     * @param $codeSubFunction
     * @param $nameSubFunction
     */
    public function __construct($idSubFunction, $codeSubFunction, $nameSubFunction)
    {
        $this->idSubFunction = $idSubFunction;
        $this->codeSubFunction = $codeSubFunction;
        $this->nameSubFunction = $nameSubFunction;
    }

    /**
     * @return mixed
     */
    public function getIdSubFunction()
    {
        return $this->idSubFunction;
    }

    /**
     * @param mixed $idSubFunction
     */
    public function setIdSubFunction($idSubFunction): void
    {
        $this->idSubFunction = $idSubFunction;
    }

    /**
     * @return mixed
     */
    public function getCodeSubFunction()
    {
        return $this->codeSubFunction;
    }

    /**
     * @param mixed $codeSubFunction
     */
    public function setCodeSubFunction($codeSubFunction): void
    {
        $this->codeSubFunction = $codeSubFunction;
    }

    /**
     * @return mixed
     */
    public function getNameSubFunction()
    {
        return $this->nameSubFunction;
    }

    /**
     * @param mixed $nameSubFunction
     */
    public function setNameSubFunction($nameSubFunction): void
    {
        $this->nameSubFunction = $nameSubFunction;
    }

}