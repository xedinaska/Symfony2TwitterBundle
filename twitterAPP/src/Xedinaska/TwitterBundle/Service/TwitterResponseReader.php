<?php

namespace Xedinaska\TwitterBundle\Service;

class TwitterResponseReader
{
    protected $response;
    protected $errors;

    public function __construct($responseString)
    {
        $this->response = json_decode($responseString);
        $this->errors = isset($this->response->errors) ? $this->response->errors : [];
    }

    public function getArrayResult()
    {
        if ($this->isSuccess()) {
            return $this->response;
        }

        return $this->errors;
    }

    public function get($field)
    {
        if ($this->isSuccess()) {
            return property_exists($this->response, $field) ? $this->response->{$field} : null;
        }

        return null;
    }

    public function isSuccess()
    {
        return (count($this->errors) <= 0);
    }

    public function getCode()
    {
        return $this->errors[0]->code;
    }

    public function getMessage()
    {
        return $this->errors[0]->message;
    }
}