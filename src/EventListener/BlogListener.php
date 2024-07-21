<?php
declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Blog;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: Blog::class)]
class BlogListener
{

    public function preUpdate(Blog $blog, PreUpdateEventArgs $event): void
    {
        // ... do something to notify the changes
        $em = $event->getObjectManager();
        $user = $em->getRepository(User::class)->find(1);
        $blog->setPercent('1');
    }
}
