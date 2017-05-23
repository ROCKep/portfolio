<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\File;
use AppBundle\Entity\Photo;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use AppBundle\Service\FileManager;
use AppBundle\Service\ImageResizer;

class FileUploadListener
{
    private $fileManager;
    private $resizer;

    public function __construct(FileManager $fileManager, ImageResizer $resizer)
    {
        $this->fileManager = $fileManager;
        $this->resizer = $resizer;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        if ($entity instanceof File)
        {
            $file = $entity->getFile();
            if (!$file instanceof UploadedFile)
            {
                return;
            }
            $fileName = $this->fileManager->upload($file);
            $entity->setFile($fileName);
        }
        elseif ($entity instanceof Photo)
        {
            $original = $entity->getOriginal();
            if (!$original)
            {
                return;
            }
            $thumbnail = $entity->getThumbnail();
            $thumbnail->setFile($this->fileManager->cloneFile($original->getFile()));
            $filePath = $this->fileManager->getTargetDir().'/'.$thumbnail->getFile();
            $this->resizer->resizeWidth($filePath, 200);
            $entity->setThumbnail($thumbnail);
        }
    }
}