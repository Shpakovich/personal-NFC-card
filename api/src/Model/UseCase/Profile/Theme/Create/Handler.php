<?php

declare(strict_types=1);

namespace App\Model\UseCase\Profile\Theme\Create;

use App\Model\Entity\Common\Id;
use App\Model\Entity\Profile\Theme;
use App\Model\Flusher;
use App\Model\Repository\Profile\ThemeRepository;

class Handler
{
    private ThemeRepository $themes;
    private Flusher $flusher;

    public function __construct(
        ThemeRepository $themes,
        Flusher $flusher
    ) {
        $this->themes = $themes;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        if ($this->themes->hasByCode($command->code)) {
            throw new \DomainException("The theme with code '{$command->code}' already exists.");
        }

        $theme = new Theme(
            new Id($command->id),
            $command->name,
            $command->code
        );

        $this->themes->add($theme);
        $this->flusher->flush();
    }
}
