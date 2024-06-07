<?php

namespace App\Http\Controllers;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specialties = Specialty::all();
        return view('dashboard.admin.specialty.index', compact('specialties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('specialties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Specialty::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return redirect()->route('specialties.index')->with('success', 'Especialidad registrada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $specialty = Specialty::findOrFail($id);
        return response()->json($specialty);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $specialty = Specialty::findOrFail($id);
        return view('specialties.edit', compact('specialty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $specialty = Specialty::findOrFail($id);
        $specialty->name = $request->input('name');
        $specialty->description = $request->input('description');
       
        // No actualizamos el campo 'is_active' aquí
        $specialty->save();

        return response()->json(['message' => 'Especialidad actualizada con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //$specialty->delete();

        return redirect()->route('specialties.index')
                         ->with('success', 'Specialty deleted successfully.');
    }
}
