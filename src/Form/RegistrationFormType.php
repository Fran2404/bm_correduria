<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Por favor, ingresa tu email']),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank(['message' => 'Por favor, ingresa una contraseña']),
                    new Length(['min' => 6, 'minMessage' => 'La contraseña debe tener al menos 6 caracteres']),
                ],
            ])
            ->add('nombre', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Por favor, ingresa tu nombre']),
                ],
            ])
            ->add('telefono', TextType::class, [
                'required' => false,
            ])
            ->add('direccion', TextType::class, [
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null, // No mapeamos directamente a una entidad
        ]);
    }
}