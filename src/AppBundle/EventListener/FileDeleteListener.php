<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\File;
use AppBundle\Service\FileManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class FileDeleteListener
{
    private $fileManager;

    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof File)
        {
            if ($fileName = $entity->getFile())
            {
                $this->fileManager->delete($fileName);
            }
        }
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof File)
        {
            if ($args->hasChangedField('file'))
            {
                if ($fileName = $args->getOldValue('file'))
                {
                    $this->fileManager->delete($fileName);
                }
            }
        }
    }
}