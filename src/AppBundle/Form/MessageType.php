<?php

namespace AppBundle\Form;

use AppBundle\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, array('label' => 'Сообщение'))
            ->add('submit', SubmitType::class, array('label' => 'Отправить'))
            ->addEventListener(FormEvents::POST_SUBMIT, array($this, 'onPostSubmit'))
        ;
    }

    public function onPostSubmit(FormEvent $event)
    {
        $message = $event->getData();
        if (!$message)
        {
            return;
        }
        $message->setTime();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => Message::class));
    }
}
