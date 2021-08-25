<?php

declare(strict_types=1);

namespace App\Model\UseCase\Profile\Theme\Edit;

use App\Model\Entity\Common\Id;
use App\Model\Flusher;
use App\Model\Repository\Profile\ThemeRepository;

class Handler
{
    private ThemeRepository $themes;
    private Flusher $flusher;

    public function __construct(ThemeRepository $themes, Flusher $flusher)
    {
        $this->themes = $themes;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $theme = $this->themes->getById(new Id($command->id));

        $theme
            ->setName($command->name)
            ->setCode($command->code);

        $this->flusher->flush();
    }
}
