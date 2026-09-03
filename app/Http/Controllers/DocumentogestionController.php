<?php

namespace App\Http\Controllers;
use App\Models\Documentogestion;
use App\Models\Archivodocumentogestion;
use App\Services\PortalDocumentStorage;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DocumentogestionController extends Controller
{
    public function index(){
        $data['registros']=Documentogestion::paginate(10);
        return view('intranet/documentogestion/inicio', $data);
    }
    public function store(Request $request){
        $documentogestion = new Documentogestion();
        $documentogestion->titulo = $request->titulo;
        $documentogestion->save();
        return redirect()->route('Documentogestion');
    }
    public function store2(Request $request, Documentogestion $Documentogestion, PortalDocumentStorage $storage){
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'url_archivo' => ['nullable', 'string', 'max:1000', 'required_without:file'],
            'file' => ['nullable', 'file', 'mimes:pdf', 'max:20480', 'required_without:url_archivo'],
        ]);

        try {
            $url = $request->hasFile('file')
                ? $storage->storePdf($request->file('file'))
                : trim((string) $validated['url_archivo']);
        } catch (\RuntimeException $exception) {
            throw ValidationException::withMessages(['file' => $exception->getMessage()]);
        }

        $archivodocumentogestion = new Archivodocumentogestion();
        $archivodocumentogestion->nombre = $validated['nombre'];
        $archivodocumentogestion->url_archivo = $url;
        $archivodocumentogestion->id_documentogestion = $Documentogestion->id;
        $archivodocumentogestion->save();
        return redirect()->route('Documentogestion.show', $Documentogestion);
    }
    public function destroy(Documentogestion $Documentogestion){
        $Documentogestion->delete();
        return redirect()->route('Documentogestion');
    }
    public function destroy2(Archivodocumentogestion $archivoDocumentogestion){
        $id=$archivoDocumentogestion->id_documentogestion;
        $archivoDocumentogestion->delete();
        return redirect()->route('Documentogestion.show', $id);
    }
    public function show(Documentogestion $Documentogestion){
        $data['registros']=Archivodocumentogestion::where('id_documentogestion', $Documentogestion->id)->paginate(10);
        $data['Documentogestion']=$Documentogestion;
        return view('intranet/documentogestion/show', $data);
    }
}
