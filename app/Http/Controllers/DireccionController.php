<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\AreasMenu;
use App\Models\Pagina;
use App\Models\EventoArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Menu;

class DireccionController extends Controller
{
    // Vista principal del administrador - muestra las 3 direcciones
    public function admin()
    {
        // Crear las direcciones si no existen
        $this->crearDireccionesIniciales();
        
        $direcciones = Direccion::with('areasMenu')->get();
        return view('intranet.direcciones.inicio', compact('direcciones'));
    }

    // Crear las 3 direcciones principales si no existen
    private function crearDireccionesIniciales()
    {
        $direccionesBase = [
            [
                'nombre' => 'Dirección de Gestión Institucional',
                'slug' => 'gestion-institucional',
                'descripcion' => 'Responsable de la gestión institucional y normativa de la región.',
                'idpagina' => 20
            ],
            [
                'nombre' => 'Dirección de Gestión Administrativa', 
                'slug' => 'gestion-administrativa',
                'descripcion' => 'Maneja los aspectos administrativos, recursos humanos y logística.',
                'idpagina' => 21
            ],
            [
                'nombre' => 'Dirección de Gestión Pedagógica',
                'slug' => 'gestion-pedagogica', 
                'descripcion' => 'Encargada de la gestión pedagógica y curricular de la región.',
                'idpagina' => 22
            ]
        ];

        foreach ($direccionesBase as $direccionData) {
            Direccion::firstOrCreate(
                ['slug' => $direccionData['slug']],
                $direccionData
            );
        }
    }

    // Vista para crear nueva dirección
    public function create()
    {
        return view('intranet.direcciones.create');
    }

