<?php

namespace App\Events;

use App\Repository\UtilisateurRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JwtCreatedSubscriber
{
    private UtilisateurRepository $user;

    public function __construct(UtilisateurRepository $user){
        $this->user = $user;
    }
    public function updateJwtData(JWTCreatedEvent $event)
    {

        // On enrichit le data du Token
        $data = $event->getData();

        $res = $this->user->findBy(['username'=>$data['username']]);
        $data['status'] =$res[0]->getStatus();
        $data['id'] =  $res[0]->getId();

        $event->setData($data);
    }

}