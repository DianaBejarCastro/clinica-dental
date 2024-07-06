<?php

namespace App\Http\Controllers;

use App\Models\Allergy;
use Illuminate\Http\Request;

class AllergyController extends Controller
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
        $existingAllergy = Allergy::where('name', $request->name)
            ->where('patient_id', $request->patient_id)
            ->exists();

        if ($existingAllergy) {
            return redirect()->route('history.edit.view')
                ->with('error', 'Ya existe una alergia registrada con este nombre para este paciente.');
        }

        // Crear y guardar la nueva enfermedad
        $allergy = new Allergy();
        $allergy->name = $request->name;
        $allergy->description = $request->description;
        $allergy->patient_id = $request->patient_id;
        $allergy->save();

        return redirect()->route('history.edit.view')
            ->with('success', 'Alergia registrada correctamente.');
    }

    public function update(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'allergy_id' => 'required|exists:allergies,id',
        ]);

        // Obtener la alergia a editar
        $allergy = Allergy::findOrFail($request->allergy_id);

        // Verificar si ya existe una alergia con el mismo nombre para este paciente
        $existingAllergy = Allergy::where('name', $request->name)
            ->where('patient_id', $allergy->patient_id)
            ->where('id', '!=', $allergy->id)
            ->exists();

        if ($existingAllergy) {
            return redirect()->route('history.edit.view')
                ->with('error', 'Ya existe una alergia registrada con este nombre para este paciente.');
        }

        // Actualizar los datos de la alergia
        $allergy->name = $request->name;
        $allergy->description = $request->description;
        $allergy->save();

        return redirect()->route('history.edit.view')
            ->with('success', 'Alergia actualizada correctamente.');
    }



    public function delete($id)
{
    // Encuentra la alergia por su ID
    $allergy = Allergy::findOrFail($id);

    // Elimina la alergia
    $allergy->delete();

    // Devuelve una respuesta JSON con un mensaje de éxito
    return response()->json(['success' => 'Alergia eliminada correctamente.']);
}

}
