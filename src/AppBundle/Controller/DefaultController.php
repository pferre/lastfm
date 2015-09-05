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
        $lastfm = $this->get('lastfm.client');
        $info = $lastfm->callApi($method = 'user.getInfo');
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

        return $this->render('default/index.html.twig', [
            'info' => $user_data,
            'image' => $image_data
        ]);
    }

    /**
     * @Route("/{user}/toptracks", name="toptracks")
     */
    public function getUserTopTracksAction()
    {
        $lastfm = $this->get('lastfm.client');
        $top_tracks = $lastfm->callApi($method = 'user.getTopTracks');
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

        foreach ($value['image'] as $data => $attrib) {
            if ($attrib['#text']) {
                $arr['src'] = $attrib['#text'];
            }
        }
        return $arr['src'];
    }
}
