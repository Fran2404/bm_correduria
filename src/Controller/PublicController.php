<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Entity\Poliza;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PublicController extends AbstractController
{
    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', '¡Mensaje enviado con éxito!');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/products', name: 'app_products')]
    public function products(): Response
    {
        return $this->render('products/index.html.twig');
    }

    #[Route('/cliente', name: 'app_client')]
    #[IsGranted('ROLE_USER')]
    public function clientArea(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $cliente = $user->getCliente();

        if (!$cliente) {
            // Crea un Cliente automáticamente si no existe
            $cliente = new Cliente();
            $cliente->setNombre('Cliente de ' . $user->getEmail());
            $cliente->setEmail($user->getEmail());
            $cliente->setTelefono('123456789'); // Valor por defecto
            $cliente->setDireccion('Dirección por defecto'); // Valor por defecto
            $user->setCliente($cliente);
            $entityManager->persist($cliente);
            $entityManager->persist($user);
            $entityManager->flush();

	    // Recarga el usuario para asegurar que los roles se actualicen
            $entityManager->refresh($user);
        }

        return $this->render('cliente/index.html.twig', [
            'cliente' => $cliente,
        ]);
    }

    #[Route('/cliente/poliza/{id}', name: 'app_show_policy')]
    #[IsGranted('ROLE_USER')]
    public function showPolicy(Poliza $poliza): Response
    {
        $user = $this->getUser();
        $cliente = $user->getCliente();

        if (!$cliente || $poliza->getCliente() !== $cliente) {
            throw $this->createAccessDeniedException('No tienes acceso a esta póliza.');
        }

        return $this->render('cliente/show_poliza.html.twig', [
            'poliza' => $poliza,
        ]);
    }
}
