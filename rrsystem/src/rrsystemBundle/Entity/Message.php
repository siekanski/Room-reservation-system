<?php

namespace rrsystemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="rrsystemBundle\Entity\MessageRepository")
 */
class Message
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="sent_message" )
     * @ORM\JoinColumn(name="user_sender_id", referencedColumnName="id")
     */
    private $userSender;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="received_message")
     * @ORM\JoinColumn(name="user_receiver_id", referencedColumnName="id") 
     */
    private $userReceiver;
    
    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;
    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set subject
     *
     * @param string $subject
     * @return Message
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }
    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }
    /**
     * Set text
     *
     * @param string $text
     * @return Message
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }
    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }
    /**
     * Set userSender
     *
     * @param \rrsystemBundle\Entity\User $userSender
     * @return Message
     */
    public function setUserSender(\rrsystemBundle\Entity\User $userSender = null)
    {
        $this->userSender = $userSender;
        return $this;
    }
    /**
     * Get userSender
     *
     * @return \rrsystemBundle\Entity\User 
     */
    public function getUserSender()
    {
        return $this->userSender;
    }
    /**
     * Set userReceiver
     *
     * @param \rrsystemBundle\Entity\User $userReceiver
     * @return Message
     */
    public function setUserReceiver(\rrsystemBundle\Entity\User $userReceiver = null)
    {
        $this->userReceiver = $userReceiver;
        return $this;
    }
    /**
     * Get userReceiver
     *
     * @return \rrsystemBundle\Entity\User 
     */
    public function getUserReceiver()
    {
        return $this->userReceiver;
    }
}