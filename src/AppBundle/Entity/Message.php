<?php

namespace AppBundle\Entity;

use AppBundle\Controller\StudentController;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="messages")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message
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
     * @ORM\Column(name="has_been_read", type="boolean")
     */
    private $hasBeenRead = false;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="messagesSent")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="messagesReceived")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $receiver;


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

    public function setSender(Student $sender = null)
    {
        $this->sender = $sender;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function setReceiver(Student $receiver = null)
    {
        $this->receiver = $receiver;
    }

    public function getReceiver()
    {
        return $this->receiver;
    }

    public function setHasBeenRead()
    {
        $this->hasBeenRead = true;
    }

    public function getHasBeenRead()
    {
        return $this->hasBeenRead;
    }
}
