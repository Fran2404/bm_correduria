<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Poliza;

#[Route('/')]
class SecurityController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/cliente', name: 'app_cliente')]
    #[IsGranted('ROLE_USER')]
    public function cliente(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $cliente = $user->getCliente();
        $polizas = $cliente ? $entityManager->getRepository(Poliza::class)->findBy(['cliente' => $cliente]) : [];
        return $this->render('cliente/index.html.twig', [
            'controller_name' => 'Client Area',
            'cliente' => $cliente,
            'polizas' => $polizas,
        ]);
    }

    #[Route('/cliente/poliza/{id}', name: 'app_cliente_poliza_show', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function showPoliza(Poliza $poliza): Response
    {
        $user = $this->getUser();
        $cliente = $user->getCliente();
        if ($poliza->getCliente() !== $cliente) {
            throw $this->createAccessDeniedException('No tienes acceso a esta póliza.');
        }
        return $this->render('cliente/show_poliza.html.twig', [
            'poliza' => $poliza,
        ]);
    }
}
