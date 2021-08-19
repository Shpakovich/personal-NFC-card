<?php

declare(strict_types=1);

namespace App\Model\Service\Storage;

class File
{
    private string $path;
    private string $name;

    public function __construct(string $path, string $name)
    {
        $this->path = $path;
        $this->name = $name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
