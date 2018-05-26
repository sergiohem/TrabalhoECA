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
    private $codeAction;
    private $nameAction;

    public function __construct($idAction, $codeAction, $nameAction)
    {
        $this->idAction = $idAction;
        $this->codeAction = $codeAction;
        $this->nameAction = $nameAction;
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
    public function getCodeAction()
    {
        return $this->codeAction;
    }

    /**
     * @param mixed $codeAction
     */
    public function setCodeAction($codeAction): void
    {
        $this->codeAction = $codeAction;
    }

    /**
     * @return mixed
     */
    public function getNameAction()
    {
        return $this->nameAction;
    }

    /**
     * @param mixed $nameAction
     */
    public function setNameAction($nameAction): void
    {
        $this->nameAction = $nameAction;
    }


}
