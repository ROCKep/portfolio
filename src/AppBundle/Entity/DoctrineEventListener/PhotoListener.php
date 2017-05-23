<?php

namespace AppBundle\Entity\DoctrineEventListener;

use AppBundle\Entity\File;
use AppBundle\Entity\Photo;
use AppBundle\Service\FileManager;
use AppBundle\Service\ImageResizer;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Mapping as ORM;

class PhotoListener
{
    private $imageResizer;
    private $fileManager;

    public function __construct(ImageResizer $imageResizer, FileManager $fileManager)
    {
        $this->imageResizer = $imageResizer;
        $this->fileManager = $fileManager;
    }

    /**
     * @ORM\PreFlush()
     */
    public function preFlush(Photo $entity, PreFlushEventArgs $args)
    {
        if (!$entity->getThumbnail())
        {
            $original = $entity->getOriginal();
            $thumbnail = new File();
            $thumbnail->setName('thumbnail_'.$original->getName());
            $path = $this->fileManager->generateNewPath($original->getPath());
            $thumbnail->setPath($path);
            $targetDir = $this->fileManager->getTargetDir();
            $this->imageResizer->resize($targetDir.'/'.$original->getPath(),
                $targetDir.'/'.$path, 200, 356);
            $entity->setThumbnail($thumbnail);
        }
    }
}