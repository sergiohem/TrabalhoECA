<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 26/05/2018
 * Time: 19:54
 */

class payment
{
    private $idPayment;
    private $city;
    private $function;
    private $subfunction;
    private $program;
    private $action;
    private $beneficiary;
    private $source;
    private $file;
    private $value;
    private $month;
    private $year;

    /**
     * payment constructor.
     * @param $idPayment
     * @param $city
     * @param $function
     * @param $subfunction
     * @param $program
     * @param $action
     * @param $beneficiary
     * @param $source
     * @param $file
     * @param $value
     * @param $month
     * @param $year
     */
    public function __construct($idPayment, $city, $function, $subfunction, $program, $action, $beneficiary, $source, $file, $value, $month, $year)
    {
        $this->idPayment = $idPayment;
        $this->city = $city;
        $this->function = $function;
        $this->subfunction = $subfunction;
        $this->program = $program;
        $this->action = $action;
        $this->beneficiary = $beneficiary;
        $this->source = $source;
        $this->file = $file;
        $this->value = $value;
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getIdPayment()
    {
        return $this->idPayment;
    }

    /**
     * @param mixed $idPayment
     */
    public function setIdPayment($idPayment): void
    {
        $this->idPayment = $idPayment;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getFunction()
    {
        return $this->function;
    }

    /**
     * @param mixed $function
     */
    public function setFunction($function): void
    {
        $this->function = $function;
    }

    /**
     * @return mixed
     */
    public function getSubfunction()
    {
        return $this->subfunction;
    }

    /**
     * @param mixed $subfunction
     */
    public function setSubfunction($subfunction): void
    {
        $this->subfunction = $subfunction;
    }

    /**
     * @return mixed
     */
    public function getProgram()
    {
        return $this->program;
    }

    /**
     * @param mixed $program
     */
    public function setProgram($program): void
    {
        $this->program = $program;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action): void
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getBeneficiary()
    {
        return $this->beneficiary;
    }

    /**
     * @param mixed $beneficiary
     */
    public function setBeneficiary($beneficiary): void
    {
        $this->beneficiary = $beneficiary;
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param mixed $source
     */
    public function setSource($source): void
    {
        $this->source = $source;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
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