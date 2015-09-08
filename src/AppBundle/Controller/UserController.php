<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return new Response('Hello');
    }

    /**
     * @Route("/{user}/info", name="user_info")
     */
    public function getUserInfo($user)
    {
        $lastfm = $this->get('lastfm.client');
        $info = $lastfm->callApi($method = 'user.getInfo', $user);
        $user_data = [];
        $image_data = [];

        foreach ($info as $data => $value) {
            // This is a hack to overcome a hash key on the text attribute for the image
            // Looks like the API is designed to return XML in the first place
            // Therefore, looks like there is some on the fly conversion for translating
            // XML to JSON
            if ($value['image']) {
                $image_data['src'] = $this->extractImageSrc($value);
            }
            $user_data[] = $value;
        }

        return $this->render('user/info.html.twig', [
            'info' => $user_data,
            'image' => $image_data
        ]);
    }

    /**
     * @Route("/{user}/toptracks", name="toptracks")
     */
    public function getUserTopTracksAction($user)
    {
        $lastfm = $this->get('lastfm.client');
        $top_tracks = $lastfm->callApi($method = 'user.getTopTracks', $user);
        die(dump($top_tracks));

        return ['toptracks' => $top_tracks];
    }

    /**
     * @param array
     * @return array
     */
    private function extractImageSrc($value)
    {
        $arr = [];

        foreach ($value['image'] as $attrib => $data) {
            if ($data['#text']) {
                $arr['src'] = $data['#text'];
            }
        }
        return $arr['src'];
    }
}
