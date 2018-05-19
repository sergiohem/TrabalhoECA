<?php
/**
 * Created by PhpStorm.
 * User: aluno
 * Date: 16/03/2018
 * Time: 21:17
 */

class action
{
    private $idAction;
    private $code;
    private $name;

    public function __construct($idAction, $code, $name)
    {
        $this->idAction = $idAction;
        $this->code = $code;
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getIdAction()
    {
        return $this->idAction;
    }

    /**
     * @param mixed $idAction
     */
    public function setIdAction($idAction): void
    {
        $this->idAction = $idAction;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }
}
