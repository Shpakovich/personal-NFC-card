<?php

declare(strict_types=1);

namespace App\Model\Service\Storage;

use League\Flysystem\FilesystemOperator;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Storage
{
    private FilesystemOperator $storage;
    private string $baseUrl;

    public function __construct(FilesystemOperator $storage, string $baseUrl)
    {
        $this->storage = $storage;
        $this->baseUrl = $baseUrl;
    }

    public function url(string $path): string
    {
        return $this->baseUrl . DIRECTORY_SEPARATOR . $path;
    }

    public function upload(UploadedFile $uploadedFile): File
    {
        $path = date('Y/m/d');
        $name = Uuid::uuid4()->toString() . '.' . $uploadedFile->getClientOriginalExtension();

        $this->storage->createDirectory($path);
        $stream = fopen($uploadedFile->getRealPath(), 'rb+');
        $this->storage->writeStream($path . '/' . $name, $stream);
        fclose($stream);

        return new File($path, $name);
    }

    public function delete(string $path): void
    {
        $this->storage->delete($path);
    }
}
