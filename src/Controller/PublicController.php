<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class PublicController extends AbstractController
{
    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('public/about.html.twig');
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, ['label' => 'Nombre'])
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('message', TextareaType::class, ['label' => 'Mensaje'])
            ->add('send', SubmitType::class, ['label' => 'Enviar'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $email = (new Email())
                ->from($data['email'])
                ->to('info@bmcorreduria.com')
                ->subject('Nuevo mensaje de contacto')
                ->text($data['message']);

            $mailer->send($email);
            $this->addFlash('success', 'Mensaje enviado con éxito.');
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('public/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/products', name: 'app_products')]
    public function products(): Response
    {
        return $this->render('public/products.html.twig');
    }
}
