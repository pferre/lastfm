<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/lastfm/userinfo", name="homepage")
     */
    public function indexAction()
    {
        $lastm = $this->get('lastfm');
        $info = $lastm->getUserInfo();
        $data = json_decode($info, true);

        return $this->render('default/index.html.twig', [
            'info' => $data
        ]);
    }
}
