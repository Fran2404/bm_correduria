<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Entity\Cliente;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Obtener datos del formulario
            $data = $form->getData();

            // Crear el registro de Cliente
            $cliente = new Cliente();
            $cliente->setEmail($form->get('email')->getData());
            $cliente->setNombre($form->get('nombre')->getData());
            $cliente->setTelefono($form->get('telefono')->getData() ?? '');
            $cliente->setDireccion($form->get('direccion')->getData() ?? '');

            // Crear el registro de Usuario
            $user = new Usuario();
            $user->setEmail($form->get('email')->getData());
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData() // Accede directamente al campo
                )
            );
            $user->setCliente($cliente);

            // Asignar roles al usuario
            $user->setRoles(['ROLE_USER', 'ROLE_CLIENTE']);

            // Persistir ambos (Usuario y Cliente)
            $entityManager->persist($cliente);
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirigir al login tras registro exitoso
            $this->addFlash('success', '¡Registro exitoso! Por favor, inicia sesión.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}