<?php

namespace AppBundle\Form;

use AppBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, array('label' => "Имя категории"))
            ->add('restriction', EntityType::class, array(
                'label' => 'Права доступа',
                'class' => 'AppBundle\Entity\Restriction',
                'choice_label' => 'name',
                'placeholder' => 'Видно всем',
                'required' => false,
            ))
            ->add('submit', SubmitType::class, array('label' => 'Сохранить'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => Category::class));
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_category_type';
    }
}
