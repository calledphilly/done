<?php
namespace App\EventListener;

use App\Entity\Article;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
class ArticleTimestampListener
{
    public function prePersist(Article $article, LifecycleEventArgs $event): void
    {
        if ($article->getCreatedAt() === null) {
            $article->setCreatedAt(new \DateTimeImmutable());
        }
    }

    public function preUpdate(Article $article, PreUpdateEventArgs $event): void
    {
      $now = new \DateTimeImmutable();
      $article->setUpdatedAt($now);
      $event->setNewValue('updatedAt', $now);
    }
}
