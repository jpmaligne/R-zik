<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * User
 *
 * @ORM\Table(name="user",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="user_login_uniq",columns={"login"})}
 *     )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose
     */
    private $id;

    /**
     *@ORM\Column(name="login", type="string")
     */
    private $login;

}
