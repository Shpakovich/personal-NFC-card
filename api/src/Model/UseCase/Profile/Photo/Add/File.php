<?php

declare(strict_types=1);

namespace App\Model\UseCase\Profile\Photo\Add;

class File
{
    public string $path;
    public string $name;

    public function __construct(string $path, string $name)
    {
        $this->path = $path;
        $this->name = $name;
    }

    public function getFullPath(): string
    {
        return $this->path . DIRECTORY_SEPARATOR . $this->name;
    }
}
