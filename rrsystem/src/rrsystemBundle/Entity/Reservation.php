<?php

namespace rrsystemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="rrsystemBundle\Repository\ReservationRepository")
 */
class Reservation
{
    
//    public function __construct() {
//        $this->room = new \Doctrine\Common\Collections\ArrayCollection();
//    }
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="reservations")
     * @ORM\JoinColumn(name="room_id", referencedColumnName="id")
     */
    private $room;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="reservations")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    
    /**
     * @var \Date
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;
    /**
     * @var \Time
     *
     * @ORM\Column(name="time_start", type="time")
     */
    private $timeStart;
    
     /**
     * @var \Time
     *
     * @ORM\Column(name="time_end", type="time")
     */
    private $timeEnd;
    /**
     * @var string
     *
     * @ORM\Column(name="projector", type="string", length=255)
     */
    private $projector;
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
     * Set dateStart
     *
     * @param \DateTime $dateStart
     * @return Reservation
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;
        return $this;
    }
    /**
     * Get dateStart
     *
     * @return \DateTime 
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }
    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     * @return Reservation
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;
        return $this;
    }
    /**
     * Get dateEnd
     *
     * @return \DateTime 
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }
    /**
     * Set projector
     *
     * @param string $projector
     * @return Reservation
     */
    public function setProjector($projector)
    {
        $this->projector = $projector;
        return $this;
    }
    /**
     * Get projector
     *
     * @return string 
     */
    public function getProjector()
    {
        return $this->projector;
    }
    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Reservation
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }
    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * Set timeStart
     *
     * @param \DateTime $timeStart
     * @return Reservation
     */
    public function setTimeStart($timeStart)
    {
        $this->timeStart = $timeStart;
        return $this;
    }
    /**
     * Get timeStart
     *
     * @return \DateTime 
     */
    public function getTimeStart()
    {
        return $this->timeStart;
    }
    /**
     * Set timeEnd
     *
     * @param \DateTime $timeEnd
     * @return Reservation
     */
    public function setTimeEnd($timeEnd)
    {
        $this->timeEnd = $timeEnd;
        return $this;
    }
    /**
     * Get timeEnd
     *
     * @return \DateTime 
     */
    public function getTimeEnd()
    {
        return $this->timeEnd;
    }
    /**
     * Set room
     *
     * @param \rrsystemBundle\Entity\Room $room
     * @return Reservation
     */
    public function setRoom(\rrsystemBundle\Entity\Room $room = null)
    {
        $this->room = $room;
        return $this;
    }
    /**
     * Get room
     *
     * @return \rrsystemBundle\Entity\Room 
     */
    public function getRoom()
    {
        return $this->room;
    }
    /**
     * Set user
     *
     * @param \rrsystemBundle\Entity\User $user
     * @return Reservation
     */
    public function setUser(\rrsystemBundle\Entity\User $user = null)
    {
        $this->user = $user;
        return $this;
    }
    /**
     * Get user
     *
     * @return \rrsystemBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    
}