<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Admin;
use App\Entity\RoleEnum;
use App\Repository\AdminRepository;
use App\Security\AdminPasswordPolicy;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

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
        private readonly AdminPasswordPolicy $passwordPolicy,
        private readonly TranslatorInterface $translator,
        private readonly ValidatorInterface $validator,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Admin email')
            ->addArgument('password', InputArgument::REQUIRED, 'Admin password')
            ->addArgument('first-name', InputArgument::OPTIONAL, 'First name', 'Admin')
            ->addArgument('last-name', InputArgument::OPTIONAL, 'Last name', 'Admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = trim((string) $input->getArgument('email'));
        $password = (string) $input->getArgument('password');
        $firstName = trim((string) $input->getArgument('first-name'));
        $lastName = trim((string) $input->getArgument('last-name'));

        if ($firstName === '') {
            $firstName = 'Admin';
        }

        if ($lastName === '') {
            $lastName = 'Admin';
        }

        if ($email === '') {
            $io->error('Email is required.');

            return Command::FAILURE;
        }

        $passwordErrorKeys = $this->passwordPolicy->validateAll($password);
        if ($passwordErrorKeys !== []) {
            $io->error(implode(' ', array_map(
                fn (string $errorKey): string => $this->translator->trans($errorKey, [
                    '%min%' => $this->passwordPolicy->getMinLength(),
                ]),
                $passwordErrorKeys,
            )));

            return Command::FAILURE;
        }

        if ($this->adminRepository->findOneByEmail($email) !== null) {
            $io->success(sprintf('Admin "%s" already exists, skipping.', $email));

            return Command::SUCCESS;
        }

        $admin = new Admin()
            ->setEmail($email)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setRoles([RoleEnum::SYSTEM_ADMIN->value])
            ->setActive(true);

        $violations = $this->validator->validate($admin);
        if (count($violations) > 0) {
            foreach ($violations as $violation) {
                $io->error((string) $violation->getMessage());
            }

            return Command::FAILURE;
        }

        $admin->setPassword($this->passwordHasher->hashPassword($admin, $password));

        $this->entityManager->persist($admin);
        $this->entityManager->flush();

        $io->success(sprintf('Admin "%s" created.', $email));

        return Command::SUCCESS;
    }
}
