<?php

declare(strict_types=1);

namespace App\Event\Listener;

use App\Event\Profile\ShowEvent;
use App\Model\Entity\Common\Id;
use App\Model\UseCase\Metric\View;

class MetricListener
{
    private View\Add\Handler $handler;

    public function __construct(View\Add\Handler $handler)
    {
        $this->handler = $handler;
    }

    public function onShow(ShowEvent $event): void
    {
        $command = new View\Add\Command();
        $command->id = Id::next()->getValue();
        $command->userCardId = $event->getUserCardId();
        $command->profileId = $event->getProfileId();

        $this->handler->handle($command);
    }
}
