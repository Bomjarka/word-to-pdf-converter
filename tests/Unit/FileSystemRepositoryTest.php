<?php

namespace Bomjarka\WordToPdfConverter\Tests\Unit;

use Bomjarka\WordToPdfConverter\Services\Repository\FileSystemRepository;
use FilesystemIterator;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class FileSystemRepositoryTest extends TestCase
{
    public const STORAGE_PATH = 'public/documents/test';
    private function createFile($fileName = null)
    {
        $fileName = $fileName ?? Str::random(10) . '.docx';
        file_put_contents($fileName, '123');

        return $fileName;
    }
    public function test_file_repository_can_check_file_exists(): void
    {
        $fsRepository = new FileSystemRepository();
        $file = $this->createFile();
        $this->assertFileExists($file);
        $this->assertTrue($fsRepository->fileExists($file));
        unlink($file);
    }
    public function test_file_repository_can_get_file_path(): void
    {
        $fsRepository = new FileSystemRepository();
        $file = $this->createFile();
        $this->assertFileExists($file);
        $this->assertEquals($fsRepository->getFilePath($file), $file);
        unlink($file);
    }
    public function test_file_repository_can_delete_file(): void
    {
        $fsRepository = new FileSystemRepository();
        $file = $this->createFile();
        $this->assertFileExists($file);
        $fsRepository->deleteFile($file);
        $this->assertFileDoesNotExist($file);
    }
}