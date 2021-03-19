<?php

namespace App\Store\Event;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class RequestSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * RequestSubscriber constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            RequestEvent::class => [
                ['onKernelRequest', 127]
            ]
        ];
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if ($event->getRequest()->getUser() instanceof User) {
            $locale = $event->getRequest()->getUser()->getLocale();
        }

        if ($event->getRequest()->query->has("locale")) {
            $event->getRequest()->getSession()->set("locale", $event->getRequest()->query->get("locale"));

            if ($event->getRequest()->getUser() instanceof User) {
                $user = $this->entityManager->getRepository(User::class)->find($event->getRequest()->getUser()->getId());
                $this->updateUserLocale($user, $event->getRequest()->query->get("locale"));
            }
        }

        if ($event->getRequest()->getSession()->has("locale")) {
            $locale = $event->getRequest()->getSession()->get("locale");
        }

        if (isset($locale)) {
            $event->getRequest()->setLocale($locale);
        }
    }

    private function updateUserLocale($user, $locale)
    {
        $user->setLocale($locale);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
