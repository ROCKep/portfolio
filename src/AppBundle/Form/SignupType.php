<?php

namespace AppBundle\Form;

use AppBundle\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, array('label' => 'Фамилия'))
            ->add('firstName', TextType::class, array('label' => 'Имя'))
            ->add('middleName', TextType::class, array('required' => false, 'label' => 'Отчество'))
            ->add('number', TextType::class, array('label' => 'Номер студ. билета'))
            ->add('email', EmailType::class, array('label' => 'Электронная почта'))
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
            ->add('account', AccountType::class)
            ->add('submit', SubmitType::class, array(
                'label' => 'Зарегистрироваться',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Student::class,
        ));
    }
}