<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortalDocumentStorage
{
    public function __construct(private PdfSecurityScanner $scanner) {}

    public function storePdf(UploadedFile $file): string
    {
        $this->scanner->assertSafe($file);

        $filename = Str::uuid()->toString().'.pdf';
        Storage::disk('portal_documents')->putFileAs('', $file, $filename);

        return '/archivos/'.$filename;
    }
}
