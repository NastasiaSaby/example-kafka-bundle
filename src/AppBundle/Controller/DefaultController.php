<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/produce", name="produce")
     */
    public function produceAction(Request $request)
    {
        $userEvent = [
            'uid' => uniqid('uid-'),
            'event_type' => 'update'
        ];

        $this->get('m6_web_kafka.producer.eventusers')->produce(json_encode($userEvent));

        return new Response(null, 201);
    }
}
