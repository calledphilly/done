<?php

namespace App\Controller;

use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
final class NotificationController extends AbstractController
{
    #[Route('/notification', name: 'app_notification')]
    public function index(NotificationRepository $notificationRepository): Response
    {
        $user = $this->getUser();
        $count = $notificationRepository->count(['user' => $user]);
        $notifications = $notificationRepository->findBy(['user' => $user], ['createdAt' => 'DESC']);
        return $this->render('notification/index.html.twig', [
            'controller_name' => 'NotificationController',
            'notifications' => $notifications,
        ]);
    }

    #[Route('/notifications/count', name: 'app_notifications_count')]
    public function count(NotificationRepository $notificationRepository): JsonResponse
    {
        $user = $this->getUser();
        $count = $notificationRepository->count(['user' => $user]);

        return new JsonResponse(['count' => $count]);
    }
}
