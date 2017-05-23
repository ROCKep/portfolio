<?php

namespace AppBundle\Form;

use AppBundle\Entity\Material;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class AddMaterialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Название'))
            ->add('content', TextareaType::class, array(
                'label' => 'Описание',
                'required' => false
            ))
            ->add('link', UrlType::class, array(
                'label' => 'Ссылка',
                'required' => false
            ))
            ->add('photoFiles', CollectionType::class, array(
                'entry_type' => UploadFileType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'constraints' => array(new Valid()),
                'mapped' => false,
                'validation_groups' => array('photo')
            ))
            ->add('files', CollectionType::class, array(
                'entry_type' => UploadFileType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            ->add('submit', SubmitType::class, array('label' => 'Сохранить'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Material::class,
        ));
    }
}
