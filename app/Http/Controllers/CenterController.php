<?php
namespace App\Http\Controllers;
use App\Models\Center;
use Illuminate\Http\Request;
use DataTables;


class CenterController extends Controller
{
   
    public function index(Request $request)
    {
        $centers = Center::all();
        return view('dashboard.admin.center.index', compact('centers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('centers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        $request->validate([
            'name_branch' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        Center::create([
            'name_branch' => $request->name_branch,
            'city' => $request->city,
            'address' => $request->address,
            'is_active' => true,
        ]);
        return redirect()->route('centers.index')->with('success', 'Sucursal registrada exitosamente.');
     
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $center = Center::findOrFail($id);
        return response()->json($center);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $center = Center::findOrFail($id);
        return view('centers.edit', compact('center'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name_branch' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        $center = Center::findOrFail($id);
        $center->name_branch = $request->input('name_branch');
        $center->city = $request->input('city');
        $center->address = $request->input('address');
        // No actualizamos el campo 'is_active' aquí
        $center->save();

        return response()->json(['message' => 'Sucursal actualizada con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $center = Center::findOrFail($id);
        $center->delete();
        return redirect()->route('centers.index')->with('success', 'Sucursal eliminada exitosamente.');
    }
}