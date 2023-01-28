<?php

namespace App\Http\Controllers;
use App\Models\Documentogestion;
use App\Models\Archivodocumentogestion;
use Illuminate\Http\Request;

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
    public function store2(Request $request, Documentogestion $Documentogestion){
        $archivodocumentogestion = new Archivodocumentogestion();
        $archivodocumentogestion->nombre = $request->nombre;
        $archivodocumentogestion->url_archivo = $request->url_archivo;
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
