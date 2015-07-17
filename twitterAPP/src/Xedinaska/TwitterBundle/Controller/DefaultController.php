<?php

namespace Xedinaska\TwitterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.twitter.com/1.1/followers/ids.json");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        var_dump($output);

        if ($output)
        {
            $tweets = json_decode($output,true);

            foreach ($tweets as $tweet)
            {
                print_r($tweet);
            }
        }

        return $this->render('TwitterBundle:Default:index.html.twig', array('name' => $name));
    }
}
