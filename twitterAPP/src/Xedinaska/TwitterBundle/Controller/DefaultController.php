<?php

namespace Xedinaska\TwitterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Xedinaska\TwitterBundle\Service\Encoder\BearerTokenGenerator;
use Xedinaska\TwitterBundle\Service\TwitterRequestHandler;
use Xedinaska\TwitterBundle\Service\TwitterResponseReader;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        /*$url = "https://api.twitter.com/oauth2/token";

        $requestHandler = new TwitterRequestHandler();
        $output = $requestHandler->send($url, true);

        $responseReader = new TwitterResponseReader($output);
        echo 'Code: ' . $responseReader->getCode();
        echo '<br>Message: ' . $responseReader->getMessage();*/

        $tokenGenerator = new BearerTokenGenerator();
        $accessToken = $tokenGenerator
            ->getAccessToken('47AdsMGL5UhWK9N1naQRQ', 'F1Hy5MAOfNX2tdQ254EsfRtsXfm0OS5RqirlbwCKlSM');

        return $this->render('TwitterBundle:Default:index.html.twig', array('name' => $name));
    }

    protected function testAPI($accessToken)
    {
        $requestHandler = new TwitterRequestHandler();
        $requestOptions = [
            'path' => '/1.1/statuses/user_timeline.json?count=10&screen_name=xedin',
            'authorization' => 'Bearer ' . $accessToken,
            'method' => 'GET'
        ];

        $responseReader = new TwitterResponseReader($requestHandler->request($requestOptions));
        return $responseReader->getArrayResult();
    }
}
