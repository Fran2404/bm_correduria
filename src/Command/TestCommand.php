<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    

    protected function configure(): void
    {
        $this->setName('app:test')
            ->setDescription('Comando de prueba');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('¡Prueba exitosa!');
        return Command::SUCCESS;
    }
}
