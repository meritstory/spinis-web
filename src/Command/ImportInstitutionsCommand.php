<?php

declare(strict_types=1);

namespace App\Command;

use App\Message\ImportInstitutionsMessage;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:import-institutions',
    description: 'Dispatch a health care institutions import message',
)]
class ImportInstitutionsCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->messageBus->dispatch(new ImportInstitutionsMessage());

        $io->success('Institutions import message dispatched.');

        return Command::SUCCESS;
    }
}
