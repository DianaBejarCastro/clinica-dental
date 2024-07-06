<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OdontogramController extends Controller
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

        return view('dashboard.dentist.odontogram.index');
    }
}
