<?php

namespace AppBundle\Form;

use AppBundle\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Название'))
            ->add('number', TextType::class, array('label' => 'Номер'))
            ->add('degree', TextType::class, array('label' => 'Уровень образования'))
            ->add('submit', SubmitType::class, array('label' => 'Сохранить'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class'=>Course::class));
    }

}