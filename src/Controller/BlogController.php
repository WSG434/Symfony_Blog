<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Filter\BlogFilter;
use App\Form\BlogFilterType;
use App\Form\BlogType;
use App\Form\CommentType;
use App\Message\ContentWatchMessage;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/blog')]
class BlogController extends AbstractController
{
    #[Route('/', name: 'app_blog_index', methods: ['GET'])]
    public function index(Request $request, BlogRepository $blogRepository): Response
    {
        $blogFilter = new BlogFilter();

        $form = $this->createForm(BlogFilterType::class, $blogFilter);
        $form->handleRequest($request);

//        добавление временного поля когда нужно на форме, но не нужно ни в DTO, ни в Entity;
//        if ($form->isSubmitted() && $form->isValid()) {
//           dd($form->get('content')->getData());
//        }



        return $this->render('blog/index.html.twig', [
            'blogs' => $blogRepository->findByBlogFilter($blogFilter),
            'searchForm' => $form->createView()
        ]);
    }

    #[Route('/new', name: 'app_blog_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
//        ContentWatchApi $contentWatchApi
        MessageBusInterface $bus
        ): Response
    {
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);
        $blog->setUser($this->getUser());

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($blog);
            $entityManager->flush();

            $bus->dispatch(new ContentWatchMessage($blog->getId()));

            return $this->redirectToRoute('app_blog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog/new.html.twig', [
            'blog' => $blog,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_blog_show', methods: ['GET'])]
    public function show(Blog $blog): Response
    {
        $form = $this->createForm(CommentType::class, null,
            [
                'action' => $this->generateUrl(
                'blog_add_comment',
                ['blog' => $blog->getId()])
            ]);
        return $this->render('blog/show.html.twig', [
            'blog' => $blog,
            'commentForm' => $form->createView()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_blog_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Blog $blog, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_blog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog/edit.html.twig', [
            'blog' => $blog,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_blog_delete', methods: ['POST'])]
    public function delete(Request $request, Blog $blog, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blog->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($blog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_blog_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/delete', name: 'app_blog_delete_get', methods: ['GET'])]
    public function deleteLink(Blog $blog, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($blog);
        $entityManager->flush();
        return $this->redirectToRoute('app_blog_index', [], Response::HTTP_SEE_OTHER);
    }
}
