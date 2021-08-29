<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FrontendUrlGenerator extends AbstractExtension
{
    private string $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('frontend_url', [$this, 'path'], ['is_safe' => ['html']]),
        ];
    }

    public function path(string $path, array $params = []): string
    {
        return $this->baseUrl
            . (!empty($path) ? '/' . $path : '')
            . (count($params) > 0 ? '?' . http_build_query($params) : '');
    }
}
