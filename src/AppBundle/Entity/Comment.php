<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="comments")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @ORM\Column(name="time", type="datetime")
     */
    private $time;


    /**
     * @ORM\ManyToOne(targetEntity="Student")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $student;

    /**
     * @ORM\ManyToOne(targetEntity="Material", inversedBy="comments")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $material;


    public function getId()
    {
        return $this->id;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setTime()
    {
        $this->time = new \DateTime();
    }

    public function getTime()
    {
        return $this->time;
    }


    public function setStudent(Student $student = null)
    {
        $this->student = $student;
    }

    public function getStudent()
    {
        return $this->student;
    }

    public function setMaterial(Material $material = null)
    {
        $this->material = $material;
    }

    public function getMaterial()
    {
        return $this->material;
    }
}
