<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use App\Models\Slider;
use App\Models\Noticia;
use App\Models\Popup;
use App\Models\Directorio;
use App\Models\ImagenEvento;
use App\Models\Convocatoria;
use App\Models\ArchivoConvocatoria;
use App\Models\Comunicado;
use App\Models\Galeria;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(){
        //$data['galeria']=ImagenEvento::select(DB::raw('imgeventos.titulo, imgeventos.descripcion, MONTH(created_at) month, imgeventos.archivo_img'))->whereRaw('created_at BETWEEN DATE_SUB(CURDATE(), INTERVAL 2 MONTH) AND DATE_ADD(CURDATE(), INTERVAL 2 DAY) ORDER BY Id DESC')->get();
        //$data['visitas']=$visitas;
        $data['comunicados']=Comunicado::orderBy('created_at', 'desc')->take(10)->get();
        $data['noticias']=Noticia::orderBy('fechapubli', 'desc')->take(6)->get();
        $data['menus']=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $data['submenus']=Menu::whereNotNull('categoriamenu')->get();
        $data['popup']=Popup::where('estado', 1)->orderBy('created_at', 'desc')->first();
        $data['sliders']=Slider::where('activo_slider', 1)->get();
        return view('home', $data);
    }
    public function noticia(Noticia $noticia){
        $menus=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $submenus= Menu::whereNotNull('categoriamenu')->get();
        $data['menus']=$menus;
        $data['submenus']=$submenus;
        $data['noticia']=$noticia;
        return view('principal/noticia', $data);
    }
    public function directorio(){
        $menus=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $submenus= Menu::whereNotNull('categoriamenu')->get();
        $data['director']=Directorio::where('cargo', 'DIRECTOR')->first();
        $data['jefeagi']=Directorio::where('cargo', 'JEFE DE AGI')->first();
        $data['jefeagp']=Directorio::where('cargo', 'Jefe de AGP')->first();
        $data['jefeaga']=Directorio::where('cargo', 'JEFE DE AGA')->first();
        $data['menus']=$menus;
        $data['submenus']=$submenus;
        $data['registros']=Directorio::whereNotIn('cargo' , ['DIRECTOR', 'JEFE DE AGI', 'Jefe de AGP', 'JEFE DE AGA'])->get();
        return view('principal/directorio', $data);
    }
    public function nosotros(){
        $menus=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $submenus= Menu::whereNotNull('categoriamenu')->get();
        $data['menus']=$menus;
        $data['submenus']=$submenus;
        return view('principal/nosotros', $data);        
    }
    public function mision(){
        $menus=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $submenus= Menu::whereNotNull('categoriamenu')->get();
        $data['menus']=$menus;
        $data['submenus']=$submenus;
        return view('principal/mision', $data);        
    }
    public function vision(){
        $menus=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $submenus= Menu::whereNotNull('categoriamenu')->get();
        $data['menus']=$menus;
        $data['submenus']=$submenus;
        return view('principal/vision', $data);        
    }
    public function portafoliodet(Galeria $galeria){
        $data['imagenes']=ImagenEvento::where('idgaleria', $galeria->id)->take(10)->get();
        $data['galeria']=$galeria;
        return view('principal/portafoliodet', $data);
    }
    public function allnoticias(){
        $data['noticias']=Noticia::orderBy('fechapubli', 'desc')->take(6)->get();
        $data['menus']=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $data['submenus']=Menu::whereNotNull('categoriamenu')->get();
        return view('principal/allnoticias', $data);
    }
    public function galeria(){
        $data['registrosgaleria']=Galeria::select(DB::raw('id, titulo, descripcion, fecha_publicacion,(select archivo_img from imgeventos where idgaleria=galeria.id limit 1) as img'))->paginate(10);
        $data['menus']=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $data['submenus']=Menu::whereNotNull('categoriamenu')->get();
        return view('principal/galeria', $data);
    }
    public function convocatoriaweb(){
        $convocatorias=Convocatoria::where('es_activo', 1)->orderBy('id', 'desc')->paginate(10);
        foreach($convocatorias as $row){
            $archivoconvocatoria = ArchivoConvocatoria::where('id_convocatoria', $row->id)->get();
            // $archivo=[];
            // foreach($archivoconvocatoria as $arch)
            // {
            //     array_push($archivo, [
            //         'id_convocatoria' => $arch->id_convocatoria,
            //         'nom_archivo' => $arch->nom_archivo,
            //         'url_archivo' => $arch->url_archivo,
            //         'etapa' => $arch->etapa
            //     ]);
            // }
            $row['archivos'] = $archivoconvocatoria;
        }
        $data['convocatorias']=$convocatorias;
        $data['menus']=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $data['submenus']=Menu::whereNotNull('categoriamenu')->get();
        return view('principal/convocatorias', $data);  
    }
    public function verconvocatoria(Convocatoria $convocatoria){
        $data['convocatoria']=$convocatoria;
        $data['archivos']=ArchivoConvocatoria::where('id_convocatoria', $convocatoria->id)->orderBy('id', 'desc')->paginate(5);
        $data['menus']=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $data['submenus']=Menu::whereNotNull('categoriamenu')->get();
        return view('principal/verconvocatoria', $data);         
    }
    public function comunicadosall(){
        $data['menus']=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $data['submenus']=Menu::whereNotNull('categoriamenu')->get();
        $data['comunicados']=Comunicado::orderBy('created_at', 'desc')->take(10)->get();
        return view('principal/comunicados', $data);          
    }

}
