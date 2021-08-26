<?php

declare(strict_types=1);

namespace App\Model\UseCase\Profile\Theme\Change;

use App\Model\Entity\Common\Id;
use App\Model\Flusher;
use App\Model\Repository\Profile\ProfileRepository;
use App\Model\Repository\Profile\ThemeRepository;

class Handler
{
    private ProfileRepository $profiles;
    private ThemeRepository $themes;
    private Flusher $flusher;

    public function __construct(
        ProfileRepository $profiles,
        ThemeRepository $themes,
        Flusher $flusher
    ) {
        $this->profiles = $profiles;
        $this->themes = $themes;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $profile = $this->profiles->getById(new Id($command->profileId));
        $theme = $this->themes->getById(new Id($command->themeId));

        if (!$profile->getUser()->getId()->isEqual(new Id($command->userId))) {
            throw new \DomainException('This profile is not yours.');
        }

        $profile->setTheme($theme);
        $this->flusher->flush();
    }
}
