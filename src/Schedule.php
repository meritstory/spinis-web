<?php

declare(strict_types=1);

namespace App;

use App\Message\ImportInstitutionsMessage;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule as SymfonySchedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;

#[AsSchedule]
class Schedule implements ScheduleProviderInterface
{
    public function getSchedule(): SymfonySchedule
    {
        return new SymfonySchedule()
            ->add(
                RecurringMessage::cron(
                    '0 1 * * *',
                    new ImportInstitutionsMessage(),
                    new \DateTimeZone('Europe/Vilnius'),
                ),
            )
        ;
    }
}
