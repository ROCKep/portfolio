<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, array('label' => 'Имя'))
            ->add('middleName', TextType::class, array('required' => false, 'label' => 'Отчество'))
            ->add('lastName', TextType::class, array('label' => 'Фамилия'))
            ->add('group', EntityType::class, array(
                'label' => 'Группа',
                'class' => 'AppBundle\Entity\Group',
                'choice_label' => function($group){
                    $department = $group->getDepartment();
                    $faculty = $department->getFaculty();
                    return sprintf("%s%s-%d%s",$faculty->getAbbr(), $department->getNumber(),
                            $group->getSemester(), $group->getNumber());
                },
                'placeholder' => ''
            ))
            ->add('email', EmailType::class, array('label' => 'Электронная почта'))
            ->add('username', TextType::class, array('label' => 'Логин'))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Пароль'),
                'second_options' => array('label' => 'Подтверждение пароля'),
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Зарегистрироваться',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_signup_type';
    }
}