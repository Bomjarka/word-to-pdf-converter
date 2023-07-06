<?php

namespace Bomjarka\WordToPdfConverter\Services\Repository;

interface RepositoryInterface
{
    public function getFilePath(string $fileName);

    public function fileExists(string $fileName);

    public function deleteFile(string $fileName);
}
