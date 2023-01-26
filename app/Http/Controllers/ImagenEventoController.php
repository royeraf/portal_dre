<?php

namespace App\Http\Controllers;
use App\Models\ImagenEvento;
use App\Models\Galeria;
use Illuminate\Http\Request;
use DB;
class ImagenEventoController extends Controller
{
    public function index(){
        $data['registros']=Galeria::select(DB::raw('id, titulo, descripcion, fecha_publicacion,(select archivo_img from imgeventos where idgaleria=galeria.id limit 1) as img'))->paginate(10);
        return view('intranet/imgeventos/inicio', $data);
    }
    public function create(){//galeria
        return view('intranet/imgeventos/create');
    }
    public function store(Request $request){
        $galeria = new Galeria();
        $galeria->titulo = $request->titulo;
        $galeria->descripcion = $request->descripcion;
        $galeria->fecha_publicacion = $request->fecha_publicacion;        
        $galeria->save();
        return redirect()->route('galeria');
    }
    public function storeimagen(Request $request){
        $imagenevento = new ImagenEvento();
        if($request->hasFile('archivo_img')){
            $file = $request->file('archivo_img');
            $filename = time().'.'.$file->extension();
            $imagenevento->archivo_img=$filename;
            $file->move(public_path('img/imageneventos'), $filename);            
        }
        $imagenevento->idgaleria=$request->idgaleria;
        $imagenevento->save();
        return redirect()->route('galeria.show', $imagenevento->idgaleria);        
    }
    public function destroy(Galeria $galeria){
        $galeria->delete();
        return redirect()->route('galeria');
    }
    public function destroyarchivo(ImagenEvento $imagenevento){
        $image_path = public_path('img/imageneventos/').$imagenevento->archivo_img;        
        if ($imagenevento->archivo_img!=null && file_exists($image_path)){
            unlink($image_path);
        }
        $imagenevento->delete();
        return redirect()->route('galeria');
    }
    public function edit(Galeria $galeria){
        $data['galeria']=$galeria;
        return view('intranet/imgeventos/edit', $data);
    }
    public function update(Galeria $galeria, Request $request){
        $galeria->titulo=$request->titulo;
        $galeria->descripcion=$request->descripcion;
        $galeria->fecha_publicacion=$request->fecha_publicacion;        
        $galeria->save();
        return redirect()->route('galeria');
    }
    public function updatearchivo(ImagenEvento $imagenevento, Request $request){
        $imagenevento->titulo=$request->titulo;
        $imagenevento->descripcion=$request->descripcion;
        if($request->hasFile('archivo_img')){
            $file = $request->file('archivo_img');
            $image_path = public_path('img/imageneventos/').$imagenevento->archivo_img;              
            $filename = substr($imagenevento->archivo_img, 0, -4).'.'.$file->extension();
            $imagenevento->archivo_img=$filename;
            if (file_exists($image_path)){
                unlink($image_path);
            }
            $file->move(public_path('img/imageneventos'), $filename); 
        }
        $imagenevento->save();
        return redirect()->route('imagenevento');
    }
    public function show(Galeria $galeria){
        $data['galeria']=$galeria;
        $data['imagenes']=ImagenEvento::where('idgaleria', $galeria->id)->get();
        return view('intranet/imgeventos/showgaleria', $data);
    }
    public function agregarimagen(Galeria $galeria){
        $data['galeria']=$galeria;
        return view('intranet/imgeventos/agregarimagen', $data);
    }
}
