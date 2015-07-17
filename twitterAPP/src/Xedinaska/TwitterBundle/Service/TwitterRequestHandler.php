<?php

namespace Xedinaska\TwitterBundle\Service;

class TwitterRequestHandler
{
    protected $curl;

    protected $host = 'https://api.twitter.com/';
    protected $userAgent = 'My Twitter App v1.0.23';

    public function request($options)
    {
        $this->setOptions($options);

        $output = curl_exec($this->curl);
        curl_close($this->curl);

        return $output;
    }

    public function setOptions($options)
    {
        $requestOptions = $this->getOptions($options);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $requestOptions['url']);
        curl_setopt($ch, CURLOPT_USERAGENT, $requestOptions['user_agent']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $requestOptions['header']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $requestOptions['method']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestOptions['content']);

        $this->curl = $ch;

        return $this;
    }

    protected function getOptions($options)
    {
        $requestOptions = [
            'url' => $this->host . '' . $options['path'],
            'user_agent' => $this->userAgent,
            'header' => [
                'Authorization: ' . $options['authorization']
            ],
            'method' => $options['method'],
            'content' => array_key_exists('content', $options) ? $options['content'] : ''
        ];

        return $requestOptions;
    }
}
