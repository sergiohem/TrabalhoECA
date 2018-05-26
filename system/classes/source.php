<?php
/**
 * Created by PhpStorm.
 * User: aluno
 * Date: 24/05/2018
 * Time: 20:28
 */

class source
{
    private $idSource;
    private $goal;
    private $origin;
    private $periodicity;

    /**
     * source constructor.
     * @param $idSource
     * @param $goal
     * @param $origin
     * @param $periodicity
     */
    public function __construct($idSource, $goal, $origin, $periodicity)
    {
        $this->idSource = $idSource;
        $this->goal = $goal;
        $this->origin = $origin;
        $this->periodicity = $periodicity;
    }

    /**
     * @return mixed
     */
    public function getIdSource()
    {
        return $this->idSource;
    }

    /**
     * @param mixed $idSource
     */
    public function setIdSource($idSource): void
    {
        $this->idSource = $idSource;
    }

    /**
     * @return mixed
     */
    public function getGoal()
    {
        return $this->goal;
    }

    /**
     * @param mixed $goal
     */
    public function setGoal($goal): void
    {
        $this->goal = $goal;
    }

    /**
     * @return mixed
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param mixed $origin
     */
    public function setOrigin($origin): void
    {
        $this->origin = $origin;
    }

    /**
     * @return mixed
     */
    public function getPeriodicity()
    {
        return $this->periodicity;
    }

    /**
     * @param mixed $periodicity
     */
    public function setPeriodicity($periodicity): void
    {
        $this->periodicity = $periodicity;
    }

}