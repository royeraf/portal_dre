<?php

namespace App\Http\Controllers;
use App\Models\Convocatoria;
use App\Models\ArchivoConvocatoria;
use Illuminate\Http\Request;

class ConvocatoriaController extends Controller
{
    public function index(){
        $data['convocatorias']=Convocatoria::orderBy('fecha_inicio', 'desc')->paginate(10);
        return view('intranet/convocatorias/inicio', $data);
    }
    public function create(){
        return view('intranet/convocatorias/create');
    }
    public function store(Request $request){
        $convocatoria = new Convocatoria();
        $convocatoria->tipo = $request->tipo;
        $convocatoria->titulo = $request->titulo;
        $convocatoria->descripcion = $request->descripcion;
        $convocatoria->fecha_inicio = $request->fecha_inicio;
        $convocatoria->fecha_termino = $request->fecha_termino;
        $convocatoria->save();
        return redirect()->route('convocatoria');
    }
    public function destroy(Convocatoria $convocatoria){
        $convocatoria->delete();
        return redirect()->route('convocatoria');
    }
    public function edit(Convocatoria $convocatoria){
        $data['convocatoria']=$convocatoria;
        return view('intranet/convocatorias/edit', $data);
    }
    public function update(Convocatoria $convocatoria, Request $request){
        $convocatoria->tipo = $request->tipo;
        $convocatoria->titulo = $request->titulo;
        $convocatoria->descripcion = $request->descripcion;
        $convocatoria->fecha_inicio = $request->fecha_inicio;
        $convocatoria->fecha_termino = $request->fecha_termino;
        $convocatoria->estado = $request->estado;
        $convocatoria->save();
        return redirect()->route('convocatoria');
    }
    public function show(Convocatoria $convocatoria){
        $data['convocatoria']=$convocatoria;
        $data['archivos_convocatoria']=ArchivoConvocatoria::where('id_convocatoria', $convocatoria->id)->get();
        return view('intranet/convocatorias/show', $data); 
    }
    public function archivo_convocatoriacreate(Convocatoria $convocatoria){
        $data['convocatoria']=$convocatoria;
        return view('intranet/convocatorias/archivoconvocatoria', $data); 
    }
    public function archivoconvocatoriadestroy(ArchivoConvocatoria $archivoconvocatoria){
        $idconvocatoria =$archivoconvocatoria->id_convocatoria;
        $archivoconvocatoria->delete();
        return redirect()->route('convocatoria.show', $idconvocatoria);
    }
    public function archivocstore(Convocatoria $convocatoria, Request $request){
        $archivoconvocatoria = new ArchivoConvocatoria();
        $archivoconvocatoria->nom_archivo = $request->nom_archivo;
        $archivoconvocatoria->url_archivo = $request->url_archivo;    
        $archivoconvocatoria->etapa = $request->etapa;
        $archivoconvocatoria->id_convocatoria = $convocatoria->id;
        $archivoconvocatoria->save();
        return redirect()->route('convocatoria.show', $convocatoria->id);   
    
    }
}
