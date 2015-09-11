<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        
        try {
            $info = $lastfm->callApi('user.getInfo', $user);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        $user_data = [];
        $image_data = [];

        foreach ($info as $data => $value) {
            // This is a hack to overcome a hash key on the text attribute for the image
            // Looks like the API is designed to return XML in the first place
            // Therefore, there is some on the fly conversion for translating
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
        $top_tracks = $lastfm->callApi('user.getTopTracks', $user);

        return $this->render('user/toptracks.html.twig', [
            'toptracks' => $top_tracks,
            'user' => $user 
        ]);
    }

    /**
     * @param array
     * @return array
     */
    private function extractImageSrc($value)
    {
        $arr = [];

        foreach ($value['image'] as $attrib => $data) {
            if (!empty($data['#text'])) {
                $arr['src'] = $data['#text'];
            } else {
                $arr['src'] = '';
            }
        }
        return $arr['src'];
    }
}
