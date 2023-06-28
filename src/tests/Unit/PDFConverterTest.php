<?php

namespace Bomjarka\WordToPdfConverter\tests\Unit;

use Bomjarka\WordToPdfConverter\Services\Converter\PDFConverter;
use Bomjarka\WordToPdfConverter\tests\TestCase;
use Illuminate\Http\Testing\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PDFConverterTest extends TestCase
{
    /**
     * @param $fileName
     * @return File
     */
    private function createFile($fileName = null): File
    {
        return UploadedFile::fake()->create($fileName ?? Str::random(10) . '.docx');
    }

    public function test_converter_can_convert_document(): void
    {
        $pdfConverter = new PDFConverter();
        Storage::fake('documents');
        $file = $this->createFile();
        Storage::disk('documents')->put($file->getClientOriginalName(), '');
        $convertedFileName = mb_strstr($file->getClientOriginalName(), '.', true) . '.pdf';

        $pdfConverter->convert(Storage::disk('documents')->path($file->getClientOriginalName()));
        Storage::disk('documents')->assertExists($convertedFileName);
    }
}
