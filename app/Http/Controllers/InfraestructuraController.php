<?php

namespace App\Http\Controllers;
use App\Models\Infraestructura;
use Illuminate\Http\Request;

class InfraestructuraController extends Controller
{
    public function index(){
        $data['registros']=Infraestructura::orderBy('created_at', 'desc')->paginate(10);
        return view('intranet/infraestructura/inicio', $data);
    }
    public function store(Request $request){
        $comunicado = new Infraestructura();
        if($request->hasFile('imagen')){
            $file = $request->file('imagen');
            $filename = time().'.'.$file->extension();
            $comunicado->imagen=$filename;
            //$file->move(public_path('img/infraestructura'), $filename);
            $file->move(public_path('../../public_html/img/infraestructura'), $filename);
        }
        $comunicado->save();
        return redirect()->route('Infraestructura');
    }
    public function destroy(Infraestructura $infraestructura){
        //$image_path = public_path('img/infraestructura/').$infraestructura->imagen;
         $image_path = public_path('../../public_html/img/infraestructura/').$infraestructura->imagen;
        if ($infraestructura->imagen!=null && file_exists($image_path)){
            unlink($image_path);
        }
        $infraestructura->delete();
        return redirect()->route('Infraestructura');
    }
}
