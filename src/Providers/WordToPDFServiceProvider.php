<?php

namespace Bomjarka\WordToPdfConverter\Providers;

use Bomjarka\WordToPdfConverter\Services\Converter\ConverterInterface;
use Bomjarka\WordToPdfConverter\Services\Converter\PDFConverter;
use Bomjarka\WordToPdfConverter\Services\DocumentService;
use Bomjarka\WordToPdfConverter\Services\Repository\FileSystemRepository;
use Bomjarka\WordToPdfConverter\Services\Repository\RepositoryInterface;
use Illuminate\Support\ServiceProvider;

class WordToPDFServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/filesystems.php', 'disks');

        $this->app->bind(ConverterInterface::class, PDFConverter::class);
        $this->app->bind(RepositoryInterface::class, FileSystemRepository::class);
        $this->app->bind(DocumentService::class, function () {
            return new DocumentService(
                new PDFConverter(),
                new FileSystemRepository(),
                config('filesystems.disks.documents.path')
            );
        });

    }
}