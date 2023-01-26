<?php

namespace App\Http\Controllers;
use App\Models\Slider;


use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function create(){
        $data['sliders']=Slider::paginate();
        return view('intranet/slide/create', $data); 
    }
    public function store(Request $request){
        $slider = new Slider();
        if($request->hasFile('img_slider')){
            $file = $request->file('img_slider');
            $filename = time().'.'.$file->extension();
            $slider->titulo = $request->titulo;
            $slider->descripcioncorta=$request->descripcioncorta;
            $slider->img_slider=$filename;
            $slider->activo_slider=1;
            $slider->link=$request->link;            
            $slider->save();
            $file->move(public_path('img/slider'), $filename);            
        }else{
            return 'no hay imagen';
        }
        return redirect()->route('slide.create');
    }
    public function destroy(Slider $slider){
        $image_path = public_path('img/slider/').$slider->img_slider;        
        if (file_exists($image_path)){
            unlink($image_path);
        }
        $slider->delete();
        return redirect()->route('slide.create');
    }
    public function edit(Slider $slider){
        $data['slider']=$slider;
        return view('intranet/slide/edit', $data); 
    }
    public function update(Request $request, Slider $slider){
        $slider->titulo=$request->titulo;
        $slider->descripcioncorta=$request->descripcioncorta;
        $slider->link=$request->link;        
        if($request->hasFile('img_slider')){
            $file = $request->file('img_slider');
            $image_path = public_path('img/slider/').$slider->img_slider;              
            $filename = substr($slider->img_slider, 0, -4).'.'.$file->extension();
            $slider->img_slider=$filename;
            if (file_exists($image_path)){
                unlink($image_path);
            }
            $file->move(public_path('img/slider'), $filename); 
        }
        $slider->save();
        return redirect()->route('slide.edit', $slider);        
    }

}
