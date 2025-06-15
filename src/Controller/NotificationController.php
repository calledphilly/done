<?php

namespace App\Controller;

use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
final class NotificationController extends AbstractController
{
    #[Route('/notification', name: 'app_notifications')]
    public function index(NotificationRepository $notificationRepository): Response
    {
        $user = $this->getUser();
        $count = $notificationRepository->count(['user' => $user]);
        $notifications = $notificationRepository->findBy(['user' => $user], ['createdAt' => 'DESC']);
        return $this->render('notification/index.html.twig', [
            'controller_name' => 'NotificationController',
            'notifications' => $notifications,
            'unreadNotificationCount' => $notificationRepository->count([
                'user' => $user,
                'isRead' => false
            ]),
        ]);
    }

    #[Route('/notifications/count', name: 'app_notifications_count')]
    public function count(NotificationRepository $notificationRepository): JsonResponse
    {
        $user = $this->getUser();
        $count = $notificationRepository->count(['user' => $user]);

        return new JsonResponse(['count' => $count]);
    }
    #[Route('/notifications/mark-read', name: 'app_notifications_mark_read')]
    public function markAllAsRead(NotificationRepository $notificationRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $notifications = $notificationRepository->findBy(['user' => $user]);

        foreach ($notifications as $notification) {
            if (method_exists($notification, 'setIsRead')) {
                $notification->setIsRead(true);
            }
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_notifications');
    }
}


