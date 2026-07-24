<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\ImportInstitutionsMessage;
use App\Service\Lspskp\InstitutionImporter;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class ImportInstitutionsHandler
{
    public function __construct(
        private InstitutionImporter $importer,
    ) {
    }

    public function __invoke(ImportInstitutionsMessage $message): void
    {
        $this->importer->import();
    }
}
