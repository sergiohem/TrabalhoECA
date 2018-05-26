<?php
/**
 * Created by PhpStorm.
 * User: aluno
 * Date: 24/05/2018
 * Time: 20:25
 */

class program
{
    private $idProgram;
    private $codeProgram;
    private $nameProgram;

    /**
     * program constructor.
     * @param $idProgram
     * @param $codeProgram
     * @param $nameProgram
     */
    public function __construct($idProgram, $codeProgram, $nameProgram)
    {
        $this->idProgram = $idProgram;
        $this->codeProgram = $codeProgram;
        $this->nameProgram = $nameProgram;
    }

    /**
     * @return mixed
     */
    public function getIdProgram()
    {
        return $this->idProgram;
    }

    /**
     * @param mixed $idProgram
     */
    public function setIdProgram($idProgram): void
    {
        $this->idProgram = $idProgram;
    }

    /**
     * @return mixed
     */
    public function getCodeProgram()
    {
        return $this->codeProgram;
    }

    /**
     * @param mixed $codeProgram
     */
    public function setCodeProgram($codeProgram): void
    {
        $this->codeProgram = $codeProgram;
    }

    /**
     * @return mixed
     */
    public function getNameProgram()
    {
        return $this->nameProgram;
    }

    /**
     * @param mixed $nameProgram
     */
    public function setNameProgram($nameProgram): void
    {
        $this->nameProgram = $nameProgram;
    }

    
}