<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;

class User extends BaseUser{

    /**
     * @ORM\Column(type="integer")
     * ORM\GeneratedValue(strategy="AUTO")
     * ORM\Id
     */
    private $userId;

    /**
     * @ORM\Column(type="string", unique=true)
     * Assert\NotBlank
     */
    private $login;

    /**
     * @return mixed
     */
    public function getLogin() {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login) {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getRoles() {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles(array $roles) {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId) {
        $this->userId = $userId;
    }

    /**
     * @ORM\Column(type="string", unique=true)
     * Assert\Email
     */
    protected $email;

    /**
     * @ORM\Column(type"string")
     * Assert\NotBlank
     */
    protected $password;

    /**
     * @ORM\Column(type="json_array")
     */
    protected $roles = [];

}