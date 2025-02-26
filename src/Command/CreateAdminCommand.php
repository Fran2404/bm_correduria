<?php

namespace App\Command;

use App\Entity\Usuario;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

class CreateAdminCommand extends Command
{
     // Nombre del comando
    private $passwordHasher;
    private $entityManager;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('app:create-admin')
            ->setDescription('Crea un usuario administrador');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $usuario = new Usuario();
        $usuario->setEmail('admin@bmcorreduria.com');
        $usuario->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword($usuario, 'admin123');
        $usuario->setPassword($hashedPassword);

        $this->entityManager->persist($usuario);
        $this->entityManager->flush();

        $output->writeln('Admin creado!');
        return Command::SUCCESS;
    }
}
