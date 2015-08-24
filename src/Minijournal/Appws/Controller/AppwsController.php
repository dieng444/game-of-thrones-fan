<?php
namespace Minijournal\Appws\Controller;

use Minijournal\Appws\Entity\Appws;
use Slyboot\Controller\Controller;
use Slyboot\Response\Response;

class AppwsController extends Controller
{
    public function eventsAction()
    {
        $ws = new Appws();
        $data = $ws->getEvents();
        $events = simplexml_load_string($data);
        //var_dump($events->events->event);die;
        return $this->render('Minijournal::Appws::Default::events.html.twig', array('events' => $events));
    }
    public function locationeventsAction()
    {
        //var_dump($this->request->getParam('long'));
        //var_dump($this->request->getParam('lat'));die;
        $ws = new Appws();
        $long = $this->request->getParam('long');
        $lat = $this->request->getParam('lat');
        $data = $ws->getEventByLocation($long, $lat);
        $events = simplexml_load_string($data);

        return $this->render('Minijournal::Appws::Default::events.html.twig', array('events' => $events));
    }
}
