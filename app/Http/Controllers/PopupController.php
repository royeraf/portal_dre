<?php

namespace App\Http\Controllers;
use App\Models\Popup;
use Illuminate\Http\Request;

class PopupController extends Controller
{
    public function index(){
        $data['popups']=Popup::orderBy('created_at', 'desc')->paginate(10);
        return view('intranet/popup/inicio', $data);
    }
    public function create(){
        return view('intranet/popup/create');
    }
    public function store(Request $request){
        $popup = new Popup();
        $popup->titulopopup = $request->titulopopup;
        $popup->enlace_popup = $request->enlace_popup;
        $popup->contenido = $request->contenido;
        if($request->hasFile('imagen')){
            $file = $request->file('imagen');
            $filename = time().'.'.$file->extension();
            $popup->imagen=$filename;
            $file->move(public_path('img/popup'), $filename);   
        }
        $popup->save();
        return redirect()->route('popup');
    }
    public function destroy(Popup $popup){
        if($popup->imagen!=null && $popup->imagen!=''){
            $image_path = public_path('img/popup/').$popup->imagen;        
            if (file_exists($image_path)){
                unlink($image_path);
            }
        }
        $popup->delete();
        return redirect()->route('popup');
    }
    public function edit(Popup $popup){
        $data['popup']=$popup;
        return view('intranet/popup/edit', $data);
    }
    public function update(Popup $popup, Request $request){
        $popup->titulopopup = $request->titulopopup;
        $popup->contenido = $request->contenido;
        $popup->enlace_popup=$request->enlace_popup;
        $popup->estado=$request->estado;        
        if($request->hasFile('imagen')){
            $file = $request->file('imagen');
            $image_path = public_path('img/popup/').$popup->imagen; 
            $filename = substr($popup->imagen, 0, -4).'.'.$file->extension();
            $popup->imagen=$filename;
            if ($popup->imagen!=null && file_exists($image_path)){
                unlink($image_path);
            }
            $file->move(public_path('img/popup'), $filename); 
        }
        $popup->save();
        return redirect()->route('popup.edit', $popup);
    }
    public function show(Popup $popup){
        $data['popup']=$popup;
        return view('intranet/popup/modal/show', $data);
    }
    
}
