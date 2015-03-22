<?php

namespace Xedinaska\TwitterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TwitterBundle:Default:index.html.twig', array('name' => $name));
    }
}
