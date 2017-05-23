<?php

namespace AppBundle\Form;

use AppBundle\Entity\Course;
use AppBundle\Entity\Group;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', TextType::class, array('label' => 'Номер'))
            ->add('semester', NumberType::class, array('label' => 'Семестр'))
            ->add('course', EntityType::class, array(
                'label' => 'Направление',
                'class' => Course::class,
                'choice_label' => function ($course) {
                    return $course->getNumber().' ('.$course->getDegree().') - '.$course->getName();
                },
                'placeholder' => ''
            ))
            ->add('startYear', DateType::class, array(
                'label' => 'Дата поступления',
                'widget' => 'single_text'
            ))
            ->add('endYear', DateType::class, array(
                'label' => 'Дата выпуска',
                'widget' => 'single_text'
            ))
            ->add('submit', SubmitType::class, array('label' => 'Сохранить'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => Group::class));
    }
}