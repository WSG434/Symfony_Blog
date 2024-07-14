<?php
declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\ContentWatchMessage;
use App\Repository\BlogRepository;
use App\Service\ContentWatchApi;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ContentWatchHandler
{
    public function __construct(
        private readonly ContentWatchApi $contentWatchApi,
        private readonly EntityManagerInterface $em,
        private readonly BlogRepository $blogRepository
    )
    {
    }

    public function __invoke(ContentWatchMessage $contentWatchJob) : void
    {
        $blogId = (int)$contentWatchJob->getContent();
        $blog = $this->blogRepository->find($blogId);


        $blog->setPercent(
            $this->contentWatchApi->checkText($blog->getText())
        );

        $this->em->persist($blog);
        $this->em->flush();
    }
}
