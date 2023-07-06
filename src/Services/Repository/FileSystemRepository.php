<?php

namespace Bomjarka\WordToPdfConverter\Services\Repository;

class FileSystemRepository implements RepositoryInterface
{
    /**
     * @param string $fileName
     * @return bool
     */
    public function fileExists(string $fileName): bool
    {
        return file_exists($fileName);
    }

    /**
     * @param string $fileName
     * @return string|null
     */
    public function getFilePath(string $fileName): ?string
    {
        if ($this->fileExists($fileName)) {
            return $fileName;
        }

        return null;
    }

    /**
     * @param string $fileName
     * @return void
     */
    public function deleteFile(string $fileName): void
    {
        if ($this->fileExists($fileName)) {
            unlink($fileName);
        }
    }
}
