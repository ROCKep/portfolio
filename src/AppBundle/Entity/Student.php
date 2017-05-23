<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="students")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StudentRepository")
 * @UniqueEntity(fields="email", message="Электронная почта уже занята")
 */
class Student
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="first_name", type="string")
     * @Assert\NotBlank()
     */
    private $firstName;

    /**
     * @ORM\Column(name="middle_name", type="string", nullable=true)
     */
    private $middleName;

    /**
     * @ORM\Column(name="last_name", type="string")
     * @Assert\NotBlank()
     */
    private $lastName;

    /**
     * @ORM\Column(name="email", type="string", unique=true)
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @ORM\Column(name="dob", type="date", nullable=true)
     */
    private $dob;

    /**
     * @ORM\Column(name="phone", type="string", nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive = false;

    /**
     * @ORM\Column(name="signup_date", type="date")
     */
    private $signupDate;

    /**
     * @ORM\Column(name="number", type="string")
     */
    private $number;

    /**
     * @ORM\Column(name="degree", type="string", nullable=true)
     */
    private $degree;

    /**
     * @ORM\OneToOne(targetEntity="Account", inversedBy="student", cascade={"remove"})
     * @Assert\Valid()
     */
    private $account;

    /**
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="students")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $group;

    /**
     * @ORM\OneToMany(targetEntity="Job", mappedBy="student")
     */
    private $jobs;

    /**
     * @ORM\OneToMany(targetEntity="Membership", mappedBy="student")
     */
    private $memberships;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="sender")
     */
    private $messagesSent;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="receiver")
     */
    private $messagesReceived;

    /**
     * @ORM\OneToOne(targetEntity="Photo", orphanRemoval=true, cascade={"persist"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     * @Assert\Valid()
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity="Material", mappedBy="author", cascade={"remove"})
     */
    private $authoredMaterials;

    /**
     * @ORM\OneToMany(targetEntity="Community", mappedBy="creator", cascade={"remove"})
     */
    private $createdCommunities;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="student", cascade={"remove"})
     */
    private $categories;

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
        $this->messagesSent = new ArrayCollection();
        $this->messagesReceived = new ArrayCollection();
        $this->memberships = new ArrayCollection();
        $this->createdCommunities = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->authoredMaterials = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
    }

    public function getMiddleName()
    {
        return $this->middleName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setDob($dob)
    {
        $this->dob = $dob;
    }

    public function getDob()
    {
        return $this->dob;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setIsActive()
    {
        $this->isActive = true;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setSignupDate()
    {
        $this->signupDate = new \DateTime();
    }

    public function getSignupDate()
    {
        return $this->signupDate;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        $this->number = $number;
    }

    public function getDegree()
    {
        return $this->degree;
    }

    public function setDegree($degree)
    {
        $this->degree = $degree;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar(Photo $avatar = null)
    {
        $this->avatar = $avatar;
    }

    public function getAccount()
    {
        return $this->account;
    }

    public function setAccount(Account $account = null)
    {
        $this->account = $account;
    }

    public function setGroup(Group $group = null)
    {
        $this->group = $group;
    }

    public function getGroup()
    {
        return $this->group;
    }

    public function addJob(Job $job)
    {
        $this->jobs[] = $job;
    }

    public function removeJob(Job $job)
    {
        $this->jobs->removeElement($job);
    }

    public function getJobs()
    {
        return $this->jobs;
    }

    public function addMessageSent(Message $messagesSent)
    {
        $this->messagesSent[] = $messagesSent;
    }

    public function removeMessageSent(Message $messagesSent)
    {
        $this->messagesSent->removeElement($messagesSent);
    }

    public function getMessagesSent()
    {
        return $this->messagesSent;
    }

    public function addMessageReceived(Message $messagesReceived)
    {
        $this->messagesReceived[] = $messagesReceived;
    }

    public function removeMessageReceived(Message $messagesReceived)
    {
        $this->messagesReceived->removeElement($messagesReceived);
    }

    public function getMessagesReceived()
    {
        return $this->messagesReceived;
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

    public function addCreatedCommunity(Community $community)
    {
        $this->createdCommunities[] = $community;
    }

    public function removeCreatedCommunity(Community $community)
    {
        $this->createdCommunities->removeElement($community);
    }

    public function getCreatedCommunities()
    {
        return $this->createdCommunities;
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

    public function addAuthoredMaterial(Material $material)
    {
        $this->authoredMaterials[] = $material;
    }

    public function removeAuthoredMaterial(Material $material)
    {
        $this->authoredMaterials->removeElement($material);
    }

    public function getAuthoredMaterials()
    {
        return $this->authoredMaterials;
    }
}