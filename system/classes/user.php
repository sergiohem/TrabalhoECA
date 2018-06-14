<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 08/06/2018
 * Time: 22:49
 */

class user
{
    private $idUser;
    private $name;
    private $username;
    private $password;
    private $type;
    private $email;
    private $recPassword;

    /**
     * user constructor.
     * @param $idUser
     * @param $name
     * @param $username
     * @param $password
     * @param $type
     * @param $email
     * @param $recPassword
     */
    public function __construct($idUser, $name, $username, $password, $type, $email, $recPassword)
    {
        $this->idUser = $idUser;
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->type = $type;
        $this->email = $email;
        $this->recPassword = $recPassword;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser): void
    {
        $this->idUser = $idUser;
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

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getRecPassword()
    {
        return $this->recPassword;
    }

    /**
     * @param mixed $recPassword
     */
    public function setRecPassword($recPassword): void
    {
        $this->recPassword = $recPassword;
    }

}