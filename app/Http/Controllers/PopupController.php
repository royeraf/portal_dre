<?php

namespace App\Http\Controllers;
use App\Models\Popup;
use App\Models\ImagenPopup;
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
        $popup->save();
        return redirect()->route('popup.edit', $popup);
    }
    public function store2(Request $request, Popup $popup){
        $imagenpopup=new ImagenPopup();
        if($request->hasFile('imagen')){
            $file = $request->file('imagen');
            $filename = time().'.'.$file->extension();
            $imagenpopup->imagen=$filename;
            $file->move(public_path('../../public_html/img/popup/'), $filename);
        }
        $imagenpopup->enlace=$request->enlace;
        $imagenpopup->idpopup=$popup->id;
        $imagenpopup->save();
        return redirect()->route('popup.edit', $popup);
    }
    public function destroy(Popup $popup){
        $popup->delete();
        return redirect()->route('popup');
    }
    public function destroy2(ImagenPopup $imagenpopup){
        $idpopup=$imagenpopup->idpopup;
        if($imagenpopup->imagen!=null && $imagenpopup->imagen!=''){
            $image_path = public_path('../../public_html/img/popup/').$imagenpopup->imagen;
            if (file_exists($image_path)){
                unlink($image_path);
            }
        }
        $imagenpopup->delete();
        return redirect()->route('popup.edit', $idpopup);
    }
    public function edit(Popup $popup){
        $data['imagenes']=ImagenPopup::where('idpopup', $popup->id)->get();
        $data['popup']=$popup;
        return view('intranet/popup/edit', $data);
    }
    public function update(Popup $popup, Request $request){
        $popup->titulopopup = $request->titulopopup;
        $popup->enlace_popup=$request->enlace_popup;
        $popup->estado=$request->estado;
        $popup->save();
        return redirect()->route('popup');
    }
    public function show(Popup $popup){
        $data['imagenes']=ImagenPopup::where('idpopup', $popup->id)->get();
        $data['popup']=$popup;
        return view('intranet/popup/modal/show', $data);
    }

}
