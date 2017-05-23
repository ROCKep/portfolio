<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="materials")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MaterialRepository")
 */
class Material
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
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(name="link", type="string", nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(name="date", type="date")
     */
    private $date;


    /**
     * @ORM\OneToMany(targetEntity="File", mappedBy="material", cascade={"persist", "remove"})
     */
    private $files;

    /**
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="material", cascade={"persist", "remove"})
     */
    private $photos;

    /**
     * @ORM\ManyToOne(targetEntity="Student")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="material")
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="materials")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="Restriction")
     */
    private $restriction;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->photos = new ArrayCollection();
        $this->files = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setLink($link)
    {
        $this->link = $link;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setDate()
    {
        $this->date = new \DateTime();
    }

    public function getDate()
    {
        return $this->date;
    }

    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
        $comment->setMaterial($this);
    }

    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function setCategory(Category $category = null)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setRestriction(Restriction $restriction = null)
    {
        $this->restriction = $restriction;
    }

    public function getRestriction()
    {
        return $this->restriction;
    }

    public function addFile(File $file)
    {
        $this->files[] = $file;
        $file->setMaterial($this);
    }

    public function removeFile(File $file)
    {
        $this->files->removeElement($file);
        $file->setMaterial(null);
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function addPhoto(Photo $photo)
    {
        $this->photos[] = $photo;
        $photo->setMaterial($this);
    }

    public function removePhoto(Photo $photo)
    {
        $this->photos->removeElement($photo);
        $photo->setMaterial(null);
    }

    public function getPhotos()
    {
        return $this->photos;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor(Student $student = null)
    {
        $this->author = $student;
    }
}