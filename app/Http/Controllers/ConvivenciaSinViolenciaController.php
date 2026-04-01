<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class ConvivenciaSinViolenciaController extends Controller
{
    public function index()
    {
        $menus=Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $submenus= Menu::whereNotNull('categoriamenu')->get();
        $data['menus']=$menus;
        $data['submenus']=$submenus;
        
        return view('paginas.convivenciasinviolencia.index', $data);
    }
}
