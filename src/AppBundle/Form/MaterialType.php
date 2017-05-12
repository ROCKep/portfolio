<?php

namespace AppBundle\Form;

use AppBundle\Entity\Material;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Название',
            ))
            ->add('content', TextType::class, array(
                'label' => 'Описание',
                'required' => false
            ))
            ->add('link', TextType::class, array(
                'label' => 'Ссылка',
                'required' => false
            ))
            ->add('file', FileType::class, array(
                'label' => 'Файл',
                'required' => false
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Сохранить',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Material::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_material_type';
    }
}
