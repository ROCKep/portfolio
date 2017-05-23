<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="communities")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommunityRepository")
 */
class Community
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
     * @ORM\Column(name="about", type="text")
     */
    private $about;

    /**
     * @ORM\Column(name="creation_date", type="date")
     */
    private $creationDate;


    /**
     * @ORM\OneToOne(targetEntity="Photo", orphanRemoval=true, cascade={"persist"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity="Membership", mappedBy="community")
     */
    private $memberships;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="community", orphanRemoval=true)
     */
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="createdCommunities")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $creator;

    public function __construct()
    {
        $this->memberships = new ArrayCollection();
        $this->categories = new ArrayCollection();
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

    public function setAbout($about)
    {
        $this->about = $about;
    }

    public function getAbout()
    {
        return $this->about;
    }

    public function setCreationDate()
    {
        $this->creationDate = new \DateTime();
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }


    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto(Photo $photo = null)
    {
        $this->photo = $photo;
    }

    public function addMembership(Membership $membership)
    {
        $this->memberships[] = $membership;
    }

    public function removeMembership(Membership $membership)
    {
        $this->memberships->removeElement($membership);
    }

    public function getMemberships()
    {
        return $this->memberships;
    }

    public function getCreator()
    {
        return $this->creator;
    }

    public function setCreator(Student $creator = null)
    {
        $this->creator = $creator;
    }

    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
    }

    public function removeCategory(Category $category)
    {
        $this->categories->removeElement($category);
    }

    public function getCategories()
    {
        return $this->categories;
    }
}