<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Noticia;
class NoticiaController extends Controller
{
    public function index(){
        $data['noticias']=Noticia::paginate(5);
        return view('intranet/noticias/inicio', $data);
    }
    public function create(){     
        return view('intranet/noticias/create');
    }
    public function store(Request $request){
        $noticia = new Noticia();
        $noticia->titulo = $request->titulo;
        $noticia->descripcioncorta = $request->descripcioncorta;
        $noticia->contenido = $request->contenido;
        $noticia->iduser = $request->iduser;
        $noticia->fechapubli = $request->fechapubli;
        if($request->hasFile('img1')){
            $file = $request->file('img1');
            $filename = time().'1.'.$file->extension();
            $noticia->img1=$filename;
            $file->move(public_path('img/noticias'), $filename);   
            if($request->hasFile('img2')){
                $file = $request->file('img2');
                $filename = time().'2.'.$file->extension();
                $noticia->img2=$filename;
                $file->move(public_path('img/noticias'), $filename);  
                if($request->hasFile('img3')){
                    $file = $request->file('img3');
                    $filename = time().'3.'.$file->extension();
                    $noticia->img3=$filename;
                    $file->move(public_path('img/noticias'), $filename);   
                }
            }
        }
        $noticia->save();
        return redirect()->route('noticias');
    }
    public function destroy(Noticia $noticia){
        if($noticia->img1!=null){
            $image_path = public_path('img/noticias/').$noticia->img1;        
            if (file_exists($image_path)){
                unlink($image_path);
            }
            if($noticia->img2!=null){
                $image_path = public_path('img/noticias/').$noticia->img2;        
                if (file_exists($image_path)){
                    unlink($image_path);
                }
                if($noticia->img3!=null){
                    $image_path = public_path('img/noticias/').$noticia->img3;        
                    if (file_exists($image_path)){
                        unlink($image_path);
                    }
                }
            }
        }
        $noticia->delete();
        return redirect()->route('noticias');
    }
    public function edit(Noticia $noticia){
        $data['noticia']=$noticia;
        return view('intranet/noticias/edit', $data);
    }
    public function update(Request $request, Noticia $noticia){
        $noticia->titulo = $request->titulo;
        $noticia->descripcioncorta = $request->descripcioncorta;
        $noticia->contenido=$request->contenido;
        if($request->hasFile('img1')){
            $file = $request->file('img1');
            $image_path = public_path('img/noticias/').$noticia->img1; 
            $filename = substr($noticia->img1, 0, -4).'.'.$file->extension();
            $noticia->img1=$filename;
            if ($noticia->img1!=null && file_exists($image_path)){
                unlink($image_path);
            }
            $file->move(public_path('img/noticias'), $filename); 
        }
        if($request->hasFile('img2')){
            $file = $request->file('img2');
            $image_path = public_path('img/noticias/').$noticia->img2; 
            $filename = substr($noticia->img2, 0, -4).'.'.$file->extension();
            $noticia->img2=$filename;
            if ($noticia->img2!=null && file_exists($image_path)){
                unlink($image_path);
            }
            $file->move(public_path('img/noticias'), $filename); 
        }
        if($request->hasFile('img3')){
            $file = $request->file('img3');
            $image_path = public_path('img/noticias/').$noticia->img3; 
            $filename = substr($noticia->img3, 0, -4).'.'.$file->extension();
            $noticia->img3=$filename;
            if ($noticia->img3!=null && file_exists($image_path)){
                unlink($image_path);
            }
            $file->move(public_path('img/noticias'), $filename); 
        }
        $noticia->save();
        return redirect()->route('noticias.edit', $noticia);
    }
    public function show(Noticia $noticia){
        $data['noticia']=$noticia;
        return view('intranet/noticias/show', $data);
    }
}
