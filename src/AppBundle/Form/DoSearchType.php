<?php

namespace AppBundle\Form;

use AppBundle\Form\Model\Search;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DoSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('search', SearchType::class, array('label' => 'Запрос'))
            ->add('criteria', ChoiceType::class, array(
                'label' => 'Искать по',
                'choices_as_values' => true,
                'choices' => array(
                    'Пользователям' => 'student',
                    'Сообществам' => 'community'
                ),
                'multiple' => false,
                'expanded' => true
            ))
            ->add('submit', SubmitType::class, array('label' => 'Поиск'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => Search::class));
    }

}
