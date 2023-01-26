<?php

namespace App\Http\Controllers;
use App\Models\Area;
use App\Models\Directorio;
use Illuminate\Http\Request;

class DirectorioController extends Controller
{
    public function index(){
        $data['lista']=Directorio::paginate(10);
        return view('intranet/directorio/inicio', $data);
    }
    public function create(){
        $data['areas']=Area::get();
        return view('intranet/directorio/create', $data);        
    }
    public function store(Request $request){
        $directorio = new Directorio();
        $directorio->apenom = $request->apenom;
        $directorio->dni = $request->dni;
        $directorio->area = $request->area;
        $directorio->cargo = $request->cargo;
        $directorio->email = $request->email;
        $directorio->celular = $request->celular;
        if($request->hasFile('foto')){
            $file = $request->file('foto');
            $filename = $request->dni.'.'.$file->extension();
            $directorio->foto=$filename;
            $file->move(public_path('img/fotos'), $filename);   
        }
        $directorio->save();
        return redirect()->route('directorio');
    }
    public function destroy(Directorio $directorio){
        if($directorio->foto!=null){
            $image_path = public_path('img/fotos/').$directorio->foto;        
            if (file_exists($image_path)){
                unlink($image_path);
            }
        }
        $directorio->delete();
        return redirect()->route('directorio');
    }
    public function edit(Directorio $directorio){
        $data['areas']=Area::get();
        $data['directorio']=$directorio;
        return view('intranet/directorio/edit', $data);
    }
    public function update(Directorio $directorio, Request $request){
        $directorio->apenom = $request->apenom;
        $directorio->dni = $request->dni;
        $directorio->area = $request->area;
        $directorio->cargo = $request->cargo;
        $directorio->email = $request->email;
        $directorio->celular = $request->celular;
        if($request->hasFile('foto')){
            $file = $request->file('foto');
            $image_path = public_path('img/fotos/').$directorio->foto; 
            $filename = substr($directorio->foto, 0, -4).'.'.$file->extension();
            $directorio->foto=$filename;
            if ($directorio->foto!=null && file_exists($image_path)){
                unlink($image_path);
            }
            $file->move(public_path('img/fotos'), $filename); 
        }
        $directorio->save();
        return redirect()->route('directorio');
    }
}
