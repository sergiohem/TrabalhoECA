<?php
/**
 * Created by PhpStorm.
 * User: lucas 3
 * Date: 25/05/2018
 * Time: 15:04
 */

class functions
{
    private $idFunction;
    private $codeFunction;
    private $nameFunction;

    /**
     * functions constructor.
     * @param $idFunction
     * @param $codeFunction
     * @param $nameFunction
     */
    public function __construct($idFunction, $codeFunction, $nameFunction)
    {
        $this->idFunction = $idFunction;
        $this->codeFunction = $codeFunction;
        $this->nameFunction = $nameFunction;
    }

    /**
     * @return mixed
     */
    public function getIdFunction()
    {
        return $this->idFunction;
    }

    /**
     * @param mixed $idFuntion
     */
    public function setIdFunction($idFunction): void
    {
        $this->idFunction = $idFunction;
    }

    /**
     * @return mixed
     */
    public function getCodeFunction()
    {
        return $this->codeFunction;
    }

    /**
     * @param mixed $codeFunction
     */
    public function setCodeFunction($codeFunction): void
    {
        $this->codeFunction = $codeFunction;
    }

    /**
     * @return mixed
     */
    public function getNameFunction()
    {
        return $this->nameFunction;
    }

    /**
     * @param mixed $nameFunction
     */
    public function setNameFunction($nameFunction): void
    {
        $this->nameFunction = $nameFunction;
    }

}