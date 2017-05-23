<?php

namespace AppBundle\Form;

use AppBundle\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, array('label' => 'Фамилия'))
            ->add('firstName', TextType::class, array('label' => 'Имя'))
            ->add('middleName', TextType::class, array('required' => false, 'label' => 'Отчество'))
            ->add('email', EmailType::class, array('label' => 'Электронная почта'))
            ->add('dob', BirthdayType::class, array(
                'required' => false,
                'label' => 'Дата рождения',
                'widget' => 'single_text'
            ))
            ->add('phone', TextType::class, array('required' => false, 'label' => 'Номер телефона'))
            ->add('degree', TextType::class, array('required' => false, 'label' => 'Степень образования'))
            ->add('submit', SubmitType::class, array('label' => 'Сохранить'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Student::class,
        ));
    }
}
