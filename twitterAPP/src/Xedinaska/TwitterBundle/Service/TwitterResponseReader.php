<?php

namespace Xedinaska\TwitterBundle\Service;

class TwitterResponseReader
{
    protected $response;

    public function __construct($responseString)
    {
        $this->response = json_decode($responseString);
    }
}