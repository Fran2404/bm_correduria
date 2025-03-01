<?php

namespace App\Controller;

use App\Entity\Poliza;
use App\Form\PolizaType;
use App\Repository\PolizaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/poliza')]
final class AdminPolizaController extends AbstractController
{
    #[Route('/', name: 'app_admin_poliza_index', methods: ['GET'])]
    public function index(PolizaRepository $polizaRepository): Response
    {
        return $this->render('admin_poliza/index.html.twig', [
            'polizas' => $polizaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_poliza_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $poliza = new Poliza();
        $form = $this->createForm(PolizaType::class, $poliza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($poliza);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_poliza_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_poliza/new.html.twig', [
            'poliza' => $poliza,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_poliza_show', methods: ['GET'])]
    public function show(Poliza $poliza): Response
    {
        return $this->render('admin_poliza/show.html.twig', [
            'poliza' => $poliza,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_poliza_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Poliza $poliza, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PolizaType::class, $poliza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_poliza_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_poliza/edit.html.twig', [
            'poliza' => $poliza,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_poliza_delete', methods: ['POST'])]
    public function delete(Request $request, Poliza $poliza, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$poliza->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($poliza);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_poliza_index', [], Response::HTTP_SEE_OTHER);
    }
}
