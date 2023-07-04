<?php

namespace Bomjarka\WordToPdfConverter\Services\Repository;

interface RepositoryInterface
{
    public function getFilePath($fileName);

    public function saveFile($fileName, $storagePath);

    public function fileExists($fileName);

    public function deleteFile($fileName);
}
