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
use App\Models\Mainright;
use App\Models\Documentogestion;
use App\Models\Archivodocumentogestion;
use App\Models\ImagenPopup;
use App\Models\Infraestructura;
use App\Models\Pagina;
use App\Models\VideoEmbevido;
use App\Models\Resolucion;
use Illuminate\Http\Request;
use App\Models\Visita;
class HomeController extends Controller
{
    public function __invoke(){

        $data['mainrightitem']=Mainright::orderBy('indice', 'asc')->get();
        $data['comunicados']=Comunicado::orderBy('created_at', 'desc')->take(10)->get();
        $data['noticias']=Noticia::orderBy('fechapubli', 'desc')->take(6)->get();
        $data['menus']=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $data['submenus']=Menu::whereNotNull('categoriamenu')->get();
        $data['VideoEmbevidos']=VideoEmbevido::orderBy('created_at', 'desc')->take(2)->get();
        $popup=Popup::where('estado', 1)->orderBy('created_at', 'desc')->first();
        $data['popup']=$popup;
        if(isset($popup)){
            $data['imagenes']=ImagenPopup::where('idpopup', $popup->id)->get();
        }
        $data['sliders'] = Slider::where('activo_slider', 1)->orderBy('created_at', 'desc')->get();
        return view('home', $data);
    }
    public function index(){
        $contador = self::sumarVisita();
        $data['contador']=$contador;
        $data['mainrightitem']=Mainright::orderBy('indice', 'asc')->get();
        $data['comunicados']=Comunicado::orderBy('created_at', 'desc')->take(10)->get();
        $data['noticias']=Noticia::orderBy('fechapubli', 'desc')->take(6)->get();
        $data['menus']=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $data['submenus']=Menu::whereNotNull('categoriamenu')->get();
        $data['VideoEmbevidos']=VideoEmbevido::orderBy('created_at', 'desc')->take(5)->get();
        $popup=Popup::where('estado', 1)->orderBy('created_at', 'desc')->first();
        $data['popup']=$popup;
        if(isset($popup)){
            $data['imagenes']=ImagenPopup::where('idpopup', $popup->id)->orderBy('created_at', 'desc')->get();
        }
        $data['sliders'] = Slider::where('activo_slider', 1)->orderBy('created_at', 'desc')->get();
        return view('home', $data);
    }    
    public function noticia(Noticia $noticia){
        $menus=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $submenus= Menu::whereNotNull('categoriamenu')->get();
        $data['noticias']=Noticia::whereNotIn('id', [$noticia->id])->orderBy('fechapubli', 'desc')->take(6)->get();
        $data['menus']=$menus;
        $data['submenus']=$submenus;
        $data['noticia']=$noticia;
        $data['mititulo']=$noticia->titulo;
        return view('paginas/noticia', $data);
    }
    public function directorio(){
        $menus=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $submenus= Menu::whereNotNull('categoriamenu')->get();
        $data['director']=Directorio::where('cargo', 'DIRECTOR REGIONAL DE EDUCACION')->first();
        $data['jefeagi']=Directorio::where('cargo', 'DIRECTORA DE GESTION INSTITUCIONAL')->first();
        $data['jefeagp']=Directorio::where('cargo', 'DIRECTOR DE GESTION PEDAGOGICA')->first();
        $data['jefeaga']=Directorio::where('cargo', 'DIRECTOR DE GESTION ADMINISTRATIVA')->first();
        $data['jefead2']=Directorio::where('cargo', 'DIRECTORA DE ASESORIA JURÍDICA')->first();
        $data['jefehh']=Directorio::where('cargo', 'DIRECTOR DE RECURSOS HUMANOS')->first();
        $data['menus']=$menus;
        $data['submenus']=$submenus;
        $data['registros']=Directorio::whereNotIn('cargo' , ['DIRECTOR REGIONAL DE EDUCACION', 'DIRECTORA DE GESTION INSTITUCIONAL', 'DIRECTORA DE GESTION PEDAGÓGICA', 'DIRECTOR DE GESTION ADMINISTRATIVA', 'DIRECTORA DE ASESORIA JURÍDICA', 'DIRECTOR DE RECURSOS HUMANOS'])->get();
        return view('paginas/directorio', $data);
    }
    public function nosotros(){
        $menus=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $submenus= Menu::whereNotNull('categoriamenu')->get();
        $data['menus']=$menus;
        $data['submenus']=$submenus;
        return view('paginas/nosotros', $data);
    }
    public function mision(){
        $menus=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $submenus= Menu::whereNotNull('categoriamenu')->get();
        $data['menus']=$menus;
        $data['submenus']=$submenus;
        return view('paginas/mision', $data);
    }
    public function vision(){
        $menus=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $submenus= Menu::whereNotNull('categoriamenu')->get();
        $data['menus']=$menus;
        $data['submenus']=$submenus;
        return view('paginas/vision', $data);
    }
    public function galeriaJson(Galeria $galeria){
        $imagenes = ImagenEvento::where('idgaleria', $galeria->id)->get(['archivo_img']);
        return response()->json([
            'id'          => $galeria->id,
            'titulo'      => $galeria->titulo,
            'descripcion' => $galeria->descripcion,
            'imagenes'    => $imagenes->pluck('archivo_img'),
        ]);
    }
    public function portafoliodet(Galeria $galeria){
        $data['menus']=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $data['submenus']=Menu::whereNotNull('categoriamenu')->get();
        $data['imagenes']=ImagenEvento::where('idgaleria', $galeria->id)->take(10)->get();
        $data['galeria']=$galeria;
        return view('paginas/portafoliodet', $data);
    }
    public function allnoticias(){
        $data['noticias']=Noticia::orderBy('fechapubli', 'desc')->paginate(6);
        $data['menus']=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $data['submenus']=Menu::whereNotNull('categoriamenu')->get();
        return view('paginas/allnoticias', $data);
    }
    public function galeria(){
        $data['registrosgaleria']=Galeria::select(DB::raw('id, titulo, descripcion, fecha_publicacion,(select archivo_img from imgeventos where idgaleria=galeria.id limit 1) as img'))->paginate(10);
        $data['menus']=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $data['submenus']=Menu::whereNotNull('categoriamenu')->get();
        return view('paginas/galeria', $data);
    }
    public function convocatoriaweb(Request $request){
    $convocatorias = Convocatoria::where('es_activo', 1);

    if ($request->filled('tipo')) {
        $convocatorias->where('tipo', $request->tipo);
    }

    if ($request->filled('buscarTitulo')) {
        $convocatorias->where('titulo', 'like', '%' . $request->buscarTitulo . '%');
    }

    if ($request->filled('startDate')) {
        $convocatorias->where('fecha_inicio', '>=', $request->startDate);
    }

    if ($request->filled('endDate')) {
        $convocatorias->where('fecha_inicio', '<=', $request->endDate);
    }

    if ($request->filled('startDate') && $request->filled('endDate')) {
        $convocatorias->whereBetween('fecha_inicio', [$request->startDate, $request->endDate]);
    }

    $convocatorias = $convocatorias->orderBy('id', 'desc')->paginate(12);

    foreach ($convocatorias as $row) {
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

    $data['convocatorias'] = $convocatorias;
    $data['menus'] = Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
    $data['submenus'] = Menu::whereNotNull('categoriamenu')->get();

    return view('paginas/convocatorias', $data);
    }
    public function verconvocatoria(Convocatoria $convocatoria){
        $data['convocatoria']=$convocatoria;
        $data['archivos']=ArchivoConvocatoria::where('id_convocatoria', $convocatoria->id)->orderBy('id', 'desc')->paginate(5);
        $data['menus']=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $data['submenus']=Menu::whereNotNull('categoriamenu')->get();
        return view('paginas/verconvocatoria', $data);
    }
    public function comunicadosall(){
        $data['menus']=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $data['submenus']=Menu::whereNotNull('categoriamenu')->get();
        $data['comunicados']=Comunicado::orderBy('created_at', 'desc')->take(10)->get();
        return view('paginas/comunicados', $data);
    }
    public function documentosdegestionweb(){
        $data['menus']=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $data['submenus']=Menu::whereNotNull('categoriamenu')->get();
        $data['comunicados']=Comunicado::orderBy('created_at', 'desc')->take(10)->get();
        $registros=Documentogestion::orderBy('id', 'asc')->get();
        foreach($registros as $row){
            $archivoconvocatoria = Archivodocumentogestion::where('id_documentogestion', $row->id)->get();
            $row['archivos'] = $archivoconvocatoria;
        }
        $data['registros']=$registros;
        return view('paginas/documentosdegestionweb', $data);
    }
    public function infraestructura(){
        $data['menus']=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $data['submenus']=Menu::whereNotNull('categoriamenu')->get();
        $data['registros']=Infraestructura::orderBy('created_at', 'desc')->take(10)->get();
        return view('paginas/infraestructura', $data);
    }
    public function infraestructuragaleria(){
        $data['menus']=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $data['submenus']=Menu::whereNotNull('categoriamenu')->get();
        $data['registros']=Infraestructura::orderBy('created_at', 'desc')->paginate(12);
        return view('paginas/infraestructuragaleria', $data);
    }
    public function showpaginaweb(Pagina $pagina){
        $menus=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $submenus= Menu::whereNotNull('categoriamenu')->get();
        $data['menus']=$menus;
        $data['submenus']=$submenus;
        $data['paginaweb']=$pagina;
        return view('paginas/paginaweb', $data);
    }
    public function resoluciones(){
        $menus=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $submenus= Menu::whereNotNull('categoriamenu')->get();
        $resoluciones= Resolucion::with('tipo:id,x_resoluciontipos')
        ->where('x_estado', 'PUBLICO GENERAL')
        ->where('l_activo', 'S')
        ->orderBy('x_fecha', 'desc')
        ->paginate(10);
        $data['menus']=$menus;
        $data['submenus']=$submenus;
        $data['resoluciones']=$resoluciones;
        return view('paginas/resoluciones', $data);
    }
    
    public static function sumarVisita()
    {
        $data['visitas']=Visita::where('id',1)->first();
        $visita = Visita::first();
        if ($visita) {
            $visita->contador++;
            $visita->save();
        }else {
        $visita = new Visita();
        $visita->contador = 1;
        $visita->save();
        }
        return $visita->contador;
    }
}
