<?php

namespace Bomjarka\WordToPdfConverter\Tests\Unit;

use Bomjarka\WordToPdfConverter\Services\Converter\PDFConverter;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PHPUnit\Framework\TestCase;

class PDFConverterTest extends TestCase
{
    public const STORAGE_PATH = 'public/documents/test';

    /**
     * @throws Exception
     */
    private function createWordFile($fileName = null)
    {
        $phpWord = new PhpWord();
        $phpWord->addSection()->addText('SOME TEXT');
        IOFactory::createWriter($phpWord)->save($fileName);

        return $fileName;
    }

    /**
     * @throws Exception
     */
    public function test_pdf_converter_can_convert_to_pdf(): void
    {
        $pdfConverter = new PDFConverter();
        $file = $this->createWordFile('Test.docx');
        $this->assertFileExists($file);
        $convertedFile = $pdfConverter->convert($file);
        $this->assertFileExists($convertedFile);
        $this->assertEquals(strstr($convertedFile, '.', true), strstr($file, '.', true));

        unlink($file);
        unlink($convertedFile);
    }
}