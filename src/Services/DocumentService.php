<?php
declare(strict_types=1);

namespace Bomjarka\WordToPdfConverter\Services;

use Bomjarka\WordToPdfConverter\Services\Converter\ConverterInterface;
use Bomjarka\WordToPdfConverter\Services\Repository\RepositoryInterface;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\TemplateProcessor;


class DocumentService
{
    public function __construct(
        private ConverterInterface  $converter,
        private RepositoryInterface $fileRepository,
        private $storagePath,
    )
    {
    }

    /**
     * @param $documentName
     * @return string
     */
    private function constructStorageFilePath($documentName): string
    {
        return $this->storagePath . '/' . $documentName;
    }

    /**
     * @param string $documentName
     * @return bool
     */
    public function fileExists(string $documentName): bool
    {
        return $this->fileRepository->fileExists($this->constructStorageFilePath($documentName));
    }

    /**
     * @param string $documentName
     * @return string
     */
    private function getFilePath(string $documentName): string
    {
        return $this->fileRepository->getFilePath($this->constructStorageFilePath($documentName));
    }


    /**
     * @throws CopyFileException
     * @throws CreateTemporaryFileException
     */
    public function changeTemplate(string $documentName, $vars = null): void
    {
        $templateProcessor = new TemplateProcessor($this->getFilePath($documentName));
        if ($vars) {
            foreach ($vars as $var => $val) {
                $templateProcessor->setValue($var, $val);
            }
        }
        $templateProcessor->saveAs($this->getFilePath($documentName));
    }


    public function convert(string $documentName)
    {
        $convertedFile = $this->converter->convert($this->getFilePath($documentName));
        $this->deleteFile($this->constructStorageFilePath($documentName));

        return $convertedFile;
    }

    /**
     * @param string $documentName
     * @return void
     */
    private function deleteFile(string $documentName): void
    {
        $this->fileRepository->deleteFile($documentName);
    }

    /**
     * @param string $documentName
     * @return string[]
     * @throws CopyFileException
     * @throws CreateTemporaryFileException
     */
    public function getVariables(string $documentName): array
    {
        return (new TemplateProcessor($this->getFilePath($documentName)))->getVariables();
    }
}
