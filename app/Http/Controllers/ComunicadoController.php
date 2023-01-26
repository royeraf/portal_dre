<?php

namespace App\Http\Controllers;
use App\Models\Comunicado;
use Illuminate\Http\Request;

class ComunicadoController extends Controller
{
    public function index(){
        $data['comunicados'] = Comunicado::paginate(10);
        return view('intranet/comunicados/inicio', $data);
    }
    public function create(){
        return view('intranet/comunicados/create');
    }
    public function store(Request $request){
        $comunicado = new Comunicado();
        $comunicado->titulo=$request->titulo;
        $comunicado->url=$request->url;
        if($request->hasFile('imagen')){
            $file = $request->file('imagen');
            $filename = time().$file->extension();
            $comunicado->imagen=$filename;
            $file->move(public_path('img/comunicados'), $filename);   
        }
        $comunicado->save();
        return redirect()->route('comunicado');
    }
    public function edit(Comunicado $comunicado){
        $data['comunicado']=$comunicado;
        return view('intranet/comunicados/edit', $data);
    }
    public function update(Comunicado $comunicado, Request $request){
        $comunicado->titulo = $request->titulo;
        $comunicado->url = $request->url;
        if($request->hasFile('imagen')){
            $file = $request->file('imagen');
            $image_path = public_path('img/comunicados/').$comunicado->imagen; 
            if ($comunicado->imagen!=null && file_exists($image_path)){
                unlink($image_path);
            }
            $filename = time().$file->extension();
            $comunicado->imagen=$filename;
            $file->move(public_path('img/comunicados'), $filename);   
        }
        $comunicado->save();
        return redirect()->route('comunicado');
    }
    public function destroy(Comunicado $comunicado){
        $comunicado->delete();
        return redirect()->route('comunicado');
    }
}
