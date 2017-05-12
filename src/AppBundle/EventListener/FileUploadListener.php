<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use AppBundle\Entity\Material;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use AppBundle\Service\FileUploader;
use AppBundle\Service\ImageResizer;

class FileUploadListener
{
    private $uploader;
    private $resizer;

    public function __construct(FileUploader $uploader, ImageResizer $resizer)
    {
        $this->uploader = $uploader;
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

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Material)
        {
            if ($fileName = $entity->getFile())
            {
                $entity->setFile(new File($this->uploader->getTargetDir().'/'.$fileName));
            }
        }
        elseif ($entity instanceof User)
        {
            if ($fileName = $entity->getAvatar())
            {
                $entity->setAvatar(new File($this->uploader->getTargetDir().'/'.$fileName));
            }
        }
    }

    private function uploadFile($entity)
    {
        if ($entity instanceof Material)
        {
            $file = $entity->getFile();
            if (!$file instanceof UploadedFile)
            {
                return;
            }
            $fileName = $this->uploader->upload($file);
            $entity->setFile($fileName);
        }
        elseif ($entity instanceof User)
        {
            $file = $entity->getAvatar();
            if (!$file instanceof UploadedFile)
            {
                return;
            }
            $fileName = $this->uploader->upload($file);
            $filePath = $this->uploader->getTargetDir().'/'.$fileName;
            $this->resizer->resizeWidth($filePath, 200);
            $entity->setAvatar($fileName);
        }
    }
}