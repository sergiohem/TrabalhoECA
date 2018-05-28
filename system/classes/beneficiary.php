<?php
/**
 * Created by PhpStorm.
 * User: lucas 3
 * Date: 25/05/2018
 * Time: 14:09
 */

class beneficiary
{
    private $idBeneficiary;
    private $nis;
    private $namePerson;



    /**
     * beneficiary constructor.
     * @param $idBeneficiary
     * @param $nis
     * @param $namePerson
     */
    public function __construct($idBeneficiary, $nis, $namePerson)
    {
        $this->idBeneficiary = $idBeneficiary;
        $this->nis = $nis;
        $this->namePerson = $namePerson;
    }

    /**
     * @return mixed
     */
    public function getIdBeneficiary()
    {
        return $this->idBeneficiary;
    }

    /**
     * @param mixed $idBeneficiary
     */
    public function setIdBeneficiary($idBeneficiary): void
    {
        $this->idBeneficiary = $idBeneficiary;
    }

    /**
     * @return mixed
     */
    public function getNis()
    {
        return $this->nis;
    }

    /**
     * @param mixed $nis
     */
    public function setNis($nis): void
    {
        $this->nis = $nis;
    }

    /**
     * @return mixed
     */
    public function getNamePerson()
    {
        return $this->namePerson;
    }

    /**
     * @param mixed $namePerson
     */
    public function setNamePerson($namePerson): void
    {
        $this->namePerson = $namePerson;
    }



}