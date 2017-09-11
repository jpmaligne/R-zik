<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * User
 *
 * @ORM\Table(name="`users`",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="users_email_unique",columns={"email"})}
 *     )
 * @ORM\Entity()
 */
class User implements UserInterface
{
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue
    * @Groups({"user", "auth-token"})
    */
    protected $id;
    
    /**
    * @ORM\Column(type="string")
    * @Groups({"user", "auth-token"})
    */
    public $firstname;
    
    /**
    * @ORM\Column(type="string")
    */
    protected $lastname;
    
    /**
    * @ORM\Column(type="string")
    */
    protected $email;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $password;

    private $plainPassword;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function getRoles()
    {
        return [];
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->email;
    }
    
    public function eraseCredentials()
    {
        // Suppression des données sensibles
        $this->plainPassword = null;
    }
}
