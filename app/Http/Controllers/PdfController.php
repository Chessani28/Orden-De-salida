<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PdfController extends Controller
{
    public function downloadPdf($filename)
    {
        $path = storage_path('app/archivos/' . $filename);

        if (file_exists($path)) {
            return response()->download($path);
        } else {
            return redirect()->route('home')->with('error', 'El archivo no existe.');
        }
    }

    public function showPdf($filename)
    {
        $path = storage_path('app/archivos/'. $filename);

        if (file_exists($path)) {
            $mimeType = mime_content_type($path);


            if ($mimeType === 'application/pdf' || strpos($mimeType, 'image/') === 0) {
                return response()->file($path);
            } else {
                return response()->download($path, $filename);
            }
        } else {
            return redirect()->route('home')->with('error', 'El archivo no existe.');
        }
    }
}
