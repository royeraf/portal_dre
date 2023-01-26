<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\User;
 
class PaginasWeb extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function menus()
    {
        $enlace = "http://".request()->server('HTTP_HOST');
        
        $portalesweb=DB::table('direcciones_web')->where('dns_direcciones_web',$enlace)->value('iddirecciones_web');
        // $iddireccionweb=$portalesweb;//id de pagina web
        
        $iddireccionweb=1;//id de pagina web

        $menus=DB::table('menus')->where(['iddirecciones_web'=>$iddireccionweb,'activo_menu'=>1])->orderBy('idmenus','ASC')->get();
        
        $datsubmenu=DB::table('submenu')->join('menus','submenu.idmenus','=','menus.idmenus')->where(['activo_submenu'=>1,'iddirecciones_web'=>$iddireccionweb])->select('submenu.idsubmenu','submenu.nom_submenu','submenu.link_submenu','submenu.archivo','submenu.idpagina','submenu.ico_submenu','submenu.idmenus')->orderBy('submenu.idmenus','ASC')->get();

        return response()->json([
            'menus'=>$menus,
            'submenus'=>$datsubmenu
        ], 200);
        

    }

}

?>