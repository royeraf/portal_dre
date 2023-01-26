<?php

namespace App\Http\Controllers;
use App\Models\Archivo;
use Illuminate\Http\Request;

class ArchivoController extends Controller
{
    public function index(){
        $data['archivos']=Archivo::paginate(10);
        return view('intranet/archivos/create', $data); 
    }
    public function store(Request $request){
        $archivo = new Archivo();
        $archivo->nombre=$request->nombre;
        $archivo->categoria=$request->categoria;
        if($request->hasFile('file')){
            $file = $request->file('file');
            $filename = time().'.'.$file->extension();
            $archivo->link=$filename;
            $file->move(public_path('archivos'), $filename);   
        }else{
            echo 'NO SUBIO EL ARCHIVO';
        }

        $archivo->save();
        return redirect()->route('archivo');
    }
    public function destroy(Archivo $archivo){
        if($archivo->link!=null){
            $file_path = public_path('archivos/').$archivo->link;        
            if (file_exists($file_path)){
                unlink($file_path);
            }
        }
        $archivo->delete();
        return redirect()->route('archivo');
    }
    public function edit(Archivo $archivo){
        $data['archivo']=$archivo;
        return view('intranet/archivos/edit', $data); 
    }
    public function update(Request $request, Archivo $archivo){
        $archivo->nombre = $request->nombre;
        $archivo->categoria = $request->categoria;

        if($request->hasFile('file')){
            $file = $request->file('file');
            $file_path = public_path('archivos/').$archivo->link; 
            $filename = substr($archivo->link, 0, -4).'.'.$file->extension();
            $archivo->link=$filename;
            if ($noticia->link!=null && file_exists($file_path)){
                unlink($file_path);
            }
            $file->move(public_path('img/archivos'), $filename); 
        }
        $archivo->save();
        return redirect()->route('archivos.edit', $archivo);
    }
}
