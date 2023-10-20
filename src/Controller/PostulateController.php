<?php

namespace App\Controller;

use App\Entity\Postulate;
use App\Form\AdminPosType;
use App\Form\PostulateType;
use App\Repository\PostulateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/postulate')]
class PostulateController extends AbstractController
{
    #[Route('/', name: 'app_postulate_index', methods: ['GET'])]
    public function index(PostulateRepository $postulateRepository): Response
    {
        return $this->render('postulate/index.html.twig', [
            'postulates' => $postulateRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_postulate_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $postulate = new Postulate();
        $form = $this->createForm(AdminPosType::class, $postulate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($postulate);
            $entityManager->flush();

            return $this->redirectToRoute('app_postulate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('postulate/new.html.twig', [
            'postulate' => $postulate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_postulate_show', methods: ['GET'])]
    public function show(Postulate $postulate): Response
    {
        return $this->render('postulate/show.html.twig', [
            'postulate' => $postulate,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_postulate_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Postulate $postulate, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdminPosType::class, $postulate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_postulate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('postulate/edit.html.twig', [
            'postulate' => $postulate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_postulate_delete', methods: ['POST'])]
    public function delete(Request $request, Postulate $postulate, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postulate->getId(), $request->request->get('_token'))) {
            $entityManager->remove($postulate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_postulate_index', [], Response::HTTP_SEE_OTHER);
    }
}
