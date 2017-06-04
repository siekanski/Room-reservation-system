<?php

namespace rrsystemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="user")
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="userReceiver")
     */
    private $receivedMessage;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="userSender")
     */
    private $sentMessage;
    
    public function __construct()
    {
        parent::__construct();
        $this->reservations = new \Doctrine\Common\Collections\ArrayCollection();        
        $this->receivedMessage = new \Doctrine\Common\Collections\ArrayCollection();        
        $this->sentMessage = new \Doctrine\Common\Collections\ArrayCollection();        
        
    }
    
    /**
     * Add reservations
     *
     * @param \rrsystemBundle\Entity\Reservation $reservations
     * @return User
     */
    public function addReservation(\rrsystemBundle\Entity\Reservation $reservations)
    {
        $this->reservations[] = $reservations;
        return $this;
    }
    /**
     * Remove reservations
     *
     * @param \rrsystemBundle\Entity\Reservation $reservations
     */
    public function removeReservation(\rrsystemBundle\Entity\Reservation $reservations)
    {
        $this->reservations->removeElement($reservations);
    }
    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReservations()
    {
        return $this->reservations;
    }
    /**
     * Add receivedMessage
     *
     * @param \rrsystemBundle\Entity\Message $receiveMessage
     * @return User
     */
    public function addReceivedMessage(\rrsystemBundle\Entity\Message $receivedMessage)
    {
        $this->receivedMessage[] = $receivedMessage;
        return $this;
    }
    /**
     * Remove receivedMessage
     *
     * @param \rrsystemBundle\Entity\Message $receivedMessage
     */
    public function removeReceivedMessage(\rrsystemBundle\Entity\Message $receivedMessage)
    {
        $this->receivedMessage->removeElement($receivedMessage);
    }
    /**
     * Get receivedMessage
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReceivedMessage()
    {
        return $this->receivedMessage;
    }
    /**
     * Add sentMessage
     *
     * @param \rrsystemBundle\Entity\Message $sentMessage
     * @return User
     */
    public function addSentMessage(\rrsystemBundle\Entity\Message $sentMessage)
    {
        $this->sentMessage[] = $sentMessage;
        return $this;
    }
    /**
     * Remove sentMessage
     *
     * @param \rrsystemBundle\Entity\Message $sentMessage
     */
    public function removesentMessage(\rrsystemBundle\Entity\Message $sentMessage)
    {
        $this->sentMessage->removeElement($sentMessage);
    }
    /**
     * Get sentMessage
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSentMessage()
    {
        return $this->sentMessage;
    }
}


    