<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Admin;
use App\Entity\RoleEnum;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Create an admin user',
)]
class CreateAdminCommand extends Command
{
    public function __construct(
        private readonly AdminRepository $adminRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Admin email')
            ->addArgument('password', InputArgument::REQUIRED, 'Admin password');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = trim((string) $input->getArgument('email'));
        $password = (string) $input->getArgument('password');

        if ($email === '' || $password === '') {
            $io->error('Email and password are required.');

            return Command::FAILURE;
        }

        if ($this->adminRepository->findOneByEmail($email) !== null) {
            $io->success(sprintf('Admin "%s" already exists, skipping.', $email));

            return Command::SUCCESS;
        }

        $admin = (new Admin())
            ->setEmail($email)
            ->setRoles([RoleEnum::ADMIN->value])
            ->setActive(true);

        $admin->setPassword($this->passwordHasher->hashPassword($admin, $password));

        $this->entityManager->persist($admin);
        $this->entityManager->flush();

        $io->success(sprintf('Admin "%s" created.', $email));

        return Command::SUCCESS;
    }
}
