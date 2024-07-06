<?php

namespace App\Http\Controllers;

use App\Models\Allergy;
use App\Models\Disease;
use App\Models\Medication;
use App\Models\Patient;

use Illuminate\Http\Request;

class MedicalHistoryController extends Controller
{
    
    public function setEditId(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:patients,id',
        ]);
    
        $request->session()->put('patient_edit_id', $request->id);
    
        return response()->json(['status' => 'success']);
    }
    
    public function showEditView(Request $request)
    {
        $id = $request->session()->get('patient_edit_id');
        if (!$id) {
            return redirect()->back()->with('error', 'ID de paciente no encontrado en la sesión.');
        }
    
        $patient = Patient::with(['user', 'center', 'emergencyContacts'])->findOrFail($id);
    
        // Consultar la tabla diseases
        $diseases = Disease::where('patient_id', $id)->get();
        // Consultar la tabla diseases
        $allergies = Allergy::where('patient_id', $id)->get();
        // Consultar la tabla diseases
        $medications = Medication::where('patient_id', $id)->get();
    
        // Pasar los datos a la vista
        return view('dashboard.dentist.medical-history.index', compact('patient', 'diseases', 'allergies', 'medications'));
    }
    
}
