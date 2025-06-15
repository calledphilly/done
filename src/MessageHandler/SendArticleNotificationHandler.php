<?php

namespace App\MessageHandler;

use App\Message\SendArticleNotification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Entity\Notification;
use App\Repository\ArticleRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;


#[AsMessageHandler]
final class SendArticleNotificationHandler{

    public function __construct(
        private ArticleRepository $articleRepository,
        private MailerInterface $mailer,
        private LoggerInterface $logger,
        private EntityManagerInterface $entityManager
    ) {}
    public function __invoke(SendArticleNotification $message): void
    {
        $article = $this->articleRepository->find($message->getArticleId());

        if (!$article) {
            $this->logger->error('❌ Article non trouvé pour notification.');
            return;
        }

        $email = (new Email())
            ->from('no-reply@monsite.local')
            ->to('admin@example.com')
            ->subject('📰 Nouvel article publié')
            ->text("L'article \"{$article->getTitle()}\" a été publié par {$article->getUser()->getEmail()}.");

        $this->mailer->send($email);

        $notification = new Notification();
        $notification
            ->setLabel("Nouvel article : {$article->getTitle()}")
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUser($article->getUser());

        $this->entityManager->persist($notification);
        $this->entityManager->flush();

        $this->logger->info("✅ Notification envoyée à l'admin pour l'article #{$article->getId()}");
    }
}
