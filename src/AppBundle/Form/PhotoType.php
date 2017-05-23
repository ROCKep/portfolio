<?php

namespace AppBundle\Form;

use AppBundle\Entity\File;
use AppBundle\Entity\Photo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhotoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('original', UploadFileType::class)
//            ->addEventListener(FormEvents::POST_SUBMIT, array($this, 'onPostSubmit'))
        ;
    }
//
//    public function onPostSubmit(FormEvent $event)
//    {
//        $photo = $event->getData();
//        $thumbnail = $photo->getThumbnail();
//        if (!$thumbnail)
//        {
//            $thumbnail = new File();
//            $photo->setThumbnail($thumbnail);
//        }
//        $original = $photo->getOriginal();
//        $thumbnail->setName('thumbnail_'.$original->getName());
//    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Photo::class,
            'validation_groups' => array('photo')
        ));
    }
}
