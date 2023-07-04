<?php

namespace Bomjarka\WordToPdfConverter\Services\Repository;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileSystemRepository implements RepositoryInterface
{

    /**
     * @param $fileName
     * @return bool
     */
    public function fileExists($fileName): bool
    {
        return Storage::exists($fileName);
    }

    /**
     * @param $fileName
     * @return string|null
     */
    public function getFilePath($fileName): ?string
    {
        if ($this->fileExists($fileName)) {
            return Storage::path($fileName);
        }

        return null;
    }

    /**
     * @param $fileName
     * @return void
     */
    public function saveFile($fileName, $storagePath): void
    {
        /** @var UploadedFile $fileName */
        $fileName->storeAs($storagePath, $fileName->getClientOriginalName());
    }

    /**
     * @param $fileName
     * @return void
     */
    public function deleteFile($fileName): void
    {
        if ($this->fileExists($fileName)) {
            Storage::delete($fileName);
        }
    }
}
