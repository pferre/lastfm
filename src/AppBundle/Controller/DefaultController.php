<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $lastm = $this->get('lastfm');
        $info = $lastm->callApi($method = 'user.getInfo');

        return $this->render('default/index.html.twig', [
            'info' => $info
        ]);
    }
}
