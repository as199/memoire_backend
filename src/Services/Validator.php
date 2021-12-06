<?php

namespace App\Services;

use ApiPlatform\Core\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;

class Validator
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;


    /**
     * ValidatorPost constructor.
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     */
    public function __construct(ValidatorInterface $validator,SerializerInterface $serializer)
    {
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    public function ValidatePost($data): string
    {
        $errorString ='';
        $error = $this->validator->validate($data);
        if(isset($error) && $error >0){ $errorString = $this->serializer->serialize($error,'json');}
        return $errorString;
    }
}
