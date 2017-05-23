<?php

namespace AppBundle\Form;

use AppBundle\Entity\Community;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class ChangePhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photoFile', UploadFileType::class, array(
                'constraints' => array(new Valid()),
                'mapped' => false,
                'validation_groups' => array('photo')
            ))
            ->add('submit', SubmitType::class, array('label' => 'Сохранить'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => Community::class));
    }
}
