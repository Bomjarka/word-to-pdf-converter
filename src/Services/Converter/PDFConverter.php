<?php

namespace Bomjarka\WordToPdfConverter\Services\Converter;

use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;

class PDFConverter implements ConverterInterface
{

    private const FILE_EXTENSION = '.pdf';

    /**
     * @param string $documentPath
     * @return string
     * @throws Exception
     */
    public function convert(string $documentPath): string
    {
        $savePath = mb_strstr($documentPath, '.', true) . self::FILE_EXTENSION;
        /* Set the PDF Engine Renderer Path */
        if (file_exists('/var/www/vendor/dompdf/dompdf')) {
            $domPdfPath = '/var/www/vendor/dompdf/dompdf';
        } else {
            $domPdfPath = __DIR__ . '/../../../vendor/dompdf/dompdf';
        }

        Settings::setPdfRendererPath($domPdfPath);
        Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
        //Load word file
        $content = IOFactory::load($documentPath);

        //Save it into PDF
        $PDFWriter = IOFactory::createWriter($content, 'PDF');

        $this->save($PDFWriter, $savePath);

        return $savePath;
    }

    /**
     * @param $PDFWriter
     * @param $savePath
     * @return void
     */
    private function save($PDFWriter, $savePath): void
    {
        $PDFWriter->save($savePath);
    }
}
