<?php

namespace rrsystemBundle\Controller;

use rrsystemBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use rrsystemBundle\Form\Type\Reservation\ReservationType;
use rrsystemBundle\Form\Type\Reservation\SearchReservationType;
use rrsystemBundle\Form\Type\Admin\GetReservationType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class ReservationController extends Controller {
    /**
     * @Route("/", name="/")
     * @Template("rrsystemBundle:Reservation:index.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction(Request $req) {
        $loggedUser = $this->container->get('security.context')->getToken()->getUser();
       // if ($loggedUser->hasRole('ROLE_ADMIN')) {
            //return $this->redirectToRoute('admin');
       // }
        $today = new \DateTime();
        $reservations = $this->getDoctrine()
                ->getRepository('rrsystemBundle:Reservation')
                ->findBy(['user'=>$loggedUser, 'date'=>$today]);
        $form = $this->createForm(new SearchReservationType());
        return array('reservations' => $reservations, 'form' => $form->createView());
    }
    /**
     * @Route("/getRooms", name="getRooms")
     * @Security("has_role('ROLE_USER')")
     */
    public function getRoomsAction(Request $req) {
        $date = $req->request->get('key1');
        $timeStart = $req->request->get('key2');
        $timeEnd = $req->request->get('key3');
        $session = $req->getSession();
        $session->set('date', $date);
        $session->set('timeStart', $timeStart);
        $session->set('timeEnd', $timeEnd);
        $reservations = $this->getDoctrine()->getRepository('rrsystemBundle:Reservation')
                ->findBy(['date'=>$date]);
        $timeStartEx = explode(":", $timeStart);
        $timeEndEx = explode(":", $timeEnd);
        $hourStart = (int) $timeStartEx[0];
        $minuteStart = (int) $timeStartEx[1];
        $hourEnd = (int) $timeEndEx[0];
        $minuteEnd = (int) $timeEndEx[1];
        $timestampStart = ($hourStart * 3600) + ($minuteStart * 60) - 3600;
        $timestampEnd = ($hourEnd * 3600) + ($minuteEnd * 60) - 3600;
        $resRoomsId = [];
        foreach ($reservations as $reservation) {
            $resTimeStart = $reservation->getTimeStart()->getTimestamp();
            $resTimeEnd = $reservation->getTimeEnd()->getTimestamp();
            if ($timestampStart >= $resTimeStart && $timestampStart < $resTimeEnd) {
                $resRoomsId[] = $reservation->getRoom()->getId();
            }
            if ($timestampEnd > $resTimeStart && $timestampEnd < $resTimeEnd) {
                $resRoomsId[] = $reservation->getRoom()->getId();
            } elseif ($resTimeStart > $timestampStart && $resTimeStart < $timestampEnd) {
                $resRoomsId[] = $reservation->getRoom()->getId();
            }
        }
        $session->set('rooms', $resRoomsId);
        $response = new JsonResponse(array(
            'data' => $resRoomsId
        ));
        return $response;
    }
    /**
     * @Route("setReservation/{id}", name="setReservation")
     * @Template("rrsystemBundle:Reservation:setReservation.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function setReservationAction(Request $req, $id) {
        $session = $req->getSession();
        $rooms = $session->get('rooms');
        $date = new \DateTime($session->get('date'));
        $timeStart = new \DateTime($session->get('timeStart'));
        $timeEnd = new \DateTime($session->get('timeEnd'));
        $form = $this->createForm(new ReservationType());
        if (in_array($id, $rooms) == false && isset($date)) {
            $form->handleRequest($req);
            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $room = $this->getDoctrine()->getRepository("rrsystemBundle:Room")->find($id);
                $user = $this->container->get('security.context')->getToken()->getUser();
                $reservation = new Reservation();
                $reservation->setUser($user);
                $reservation->setRoom($room);
                $reservation->setDate($date);
                $reservation->setTimeStart($timeStart);
                $reservation->setTimeEnd($timeEnd);
                $reservation->setProjector($data['projector']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($reservation);
                $em->flush();
                $session->remove('date');
                $lastInsertId = $reservation->getId();
                return $this->redirectToRoute("success", array('id' => $lastInsertId));
            }
        }
        return array('form' => $form->createView());
    }
    /**
     * @Route("success/{id}", name="success")
     * @Template("rrsystemBundle:Reservation:success.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function successAction($id) {
        $reservation = $this->getDoctrine()->getRepository('rrsystemBundle:Reservation')->find($id);
        $timeStart = date("H:i", $reservation->getTimeStart()->getTimestamp());
        $timeEnd = date("H:i", $reservation->getTimeEnd()->getTimestamp());
        $date = date("Y.m.d", $reservation->getDate()->getTimestamp());
        $reservation->setTimeStart($timeStart);
        $reservation->setTimeEnd($timeEnd);
        $reservation->setDate($date);
        return array('reservation' => $reservation);
    }
    /**
     * @Route("showReservations", name="showReservations")
     * @Template("rrsystemBundle:Reservation:showReservation.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function showReservationsAction() {
        $loggedUser = $this->container->get('security.context')->getToken()->getUser();
        $reservations = $this->getDoctrine()->getRepository('rrsystemBundle:Reservation')
                ->findBy(['user'=>$loggedUser],['date'=>'ASC']);
        return array('reservations' => $reservations);
    }
    /**
     * @Route("deleteUserReservation/{id}", name="deleteUserReservation")
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteReservationByUserAction($id) {
        $loggedUser = $this->container->get('security.context')->getToken()->getUser();
        $reservations = $this->getDoctrine()->getRepository('rrsystemBundle:Reservation')->findByUser($loggedUser);
        foreach ($reservations as $reservation) {
            if ($reservation->getId() == $id) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($reservation);
                $em->flush();
                $em->clear();
                return $this->redirectToRoute('showReservations');
            }
            throw new NotFoundHttpException();
        }
    }
    /**
     * @Route("editReservation/{id}", name="editReservation")
     * @Template("rrsystemBundle:Reservation:editReservation.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function editReservationAction(Request $req, $id) {
        $loggedUser = $this->container->get('security.context')->getToken()->getUser();
        $reservations = $this->getDoctrine()->getRepository('rrsystemBundle:Reservation')->findByUser($loggedUser);
        foreach ($reservations as $reservation) {
            if ($reservation->getId() == $id) {
                $reservationToEdit = $reservation;
            }
        }
        if (isset($reservationToEdit)) {
            $form = $this->createForm(new ReservationType(), $reservationToEdit);
            $form->handleRequest($req);
        } else {
            throw new NotFoundHttpException();
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $reservation = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();
            $em->clear();
            return $this->redirectToRoute('showReservations');
        }
        return array('form' => $form->createView());
    }
}