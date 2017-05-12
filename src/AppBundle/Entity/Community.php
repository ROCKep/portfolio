<?php

namespace AppBundle\Entity;

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
     * @ORM\Column(name="about", type="string")
     */
    private $about;

    /**
     * @ORM\Column(name="creation_date", type="date")
     */
    private $creationDate;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Membership", mappedBy="community")
     */
    private $memberships;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Category", mappedBy="community")
     */
    private $categories;


    public function __construct()
    {
        $this->memberships = new \Doctrine\Common\Collections\ArrayCollection();
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    public function getAbout()
    {
        return $this->about;
    }

    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }


    public function addMembership(\AppBundle\Entity\Membership $membership)
    {
        $this->memberships[] = $membership;

        return $this;
    }

    public function removeMembership(\AppBundle\Entity\Membership $membership)
    {
        $this->memberships->removeElement($membership);
    }

    public function getMemberships()
    {
        return $this->memberships;
    }

    public function addCategory(\AppBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    public function removeCategory(\AppBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    public function getCategories()
    {
        return $this->categories;
    }
}
