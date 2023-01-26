<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\SubMenu;
use App\Models\Pagina;

class MenuController extends Controller
{
    public function index(){
        // $data['menus']=Menu::paginate(10);
        // return view('intranet/menu', $data); 
    }
    public function create(){
        $data['menus']=Menu::select('menus.*', 'm2.nom_menu as categoria')->leftJoin('menus as m2', 'menus.categoriamenu', '=', 'm2.id')->paginate(10);
        $data['menusdd']=Menu::where('link_menu', '#')->get();
        return view('intranet/menu/create', $data);
    }
    public function store(Request $request){
        $idpagina = 1+Pagina::select('id')->max('id');
        $menu = new Menu();
        $pagina = new pagina();
        if($request->link_menu!='#' && $request->link_menu==''){//SE ESTA CREANDO UNA PAGINA
            $request->link_menu='http://127.0.0.1:8000/menus/paginaweb/'.$idpagina;
            $pagina->id=$idpagina;
            $pagina->nom_pagina=$request->nom_pagina;
            $pagina->cont_pagina=$request->cont_pagina;
            $pagina->save();           
        }
        $menu->nom_menu = $request->nom_menu;
        $menu->link_menu = $request->link_menu;
        $menu->activo_menu = 1;
        $menu->categoriamenu=$request->categoriamenu;
        $menu->idpagina=$idpagina;
        $menu->save();
        return redirect()->route('formregistro');
    }
    public function prueba(){
        $idpagina = Pagina::select('id')->max('id');
        return $idpagina+1;
    }
    public function showpaginaweb(Pagina $pagina){
        $menus=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $submenus= Menu::whereNotNull('categoriamenu')->get();
        $data['menus']=$menus;
        $data['submenus']=$submenus;
        $data['paginaweb']=$pagina;
        return view('principal/paginaweb', $data); 
    }
    public function destroy(Menu $menu){
        $menu->delete();
        return redirect()->route('formregistro');
    }
    public function update(Request $request, Menu $menu){
        $pagina=new Pagina();
        $menu->nom_menu=$request->nom_menu;

        $menu->activo_menu = $request->activo_menu;
        if($request->categoriamenu==''){
            $menu->categoriamenu = null; 
        }else{
            $menu->categoriamenu = $request->categoriamenu; 
        }   
        if($menu->link_menu=='#'){//si no tubo paginas web
            if($request->link_menu!='#' && $request->link_menu==''){//existe registro de pagina web nueva pagina web crear nueva pagina
                $idpagina = 1+Pagina::select('id')->max('id');
                if($request->link_menu!='#'){
                    $request->link_menu='http://127.0.0.1:8000/menus/paginaweb/'.$idpagina;
                }
                $pagina->id=$idpagina;
                $pagina->nom_pagina=$request->nom_pagina;
                $pagina->cont_pagina=$request->cont_pagina;
                $pagina->save();
                $menu->idpagina=$idpagina;
            }else{//no tuvo ni tiene paginas web

            }
        }else{
            if($request->link_menu!='#'){//existe registro de pagina web actualizar pagina web
                $pagina->id=$request->idpagina;
                Pagina::where('id', $request->idpagina)->update(array('nom_pagina' => $request->nom_pagina, 'cont_pagina' => $request->cont_pagina));
            }else{//no existe registro de pagina entonces se debe borrar el registro anterior de pagina web
                Pagina::where('id', $menu->idpagina)->delete();
                $menu->idpagina=null;
            }
        }
        $menu->link_menu = $request->link_menu;
        $menu->save();
        return redirect()->route('formregistro');
    }
    public function edit(Menu $menu){
        $data['menusdd']=Menu::where('link_menu', '#')->get();
        $data['menu']=$menu;
        if($menu->link_menu!='#'){
            $data['pagina'] = Pagina::find($menu->idpagina);
        }
        return view('intranet/menu/menu', $data); 
    }
    public function submenus(Menu $menu){
        $data['menu']=$menu;
        $data['submenus']=SubMenu::where('idmenus', $menu->id)->paginate(10);
        return view('intranet/submenu', $data);
    }
    public function submenusstore(Request $request){
        $submenu = new SubMenu();
        $submenu->nom_submenu = $request->nom_submenu;
        $submenu->link_submenu = $request->link_submenu;
        $submenu->activo_submenu = 1;
        $submenu->idpagina = 1;
        $submenu->idmenus = $request->idmenus;
        $submenu->save();
        return redirect()->route('menu.submenus', $request->idmenus);
    }
    public function submenudestroy(SubMenu $submenu){
        $idmenus = $submenu->idmenus;
        $submenu->delete();
        return redirect()->route('menu.submenus', $idmenus);
    }
    // public function paginaweb($idpagina=null){
        
    //     $data['menus']=Menu::paginate(10);
    //     return view('intranet/pagina', $data); 
    // }
    public function paginawebstore(Request $request){
        $pagina = new Pagina();
        $pagina->nom_pagina=$request->nom_pagina;
        $pagina->cont_pagina=$request->cont_pagina;
        $pagina->save();

        return $pagina;
        // if($tipo=='Menu'){
        //     $menu = new Menu();
        // }else{
        //     $submenu= new SubMenu();
        // }
    }

}
