<?php

namespace Bomjarka\WordToPdfConverter\Tests\Unit;

use Bomjarka\WordToPdfConverter\Services\Repository\FileSystemRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class FileSystemRepositoryTest extends TestCase
{
    private function createFile($fileName = null)
    {
        return UploadedFile::fake()->create($fileName ?? Str::random(10) . '.docx');
    }

    public function test_assert_true_is_true()
    {
        $fsRepository = new FileSystemRepository();
        $file = $this->createFile('document.docx');
        $fsRepository->saveFile($file, 'public/documents');
        $this->assertTrue(true);
    }
}