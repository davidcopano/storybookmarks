<?php

namespace MainBundle\Listeners;

use Doctrine\ORM\EntityManager;
use MainBundle\Entity\UserConnection;
use MainBundle\Utilities\UserInfo;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginListener {

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();
        $userConnection = new UserConnection();
        $userConnection->setUser($user)
                    ->setIp(UserInfo::getIp())
                    ->setBrowser(UserInfo::getBrowser())
                    ->setDevice(UserInfo::getDevice())
                    ->setOperatingSystem(UserInfo::getOperatingSystem())
                    ->setUserAgent(UserInfo::getUserAgent());
        $this->entityManager->persist($userConnection);
        $this->entityManager->flush();
    }
}