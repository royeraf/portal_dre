<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoEmbevido;

class VideoEmbevidoController extends Controller
{
    public function create(){
        $data['registros']=VideoEmbevido::paginate();
        return view('intranet/videoembevido/create', $data);
    }
    public function store(Request $request){
        $videoempbevido = new VideoEmbevido();
        $videoempbevido->titulo = $request->titulo;
        $videoempbevido->contenido=$request->contenido;
        $videoempbevido->save();
        return redirect()->route('videoembevido');
    }
    public function destroy(VideoEmbevido $videoembevido){
        $videoembevido->delete();
        return redirect()->route('videoembevido');
    }
    public function edit(VideoEmbevido $videoembevido){
        $data['videoembevido']=$videoembevido;
        return view('intranet/videoembevido/edit', $data);
    }
    public function update(Request $request, VideoEmbevido $videoembevido){
        $videoembevido->titulo=$request->titulo;
        $videoembevido->contenido=$request->contenido;
        $videoembevido->save();
        return redirect()->route('videoembevido', $videoembevido);
    }
}
