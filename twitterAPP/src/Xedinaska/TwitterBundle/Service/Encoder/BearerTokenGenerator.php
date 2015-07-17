<?php

namespace Xedinaska\TwitterBundle\Service\Encoder;

use Xedinaska\TwitterBundle\Service\TwitterRequestHandler;
use Xedinaska\TwitterBundle\Service\TwitterResponseReader;

class BearerTokenGenerator
{
    public function get64EncodedBearerTokenCredentials($consumerKey, $consumerSecret)
    {
        $rfc1738Key = $this->getRFC1738EncodedItem($consumerKey);
        $rfc1738Secret = $this->getRFC1738EncodedItem($consumerSecret);

        $bearerTokenCredentials = ($rfc1738Key . ':' . $rfc1738Secret);

        return base64_encode($bearerTokenCredentials);
    }

    public function getAccessToken($consumerKey, $consumerSecret)
    {
        $encodedToken = $this->get64EncodedBearerTokenCredentials($consumerKey, $consumerSecret);

        $requestOptions = [
            'authorization' => 'Basic ' . $encodedToken,
            'path' => 'oauth2/token',
            'content' => 'grant_type=client_credentials',
            'method' => 'POST'
        ];

        $apiRequestHandler = new TwitterRequestHandler();
        $responseString = $apiRequestHandler->request($requestOptions);

        $responseReader = new TwitterResponseReader($responseString);

        return $responseReader->get('access_token');
    }

    public function getSelfDebugResult()
    {
        $consumerKey = 'xvz1evFS4wEEPTGEFPHBog';
        $consumerSecret = 'L8qq9PZyRg6ieKGEKhZolGC0vJWLw8iEJ88DRdyOg';

        $encodedToken = $this->get64EncodedBearerTokenCredentials($consumerKey, $consumerSecret);

        return
            $encodedToken == 'eHZ6MWV2RlM0d0VFUFRHRUZQSEJvZzpMOHFxOVBaeVJnNmllS0dFS2hab2xHQzB2SldMdzhpRUo4OERSZHlPZw==';
    }

    protected function getRFC1738EncodedItem($item)
    {
        return rawurlencode($item);
    }
}