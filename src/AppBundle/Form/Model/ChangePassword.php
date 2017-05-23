<?php

namespace AppBundle\Form\Model;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword
{
    /**
     * @Assert\NotBlank()
     * @SecurityAssert\UserPassword(
     *     message = "Текущий пароль введен неверно"
     * )
     */
    private $oldPassword;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=6, minMessage="Пароль не может быть короче 6 символов",
     *     max=4096, maxMessage="Пароль не может быть длиннее 4096 символов")
     */
    private $newPassword;


    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;
    }

    public function getNewPassword()
    {
        return $this->newPassword;
    }

    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;
    }
}