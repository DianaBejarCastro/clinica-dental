<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use Faker\Provider\Medical;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
            'patient_id' => 'required|exists:patients,id',
        ]);

        // Verificar si ya existe una enfermedad con el mismo nombre para este paciente
        $existingMedication = Medication::where('name', $request->name)
            ->where('patient_id', $request->patient_id)
            ->exists();

        if ($existingMedication) {
            return redirect()->route('history.edit.view')
                ->with('error', 'Ya existe un medicamento registrado con este nombre para este paciente.');
        }

        // Crear y guardar la nueva enfermedad
        $medication = new Medication();
        $medication->name = $request->name;
        $medication->description = $request->description;
        $medication->is_active = $request->is_active;
        $medication->patient_id = $request->patient_id;
        $medication->save();

        return redirect()->route('history.edit.view')
            ->with('success', 'Medicamento registrado correctamente.');
    }

    public function update(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
            'medication_id' => 'required|exists:medications,id',
        ]);

        // Obtener la alergia a editar
        $medication = Medication::findOrFail($request->medication_id);

        // Verificar si ya existe una alergia con el mismo nombre para este paciente
        $existingMedication = Medication::where('name', $request->name)
            ->where('patient_id', $medication->patient_id)
            ->where('id', '!=', $medication->id)
            ->exists();

        if ($existingMedication) {
            return redirect()->route('history.edit.view')
                ->with('error', 'Ya existe un medicamento registrado con este nombre para este paciente.');
        }

        // Actualizar los datos de la alergia
        $medication->name = $request->name;
        $medication->description = $request->description;
        $medication->is_active = $request->is_active;
        $medication->save();

        return redirect()->route('history.edit.view')
            ->with('success', 'Medicación actualizada correctamente.');
    }



    public function delete($id)
{
    // Encuentra la alergia por su ID
    $medication = Medication::findOrFail($id);

    // Elimina la alergia
    $medication->delete();

    // Devuelve una respuesta JSON con un mensaje de éxito
    return response()->json(['success' => 'Medicamento eliminado correctamente.']);
}
}
