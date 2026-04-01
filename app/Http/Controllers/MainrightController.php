<?php

namespace App\Http\Controllers;
use App\Models\Mainright;
use Illuminate\Http\Request;

class MainrightController extends Controller
{
    public function index(){
        $data['registros']=Mainright::paginate(10);
        $data['indice']=Mainright::max('indice') ?? 0;
        return view('intranet/mainright/index', $data);
    }
    public function store(Request $request){
        $mainright = New Mainright();
        $mainright->nombre= $request->nombre;
        $mainright->url=$request->url;
        $mainright->indice=$request->indice;
        if($request->hasFile('imagen')){
            $file = $request->file('imagen');
            $filename = time().'.'.$file->extension();
            $mainright->imagen=$filename;
            $file->move(public_path('../../public_html/img/mainright'), $filename);
        }
        $mainright->save();
        return redirect()->route('mainright');
    }
    public function destroy(Mainright $mainright){
        $mainright->delete();
        return redirect()->route('mainright');
    }
}
