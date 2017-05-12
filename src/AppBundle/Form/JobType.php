<?php

namespace AppBundle\Form;

use AppBundle\Entity\Job;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Название организации'))
            ->add('occupation', TextType::class, array('label' => 'Должность'))
            ->add('startDate', DateType::class, array(
                'label' => 'Дата начала работы',
                'widget' => 'single_text'
            ))
            ->add('endDate', DateType::class, array(
                'required' => false,
                'label' => 'Дата окончания работы',
                'widget' => 'single_text'
            ))
            ->add('submit', SubmitType::class, array('label' => 'Сохранить'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => Job::class));
    }
}
