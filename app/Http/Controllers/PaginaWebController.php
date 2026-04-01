<?php

namespace App\Http\Controllers;
use App\Models\Pagina;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\SubMenu;
class PaginaWebController extends Controller
{
    public function index(){
        // $data['paginas']=Pagina::paginate(10);
        $data['paginas']=Pagina::select('pagina.*')->leftJoin('menus', 'pagina.id', '=', 'menus.idpagina')->whereNull('menus.idpagina')->paginate(10);
        //$data['paginas']=Pagina::select('menus.*', 'm2.nom_menu as categoria')->leftJoin('menus as m2', 'menus.categoriamenu', '=', 'm2.id')->paginate(10);
        return view('intranet/paginaweb/inicio', $data);
    }
    public function store(Request $request){
        $idpagina = 1+Pagina::select('id')->max('id');
        $pagina = new pagina();
        $pagina->id=$idpagina;
        $pagina->nom_pagina=$request->nom_pagina;
        $pagina->cont_pagina=$request->cont_pagina;
        $pagina->save();
        return redirect()->route('paginawebadmin');
    }

    public function destroy(Pagina $pagina){
        $pagina->delete();
        return redirect()->route('paginawebadmin');
    }

    public function edit(Pagina $pagina){
        $data['pagina']=$pagina;
        return view('intranet/paginaweb/edit', $data);
    }
    public function update(Pagina $pagina, Request $request){
        $pagina->nom_pagina=$request->nom_pagina;
        $pagina->cont_pagina=$request->cont_pagina;
        $pagina->save();
        return redirect()->route('paginawebadmin');
    }
}
