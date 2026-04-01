<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class EPRController extends Controller
{
    public function index()
    {
        $data['menus'] = Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $data['submenus'] = Menu::whereNotNull('categoriamenu')->get();
        
        // URLs de los PDFs con iframes de Heyzine
        $data['pdfs'] = [
            [
                'id' => 1,
                'titulo' => 'PER Resumen',
                'descripcion' => 'Documento resumen del PER',
                'archivo' => 'epr_resumen.pdf',
                'iframe_url' => 'https://heyzine.com/flip-book/de73480f70.html',
                'icono' => 'fas fa-file-pdf'
            ],
            [
                'id' => 2,
                'titulo' => 'PER Completo', 
                'descripcion' => 'Documento completo del PER',
                'archivo' => 'epr_completo.pdf',
                'iframe_url' => 'https://heyzine.com/flip-book/f8f31c14a3.html',
                'icono' => 'fas fa-book'
            ]
        ];
        
        return view('paginas.epr', $data);
    }

    public function showPdf($id)
    {
        $data['menus'] = Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $data['submenus'] = Menu::whereNotNull('categoriamenu')->get();
        
        // Definir los PDFs disponibles con iframes de Heyzine
        $pdfs = [
            1 => [
                'titulo' => 'PER Resumen',
                'archivo' => 'epr_resumen.pdf',
                'iframe_url' => 'https://heyzine.com/flip-book/de73480f70.html'
            ],
            2 => [
                'titulo' => 'PER Completo',
                'archivo' => 'epr_completo.pdf',
                'iframe_url' => 'https://heyzine.com/flip-book/f8f31c14a3.html'
            ]
        ];
        
        if (!isset($pdfs[$id])) {
            abort(404, 'Documento no encontrado');
        }
        
        $data['pdf'] = $pdfs[$id];
        $data['pdfId'] = $id;
        
        return view('paginas.epr-viewer', $data);
    }

    /**
     * Método helper para obtener la ruta completa del PDF
     */
    private function getPdfPath($filename)
    {
        return public_path('../../public_html/img/epr/' . $filename);
    }

    /**
     * Método para servir el PDF directamente (para descargas)
     */
    public function servePdf($id)
    {
        $pdfs = [
            1 => 'epr_resumen.pdf',
            2 => 'epr_completo.pdf'
        ];

        if (!isset($pdfs[$id])) {
            abort(404, 'Documento no encontrado');
        }

        $filename = $pdfs[$id];
        $filepath = $this->getPdfPath($filename);

        if (!file_exists($filepath)) {
            abort(404, 'Archivo PDF no encontrado en: ' . $filepath);
        }

        return response()->file($filepath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    /**
     * Método para descargar el PDF
     */
    public function downloadPdf($id)
    {
        $pdfs = [
            1 => 'epr_resumen.pdf',
            2 => 'epr_completo.pdf'
        ];

        if (!isset($pdfs[$id])) {
            abort(404, 'Documento no encontrado');
        }

        $filename = $pdfs[$id];
        $filepath = $this->getPdfPath($filename);

        if (!file_exists($filepath)) {
            abort(404, 'Archivo PDF no encontrado');
        }

        return response()->download($filepath, $filename);
    }
}