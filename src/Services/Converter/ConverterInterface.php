<?php

namespace Bomjarka\WordToPdfConverter\Services\Converter;

interface ConverterInterface
{
    public function convert(string $documentPath);
}
