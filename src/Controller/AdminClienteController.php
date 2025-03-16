<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Form\ClienteType;
use App\Repository\ClienteRepository;
use App\Repository\PolizaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminClienteController extends AbstractController
{
    #[Route('/', name: 'app_admin_dashboard', methods: ['GET'])]
    public function dashboard(ClienteRepository $clienteRepo, PolizaRepository $polizaRepo): Response
    {
        $numClientes = $clienteRepo->count([]);
        $numPolizas = $polizaRepo->count([]);
        $polizasActivas = $polizaRepo->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->where('p.fechaVencimiento > :now')
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getSingleScalarResult() ?? 0; // Devuelve 0 si no hay resultados

        return $this->render('admin/dashboard.html.twig', [
            'numClientes' => $numClientes,
            'numPolizas' => $numPolizas,
            'polizasActivas' => $polizasActivas,
        ]);
    }

    #[Route('/clientes/', name: 'app_admin_cliente_index', methods: ['GET'])]
    public function index(ClienteRepository $clienteRepository): Response
    {
        return $this->render('admin_cliente/index.html.twig', [
            'clientes' => $clienteRepository->findAll(),
        ]);
    }

    #[Route('/clientes/new', name: 'app_admin_cliente_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ClienteRepository $clienteRepository): Response
    {
        $cliente = new Cliente();
        $form = $this->createForm(ClienteType::class, $cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clienteRepository->save($cliente, true);
            return $this->redirectToRoute('app_admin_cliente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_cliente/new.html.twig', [
            'cliente' => $cliente,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/clientes/{id}', name: 'app_admin_cliente_show', methods: ['GET'])]
    public function show(Cliente $cliente): Response
    {
        return $this->render('admin_cliente/show.html.twig', [
            'cliente' => $cliente,
        ]);
    }

    #[Route('/clientes/{id}/edit', name: 'app_admin_cliente_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cliente $cliente, ClienteRepository $clienteRepository): Response
    {
        $form = $this->createForm(ClienteType::class, $cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clienteRepository->save($cliente, true);
            return $this->redirectToRoute('app_admin_cliente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_cliente/edit.html.twig', [
            'cliente' => $cliente,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/clientes/{id}', name: 'app_admin_cliente_delete', methods: ['POST'])]
    public function delete(Request $request, Cliente $cliente, ClienteRepository $clienteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cliente->getId(), $request->request->get('_token'))) {
            $clienteRepository->remove($cliente, true);
        }

        return $this->redirectToRoute('app_admin_cliente_index', [], Response::HTTP_SEE_OTHER);
    }
}