    // Crear nueva dirección
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'idpagina' => 'nullable|integer',
            'activo' => 'required|boolean'
        ]);

        Direccion::create([
            'nombre' => $request->nombre,
            'slug' => \Str::slug($request->nombre),
            'descripcion' => $request->descripcion,
            'idpagina' => $request->idpagina,
            'activo' => $request->activo
        ]);

        return redirect()->route('admin.direcciones')->with('success', 'Dirección creada exitosamente');
    }

    public function editArea(AreasMenu $area)
    {
        // Este método no necesita retornar una vista completa 
        // ya que usamos AJAX/modal, pero lo incluimos por completitud
        return response()->json([
            'id' => $area->id,
            'nombre' => $area->nombre,
            'descripcion' => $area->descripcion,
            'orden' => $area->orden,
            'texto_descarga_1' => $area->texto_descarga_1,
            'link_descarga_1' => $area->link_descarga_1,
            'texto_descarga_2' => $area->texto_descarga_2,
            'link_descarga_2' => $area->link_descarga_2,
            'activo' => $area->activo,
            'imagen_funcionario' => $area->imagen_funcionario ? url($area->imagen_funcionario) : null,
            'imagen_organigrama' => $area->imagen_organigrama ? url($area->imagen_organigrama) : null
        ]);
    }

    // Vista para editar dirección
    public function edit(Direccion $direccion)
    {
        return view('intranet.direcciones.edit', compact('direccion'));
    }

    // Actualizar dirección
    public function update(Request $request, Direccion $direccion)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'idpagina' => 'nullable|integer',
            'activo' => 'required|boolean'
        ]);

        $direccion->update([
            'nombre' => $request->nombre,
            'slug' => \Str::slug($request->nombre),
            'descripcion' => $request->descripcion,
            'idpagina' => $request->idpagina,
            'activo' => $request->activo
        ]);

        return redirect()->route('admin.direcciones')->with('success', 'Dirección actualizada exitosamente');
    }

    // Eliminar dirección
    public function destroy(Direccion $direccion)
    {
        $direccion->delete();
        return redirect()->route('admin.direcciones')->with('success', 'Dirección eliminada exitosamente');
    }

    // Gestión de contenido web
    public function adminContenido($direccion_id)
    {
        try {
            $direccion = Direccion::with(['areasMenu', 'pagina'])->findOrFail($direccion_id);
            
            // Debug: verificar que la dirección se encuentra
            \Log::info('adminContenido - Direccion found: ' . $direccion->nombre);
            
            return view('intranet.direcciones.contenido', compact('direccion'));
            
        } catch (\Exception $e) {
            \Log::error('Error en adminContenido: ' . $e->getMessage());
            
            // Redirigir con error si no se encuentra la dirección
            return redirect()->route('admin.direcciones')
                            ->with('error', 'Dirección no encontrada');
        }
    }

    // Actualizar contenido web
    public function updateContenido(Request $request, $direccion_id)
    {
        $request->validate([
            'nom_pagina' => 'required|string|max:255',
            'cont_pagina' => 'required|string',
            'descripcion' => 'nullable|string'
        ]);

        $direccion = Direccion::findOrFail($direccion_id);
        
        // Actualizar la dirección
        $direccion->update([
            'descripcion' => $request->descripcion
        ]);

        // Actualizar o crear la página asociada
        if ($direccion->idpagina) {
            $pagina = Pagina::find($direccion->idpagina);
            if ($pagina) {
                $pagina->update([
                    'nom_pagina' => $request->nom_pagina,
                    'cont_pagina' => $request->cont_pagina
                ]);
            } else {
                // Crear la página si no existe
                Pagina::create([
                    'id' => $direccion->idpagina,
                    'nom_pagina' => $request->nom_pagina,
                    'cont_pagina' => $request->cont_pagina
                ]);
            }
        }

        return back()->with('success', 'Contenido actualizado exitosamente');
    }

    // Gestionar áreas de una dirección específica
    public function adminAreas($direccion_id)
    {
        $direccion = Direccion::with('areasMenu')->findOrFail($direccion_id);
        return view('intranet.direcciones.areas', compact('direccion'));
    }

    // Crear nueva área
    public function storeArea(Request $request, $direccion_id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'orden' => 'nullable|integer',
            'imagen_funcionario' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'imagen_organigrama' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'texto_descarga_1' => 'nullable|string',
            'link_descarga_1' => 'nullable|url',
            'texto_descarga_2' => 'nullable|string',
            'link_descarga_2' => 'nullable|url'
        ]);

        $area = new AreasMenu($request->all());
        $area->direccion_id = $direccion_id;
        $area->slug = \Str::slug($request->nombre);

        // Guardar imagen del funcionario en public_html/img/encargado_areas/
        if ($request->hasFile('imagen_funcionario')) {
            $area->imagen_funcionario = $this->guardarImagenFuncionario($request->file('imagen_funcionario'), $area->slug);
        }

        // Guardar imagen del organigrama en public_html/img/organigrama_areas/
        if ($request->hasFile('imagen_organigrama')) {
            $area->imagen_organigrama = $this->guardarImagenOrganigrama($request->file('imagen_organigrama'), $area->slug);
        }

        $area->save();

        return back()->with('success', 'Área creada exitosamente');
    }

    // Actualizar área
    public function updateArea(Request $request, AreasMenu $area)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'orden' => 'nullable|integer',
            'imagen_funcionario' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'imagen_organigrama' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'texto_descarga_1' => 'nullable|string',
            'link_descarga_1' => 'nullable|url',
            'texto_descarga_2' => 'nullable|string',
            'link_descarga_2' => 'nullable|url',
            'activo' => 'required|boolean'
        ]);

        $area->fill($request->except(['imagen_funcionario', 'imagen_organigrama']));
        $oldSlug = $area->slug;
        $area->slug = \Str::slug($request->nombre);

        // Actualizar imagen del funcionario
        if ($request->hasFile('imagen_funcionario')) {
            // Eliminar imagen anterior si existe
            if ($area->imagen_funcionario) {
                $this->eliminarImagen($area->imagen_funcionario);
            }
            $area->imagen_funcionario = $this->guardarImagenFuncionario($request->file('imagen_funcionario'), $area->slug);
        }

        // Actualizar imagen del organigrama
        if ($request->hasFile('imagen_organigrama')) {
            // Eliminar imagen anterior si existe
            if ($area->imagen_organigrama) {
                $this->eliminarImagen($area->imagen_organigrama);
            }
            $area->imagen_organigrama = $this->guardarImagenOrganigrama($request->file('imagen_organigrama'), $area->slug);
        }

        $area->save();

        return back()->with('success', 'Área actualizada exitosamente');
    }

    // Eliminar área
    public function destroyArea(AreasMenu $area)
    {
        // Eliminar imágenes físicas
        if ($area->imagen_funcionario) {
            $this->eliminarImagen($area->imagen_funcionario);
        }
        if ($area->imagen_organigrama) {
            $this->eliminarImagen($area->imagen_organigrama);
        }
        
        $area->delete();
        return back()->with('success', 'Área eliminada exitosamente');
    }

    // Vista pública de direcciones
    public function show($direccion_slug, $area_slug = null)
    {
        // ⭐ MISMO PATRÓN QUE HomeController
        $menus = Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
        $submenus = Menu::whereNotNull('categoriamenu')->get();
        
        $direccion = Direccion::where('slug', $direccion_slug)
                            ->where('activo', true)
                            ->with(['areasMenu' => function($query) {
                                $query->where('activo', true)
                                    ->with(['eventos' => function($eventQuery) {
                                        $eventQuery->activos()->ordenados();
                                    }])
                                    ->orderBy('orden', 'asc');
                            }])
                            ->firstOrFail();

        $area_actual = null;
        if ($area_slug) {
            $area_actual = $direccion->areasMenu()
                                    ->with(['eventos' => function($query) {
                                        $query->activos()->ordenados();
                                    }])
                                    ->where('slug', $area_slug)
                                    ->where('activo', true)
                                    ->first();
        }

        return view('paginas.direcciones.show', compact('direccion', 'area_actual', 'menus', 'submenus'));
    }

    // Método para ser llamado desde las páginas del menú
    public function showPorPagina($idpagina)
    {
        try {
            \Log::info("showPorPagina called with idpagina: " . $idpagina);
            
            $direccion = Direccion::where('idpagina', $idpagina)
                            ->where('activo', true)
                            ->with(['areasMenu' => function($query) {
                                $query->where('activo', true)
                                        ->with(['eventos' => function($eventQuery) {
                                            $eventQuery->activos()->ordenados();
                                        }])
                                        ->orderBy('orden', 'asc')
                                        ->orderBy('nombre', 'asc');
                            }])
                            ->first();

            if (!$direccion) {
                \Log::info("Creating automatic direccion for idpagina: " . $idpagina);
                $direccion = $this->crearDireccionAutomatica($idpagina);
            }

            $area_actual = null;
            $area_slug = request('area');
            
            if ($area_slug && $direccion) {
                $area_actual = $direccion->areasMenu()
                                    ->with(['eventos' => function($query) {
                                        $query->activos()->ordenados();
                                    }])
                                    ->where('slug', $area_slug)
                                    ->first();
            }

            // ⭐ USAR EL MISMO PATRÓN QUE HomeController
            $menus = Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
            $submenus = Menu::whereNotNull('categoriamenu')->get();

            if (!$direccion) {
                \Log::error("Unable to create or find direccion for idpagina: " . $idpagina);
                abort(404, 'Dirección no encontrada');
            }

            \Log::info("Returning view with direccion: " . $direccion->nombre);
            
            return view('paginas.direcciones.show', compact('direccion', 'area_actual', 'menus', 'submenus'));
            
        } catch (\Exception $e) {
            \Log::error('Error en showPorPagina: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            try {
                $direccion = $this->crearDireccionAutomatica($idpagina);
                $area_actual = null;
                
                // ⭐ TAMBIÉN AQUÍ USAR EL MISMO PATRÓN
                $menus = Menu::where('activo_menu', 1)->whereNull('categoriamenu')->get();
                $submenus = Menu::whereNotNull('categoriamenu')->get();
                
                return view('paginas.direcciones.show', compact('direccion', 'area_actual', 'menus', 'submenus'));
            } catch (\Exception $e2) {
                \Log::error('Error creating automatic direccion: ' . $e2->getMessage());
                abort(404, 'Error al cargar la dirección');
            }
        }
    }

    // Agregar el método para crear dirección automática si no existe
    private function crearDireccionAutomatica($idpagina)
    {
        $direccionesMap = [
            20 => [
                'nombre' => 'Dirección de Gestión Institucional',
                'slug' => 'gestion-institucional',
                'descripcion' => 'Responsable de la gestión institucional y normativa de la región.'
            ],
            21 => [
                'nombre' => 'Dirección de Gestión Administrativa', 
                'slug' => 'gestion-administrativa',
                'descripcion' => 'Maneja los aspectos administrativos, recursos humanos y logística.'
            ],
            22 => [
                'nombre' => 'Dirección de Gestión Pedagógica',
                'slug' => 'gestion-pedagogica',
                'descripcion' => 'Encargada de la gestión pedagógica y curricular de la región.'
            ]
        ];

        // Si el idpagina no está en el mapa, crear uno genérico
        if (!isset($direccionesMap[$idpagina])) {
            $direccionData = [
                'nombre' => 'Dirección General ' . $idpagina,
                'slug' => 'direccion-general-' . $idpagina,
                'descripcion' => 'Dirección del sistema educativo regional.'
            ];
        } else {
            $direccionData = $direccionesMap[$idpagina];
        }

        \Log::info("Creating direccion with data: ", $direccionData);

        return Direccion::create([
            'nombre' => $direccionData['nombre'],
            'slug' => $direccionData['slug'],
            'descripcion' => $direccionData['descripcion'],
            'idpagina' => $idpagina,
            'activo' => true
        ]);
    }

    /**
     * Guardar imagen de funcionario en ../../public_html/img/encargado_areas/
     */
    private function guardarImagenFuncionario($file, $slug)
    {
        // Crear directorio si no existe - usando ruta relativa hacia public_html
        $directorioBase = dirname(dirname(public_path())) . '/public_html/img/encargado_areas';
        if (!file_exists($directorioBase)) {
            mkdir($directorioBase, 0755, true);
        }

        // Generar nombre único para el archivo
        $extension = $file->getClientOriginalExtension();
        $nombreArchivo = $slug . '_funcionario_' . time() . '.' . $extension;

        // Mover el archivo
        $file->move($directorioBase, $nombreArchivo);

        // Retornar la ruta relativa para guardar en la base de datos
        return 'img/encargado_areas/' . $nombreArchivo;
    }

    /**
     * Guardar imagen de organigrama en ../../public_html/img/organigrama_areas/
     */
    private function guardarImagenOrganigrama($file, $slug)
    {
        // Crear directorio si no existe - usando ruta relativa hacia public_html
        $directorioBase = dirname(dirname(public_path())) . '/public_html/img/organigrama_areas';
        if (!file_exists($directorioBase)) {
            mkdir($directorioBase, 0755, true);
        }

        // Generar nombre único para el archivo
        $extension = $file->getClientOriginalExtension();
        $nombreArchivo = $slug . '_organigrama_' . time() . '.' . $extension;

        // Mover el archivo
        $file->move($directorioBase, $nombreArchivo);

        // Retornar la ruta relativa para guardar en la base de datos
        return 'img/organigrama_areas/' . $nombreArchivo;
    }

    /**
     * Eliminar imagen física del servidor desde ../../public_html/
     */
    private function eliminarImagen($rutaImagen)
    {
        if ($rutaImagen) {
            // Construir la ruta completa hacia public_html
            $rutaCompleta = dirname(dirname(public_path())) . '/public_html/' . $rutaImagen;
            if (file_exists($rutaCompleta)) {
                unlink($rutaCompleta);
            }
        }
    }

    /**
     * Método helper para obtener URL completa de la imagen
     */
    public static function obtenerUrlImagen($rutaImagen)
    {
        if (!$rutaImagen) {
            return null;
        }
        
        // Retornar URL que apunte a public_html
        return url($rutaImagen);
    }

    /**
     * Mostrar eventos de un área
     */
    public function eventosArea(AreasMenu $area)
    {
        // Cargar la relación direccion
        $area->load('direccion');
        
        $eventos = $area->todosLosEventos()->paginate(10);
        return view('intranet.direcciones.eventos-area', compact('area', 'eventos'));
    }

    /**
     * Crear nuevo evento
     */
    public function storeEvento(Request $request, AreasMenu $area)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'enlace_1' => 'nullable|url',
            'descripcion_enlace_1' => 'nullable|string|max:255',
            'enlace_2' => 'nullable|url',
            'descripcion_enlace_2' => 'nullable|string|max:255',
            'enlace_3' => 'nullable|url',
            'descripcion_enlace_3' => 'nullable|string|max:255',
            'enlace_4' => 'nullable|url',
            'descripcion_enlace_4' => 'nullable|string|max:255',
            'enlace_5' => 'nullable|url',
            'descripcion_enlace_5' => 'nullable|string|max:255',
            'enlace_externo' => 'nullable|url',
            'orden' => 'nullable|integer'
        ]);

        $evento = new EventoArea($request->all());
        $evento->area_id = $area->id;
        $evento->orden = $request->orden ?? 0;
        $evento->save();

        return back()->with('success', 'Evento creado exitosamente');
    }

    /**
     * Actualizar evento
     */
    public function updateEvento(Request $request, EventoArea $evento)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'enlace_1' => 'nullable|url',
            'descripcion_enlace_1' => 'nullable|string|max:255',
            'enlace_2' => 'nullable|url',
            'descripcion_enlace_2' => 'nullable|string|max:255',
            'enlace_3' => 'nullable|url',
            'descripcion_enlace_3' => 'nullable|string|max:255',
            'enlace_4' => 'nullable|url',
            'descripcion_enlace_4' => 'nullable|string|max:255',
            'enlace_5' => 'nullable|url',
            'descripcion_enlace_5' => 'nullable|string|max:255',
            'enlace_externo' => 'nullable|url',
            'orden' => 'nullable|integer',
            'activo' => 'required|boolean'
        ]);

        $evento->fill($request->all());
        $evento->save();

        return back()->with('success', 'Evento actualizado exitosamente');
    }

    /**
     * Eliminar evento
     */
    public function destroyEvento(EventoArea $evento)
    {
        $evento->delete();
        return back()->with('success', 'Evento eliminado exitosamente');
    }
}