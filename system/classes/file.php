<?php
/**
 * Created by PhpStorm.
 * User: lucas 3
 * Date: 25/05/2018
 * Time: 17:24
 */

class file
{
    private $idFile;
    private $nameFile;
    private $month;
    private $year;

    /**
     * file constructor.
     * @param $idFile
     * @param $nameFile
     * @param $month
     * @param $year
     */
    public function __construct($idFile, $nameFile, $month, $year)
    {
        $this->idFile = $idFile;
        $this->nameFile = $nameFile;
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getIdFile()
    {
        return $this->idFile;
    }

    /**
     * @param mixed $idFile
     */
    public function setIdFile($idFile): void
    {
        $this->idFile = $idFile;
    }

    /**
     * @return mixed
     */
    public function getNameFile()
    {
        return $this->nameFile;
    }

    /**
     * @param mixed $nameFile
     */
    public function setNameFile($nameFile): void
    {
        $this->nameFile = $nameFile;
    }

    /**
     * @return mixed
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param mixed $month
     */
    public function setMonth($month): void
    {
        $this->month = $month;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year): void
    {
        $this->year = $year;
    }


}