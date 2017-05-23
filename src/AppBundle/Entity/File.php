<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="files")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FileRepository")
 * @ORM\EntityListeners({"AppBundle\Entity\DoctrineEventListener\FileListener"})
 */
class File
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @ORM\Column(name="path", type="string")
     */
    private $path;

    /**
     * @ORM\Column(name="size", type="integer", nullable=true)
     */
    private $size;

    /**
     * @Assert\File(maxSize="50Mi", maxSizeMessage="Размер файла не должен превышать 50 Мбайт")
     * @Assert\File(maxSize="5Mi", maxSizeMessage="Размер фотографии не должен превышать 5 Мбайт",
     *     mimeTypes={"image/jpeg"}, mimeTypesMessage="Фотография должна быть в формате JPG",
     *     groups={"photo"})
     * @Assert\NotBlank(groups={"Default", "photo"})
     */
    private $file;


    /**
     * @ORM\ManyToOne(targetEntity="Material", inversedBy="files")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $material;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }


    public function getMaterial()
    {
        return $this->material;
    }

    public function setMaterial(Material $material = null)
    {
        $this->material = $material;
    }
}