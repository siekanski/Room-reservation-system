<?php

namespace rrsystemBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use rrsystemBundle\Entity\Reservation;
use Symfony\Component\HttpFoundation\Request;
use rrsystemBundle\Form\Type\Reservation\ReservationType;
use rrsystemBundle\Form\Type\Reservation\SearchReservationType;
use rrsystemBundle\Form\Type\Admin\GetReservationType;
use rrsystemBundle\Form\Type\Room\RoomType;
use rrsystemBundle\Form\Type\Catering\CateringType;

class AdminController extends Controller {
    /**
     * @Route("admin", name="admin")
     * @Template("rrsystemBundle:Admin:index.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAdminAction(Request $req) {
        $form = $this->createForm(new GetReservationType());
        $form->handleRequest($req);
        $today = date('Y-m-d');
        $todayReservations = $this->getDoctrine()->getRepository('rrsystemBundle:Reservation')->findBy(['date'=>$today]);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form['date'];
            $date = $formData->getData();
            $reservations = $this->getDoctrine()->getRepository('rrsystemBundle:Reservation')->findByDate($date);
            return array('reservations' => $reservations, 'form' => $form->createView(),'date'=>$date);
        }
        return array('reservations' => $todayReservations, 'form' => $form->createView());
    }
    /**
     * @Route("getUsers", name="getUsers")
     * @Template("rrsystemBundle:Admin:getUsers.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function getUsersAction() {
        $users = $this->getDoctrine()->getRepository('rrsystemBundle:User')->findAll();
        $usersToShow = array();
        foreach ($users as $user) {
            if ($user->hasRole('ROLE_ADMIN') == false) {
                $usersToShow[] = $user;
            }
        }
        return array('users' => $usersToShow);
    }
    /**
     * @Route("userReservations/{id}", name="userReservations")
     * @Template("rrsystemBundle:Admin:userReservations.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function userReservationsAction($id) {
        $reservations = $this->getDoctrine()->getRepository('rrsystemBundle:Reservation')->reservationsOrderByDate($id);
        return array('reservations' => $reservations);
    }
    /**
     * @Route("deleteUser/{id}", name="deleteUser")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteUser($id) {
        $userToDelete = $this->getDoctrine()->getRepository("rrsystemBundle:User")->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($userToDelete);
        $em->flush();
        return $this->redirectToRoute('getUsers');
    }
    /**
     * @Route("deleteReservation/{id}", name="deleteReservation")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteReservationAction($id) {
        $reservationToDelete = $this->getDoctrine()->getRepository("rrsystemBundle:Reservation")->find($id);
        $userId = $reservationToDelete->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $em->remove($reservationToDelete);
        $em->flush();
        return $this->redirectToRoute('userReservations', ['id' => $userId]);
    }
    /**
     * @Route("showRooms", name="showRooms")
     * @Template("rrsystemBundle:Admin:showRooms.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function showRoomsAction() {
        $rooms = $this->getDoctrine()->getRepository("rrsystemBundle:Room")->findAll();
        return array('rooms' => $rooms);
    }
    /**
     * @Route("editRoom/{id}", name="editRoom")
     * @Template("rrsystemBundle:Admin:editRoom.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editRoomAction(Request $req, $id) {
        $roomToEdit = $this->getDoctrine()->getRepository('rrsystemBundle:Room')->find($id);
        $form = $this->createForm(new RoomType(), $roomToEdit);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $room = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($room);
            $em->flush();
            $em->clear();
            return $this->redirectToRoute('showRooms');
        }
        return array('form' => $form->createView());
    }
    /**
     * @Route("showRoomReservation/{id}", name="showRoomReservation")
     * @Template("rrsystemBundle:Admin:showRoomReservation.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function showRoomReservationAction($id) {
        $reservations = $this->getDoctrine()->getRepository('rrsystemgBundle:Reservation')->findByRoom($id);
        return array('reservations' => $reservations);
    }
    
}
