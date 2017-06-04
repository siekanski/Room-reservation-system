<?php

namespace rrsystemBundle\Controller;

use rrsystemBundle\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Room controller.
 *
 * @Route("room")
 */
class RoomController extends Controller
{
    /**
     * Lists all room entities.
     *
     * @Route("/", name="room_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $rooms = $em->getRepository('rrsystemBundle:Room')->findAll();

        return $this->render('room/index.html.twig', array(
            'rooms' => $rooms,
        ));
    }

    /**
     * Finds and displays a room entity.
     *
     * @Route("/{id}", name="room_show")
     * @Method("GET")
     */
    public function showAction(Room $room)
    {

        return $this->render('room/show.html.twig', array(
            'room' => $room,
        ));
    }
}
