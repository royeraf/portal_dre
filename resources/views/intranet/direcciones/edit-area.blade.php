<?php
// Agregar este método si no lo tienes

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