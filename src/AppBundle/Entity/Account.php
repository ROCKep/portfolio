<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="accounts")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AccountRepository")
 * @UniqueEntity(fields="username", message="Логин уже занят")
 */
class Account implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="username", type="string", unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(min=4, max=10, minMessage="Логин должен быть длиной от 4 до 10 символов",
     *     maxMessage="Логин должен быть длиной от 4 до 10 символов")
     */
    private $username;

    /**
     * @Assert\NotBlank(groups={"registration"})
     * @Assert\Length(min=6, minMessage="Пароль не может быть короче 6 символов",
     *     max=4096, maxMessage="Пароль не может быть длиннее 4096 символов", groups={"registration"})
     */
    private $plainPassword;

    /**
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password;

    /**
     * @ORM\ManyToOne(targetEntity="Role")
     */
    private $role;

    /**
     * @ORM\OneToOne(targetEntity="Student", mappedBy="account")
     */
    private $student;

    public function getId()
    {
        return $this->id;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setRole(Role $role = null)
    {
        $this->role = $role;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        return array($this->getRole()->getRole());
    }

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password
            ) = unserialize($serialized);
    }

    public function setStudent(Student $student = null)
    {
        $this->student = $student;
    }

    public function getStudent()
    {
        return $this->student;
    }
}
