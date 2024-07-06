<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disease;

class DiseaseController extends Controller
{
    public function store(Request $request)
{
    // Validación de los datos del formulario
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'patient_id' => 'required|exists:patients,id',
    ]);

    // Verificar si ya existe una enfermedad con el mismo nombre para este paciente
    $existingDisease = Disease::where('name', $request->name)
        ->where('patient_id', $request->patient_id)
        ->exists();

    if ($existingDisease) {
        return redirect()->route('history.edit.view')
            ->with('error', 'Ya existe una enfermedad registrada con este nombre para este paciente.');
    }

    // Crear y guardar la nueva enfermedad
    $disease = new Disease();
    $disease->name = $request->name;
    $disease->description = $request->description;
    $disease->patient_id = $request->patient_id;
    $disease->save();

    return redirect()->route('history.edit.view')
        ->with('success', 'Enfermedad registrada correctamente.');
}

public function update(Request $request)
{
    // Validación de los datos del formulario
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'disease_id' => 'required|exists:diseases,id',
    ]);

    // Obtener la enfermedad a editar
    $disease = Disease::findOrFail($request->disease_id);

    // Verificar si ya existe una enfermedad con el mismo nombre para este paciente
    $existingDisease = Disease::where('name', $request->name)
        ->where('patient_id', $disease->patient_id)
        ->where('id', '!=', $disease->id)
        ->exists();

    if ($existingDisease) {
        return redirect()->route('history.edit.view')
            ->with('error', 'Ya existe una enfermedad registrada con este nombre para este paciente.');
    }

    // Actualizar los datos de la enfermedad
    $disease->name = $request->name;
    $disease->description = $request->description;
    $disease->save();

    return redirect()->route('history.edit.view')
        ->with('success', 'Enfermedad actualizada correctamente.');
}


public function delete($id)
{
    // Encuentra la enfermedad por su ID
    $disease = Disease::findOrFail($id);

    // Elimina la enfermedad
    $disease->delete();

    // Redirige de vuelta con un mensaje de éxito
    return response()->json(['success' => 'Enfermedad eliminada correctamente.']);
}



}
