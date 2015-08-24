<?php
namespace Minijournal\User\Entity;

use Slyboot\Main\Entity\MainEntity;

/**
 * Classe User : Class d'utilisateur
 * @author Macky Dieng
*  @license MIT
 */
class User extends MainEntity
{
    /**
     * L'id de l'utilisateur
     * @var integer
     */
    private $id;
    /**
     * Le role qu'auras l'utilisateur
     * @var string
     */
    private $role;
    /**
     * Le nom d'utilisateur
     * @var string
     */
    private $username;
    /**
     * Mot de passe de l'utilisateur
     * @var string
     */
    private $password;
    /**
     * Sattut de l'utilisateur
     * @var string
     */
    private $status;
    /**
     * Nom de l'utilisateur
     * @var string
     */
    private $lastName;
    /**
     * Prénom de l'utilisateur
     * @var string
     */
    private $firstName;

    public function __construct($data = array())
    {
        parent::initialize($data);
    }
    /**
     * Renvoie l'id de l'utilisateur
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Modifie l'id de l'utilisateur
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * Renvoie le role de l'utilisateur
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }
    /**
     * Modifie le role de l'utilisateur
     * @param $role : nouveau role
     * @return void
     */
    public function setRole($role)
    {
        $this->role = $role;
    }
    /**
     * Fonction indépendante à la classe user
     * permettant de renvoyer le bon rôle
     * en fonction de l'tulisateur connecté.
     */
    public function getRoles()
    {
        if ($this->role=="1") {
            return array("ROLE_USER");
        } elseif ($this->role=="2")
            return array("ROLE_EDITOR");
        else {
            return array("ROLE_ADMIN");
        }
    }
    /**
     * Renvoie le login de l'utilisateur
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
    /**
     * Modifie le login de l'utilisateur
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    /**
     * Renvoie le mot de passe de l'utilisateur
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * Modifie le mot de passe de l'utilisateur
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    /**
     * Renvoie le statut
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
    /**
     * Modifie le statut
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Renvoie le nom
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    /**
     * Modifie le nom
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
    /**
     * Renvoie le prénom
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    /**
     * Modifie le prénom
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }
}
