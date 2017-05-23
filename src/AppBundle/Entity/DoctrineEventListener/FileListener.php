<?php

namespace AppBundle\Entity\DoctrineEventListener;

use AppBundle\Entity\File;
use AppBundle\Service\FileManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;

class FileListener
{
    private $fileManager;

    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist(File $entity, LifecycleEventArgs $args)
    {
        $file = $entity->getFile();
        if (!$file instanceof UploadedFile)
        {
            return;
        }
        $entity->setName($file->getClientOriginalName());
        $entity->setSize($file->getClientSize());
        $path = $this->fileManager->upload($file);
        $entity->setPath($path);
    }


//    /**
//     * @ORM\PostRemove()
//     */
//    public function postRemove(File $entity, LifecycleEventArgs $args)
//    {
//        $this->fileManager->delete($entity->getPath());
//    }

    /**
     * @ORM\PostLoad()
     */
    public function postLoad(File $entity, LifecycleEventArgs $args)
    {
        if ($path = $entity->getPath())
        {
            $entity->setFile(new \Symfony\Component\HttpFoundation\File\File($this->fileManager->getTargetDir().'/'.$path));
        }
    }
}