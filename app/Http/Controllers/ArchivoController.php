<?php

namespace App\Http\Controllers;
use App\Models\Archivo;
use App\Services\PortalDocumentStorage;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ArchivoController extends Controller
{
    public function index(){
        $data['archivos']=Archivo::paginate(10);
        return view('intranet/archivos/create', $data);
    }
    public function store(Request $request, PortalDocumentStorage $pdfStorage){
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'categoria' => ['required', 'in:Comunicado,Solicitud,Oficio,Resolucion'],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip', 'max:20480'],
        ]);
        $file = $validated['file'];
        $filename = $this->storeFile($file, $pdfStorage);

        $archivo = new Archivo();
        $archivo->nombre = $validated['nombre'];
        $archivo->categoria = $validated['categoria'];
        $archivo->link = $filename;
        $archivo->save();
        return redirect()->route('archivo');
    }
    public function destroy(Archivo $archivo){
        if ($archivo->link) {
            Storage::disk('portal_documents')->delete(basename($archivo->link));
        }
        $archivo->delete();
        return redirect()->route('archivo');
    }
    public function edit(Archivo $archivo){
        $data['archivo']=$archivo;
        return view('intranet/archivos/edit', $data);
    }
    public function update(Request $request, Archivo $archivo, PortalDocumentStorage $pdfStorage){
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'categoria' => ['required', 'in:Comunicado,Solicitud,Oficio,Resolucion'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip', 'max:20480'],
        ]);
        $archivo->nombre = $validated['nombre'];
        $archivo->categoria = $validated['categoria'];

        if($request->hasFile('file')){
            $file = $request->file('file');
            $filename = $this->storeFile($file, $pdfStorage);
            $previous = $archivo->link;
            $archivo->link = $filename;
            if ($previous) {
                Storage::disk('portal_documents')->delete(basename($previous));
            }
        }
        $archivo->save();
        return redirect()->route('archivos.edit', $archivo);
    }

    private function storeFile(UploadedFile $file, PortalDocumentStorage $pdfStorage): string
    {
        if (Str::lower($file->extension()) === 'pdf') {
            try {
                return basename($pdfStorage->storePdf($file));
            } catch (\RuntimeException $exception) {
                throw ValidationException::withMessages(['file' => $exception->getMessage()]);
            }
        }

        $filename = Str::uuid().'.'.Str::lower($file->extension());
        Storage::disk('portal_documents')->putFileAs('', $file, $filename);

        return $filename;
    }
}
