<?php

namespace App\Twig;

use App\Repository\NotificationRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class AppExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(
        private NotificationRepository $notificationRepository,
        private Security $security
    ) {}

    public function getGlobals(): array
    {
        $user = $this->security->getUser();

        $count = 0;
        if ($user) {
            $count = $this->notificationRepository->count([
                'user' => $user,
                'isRead' => false
            ]);
        }

        return ['unreadNotificationCount' => $count];
    }
}