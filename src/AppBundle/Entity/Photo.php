<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="photos")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PhotoRepository")
 * @ORM\EntityListeners({"AppBundle\Entity\DoctrineEventListener\PhotoListener"})
 */
class Photo
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="File", cascade={"persist", "remove"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     * @Assert\Valid()
     */
    private $original;

    /**
     * @ORM\OneToOne(targetEntity="File", cascade={"persist", "remove"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $thumbnail;

    /**
     * @ORM\ManyToOne(targetEntity="Material", inversedBy="photos")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $material;

    public function getId()
    {
        return $this->id;
    }

    public function getOriginal()
    {
        return $this->original;
    }

    public function setOriginal(File $original = null)
    {
        $this->original = $original;
    }

    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    public function setThumbnail(File $thumbnail = null)
    {
        $this->thumbnail = $thumbnail;
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