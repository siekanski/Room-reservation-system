<?php

namespace rrsystemBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Room
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="rrsystemBundle\Entity\RoomRepository")
 */
class Room
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
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="room")
     */
    private $reservations;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=30)
     */
    private $size;
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
     * Set name
     *
     * @param string $name
     * @return Room
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Set description
     *
     * @param string $description
     * @return Room
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Set size
     *
     * @param string $size
     * @return Room
     */
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }
    /**
     * Get size
     *
     * @return string 
     */
    public function getSize()
    {
        return $this->size;
    }
    
    public function __construct() {
        $this->reservations = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add reservations
     *
     * @param \rrsystemBundle\Entity\Reservation $reservations
     * @return Room
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
}