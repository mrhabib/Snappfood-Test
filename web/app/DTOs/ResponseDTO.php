<?php

namespace App\DTOs;

class ResponseDTO
{
    public string $message;
    public int $status;
    public array $data;

    public function __construct(string $message, int $status = 200, array $data = [])
    {
        $this->message = $message;
        $this->status = $status;
        $this->data = $data;
    }

    public static function create( $message , $status = 200 , $data = [] ): self
    {
        return new self($message , $status , $data);
    }

    public function __call($method, $parameters)
    {
        if (strpos($method, 'get') === 0) {
            $property = lcfirst(substr($method, 3));
            return $this->$property;
        }

        if (strpos($method, 'set') === 0) {
            $property = lcfirst(substr($method, 3));
            $this->$property = $parameters[0];
            return $this;
        }

        throw new \BadMethodCallException("Method $method does not exist.");
    }

}

