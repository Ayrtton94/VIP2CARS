<?php

namespace App\Http\Controllers;

use App\Models\Vehicles;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('vehicles.index');
    }

    public function listar()
{
    $vehiculos = Vehicles::with('contacts')->paginate(10);

    $formateados = $vehiculos->getCollection()->map(function ($vehiculo) {
        return [
            'id' => $vehiculo->id,
            'plate' => $vehiculo->plate,
            'brand' => $vehiculo->brand,
            'model' => $vehiculo->model,
            'manufacturing_year' => $vehiculo->manufacturing_year,
            'contact' => $vehiculo->contacts ? [
                'first_name' => $vehiculo->contacts->first_name,
                'last_name' => $vehiculo->contacts->last_name,
                'document_number' => $vehiculo->contacts->document_number,
                'email' => $vehiculo->contacts->email,
                'phone' => $vehiculo->contacts->phone,
            ] : null,
        ];
    });

    $vehiculos->setCollection($formateados);

    return response()->json($vehiculos);
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    DB::transaction(function () use ($request) {
        $vehiculo = Vehicles::create([
            'plate' => $request->input('plate'),
            'brand' => $request->input('brand'),
            'model' => $request->input('model'),
            'manufacturing_year' => $request->input('manufacturing_year'),
        ]);

        $vehiculo->contacts()->create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'document_number' => $request->input('document_number'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);
    });

    return response()->json([
        'message' => 'Vehículo y contacto creados correctamente.'
    ]);
}

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $vehiculo = Vehicles::with('contacts')->findOrFail($id);

    $contact = $vehiculo->contacts->first();

    return response()->json([
        'id' => $vehiculo->id,
        'plate' => $vehiculo->plate,
        'brand' => $vehiculo->brand,
        'model' => $vehiculo->model,
        'manufacturing_year' => $vehiculo->manufacturing_year,
        'first_name' => $contact ? $contact->first_name : '',
        'last_name' => $contact ? $contact->last_name : '',
        'document_number' => $contact ? $contact->document_number : '',
        'email' => $contact ? $contact->email : '',
        'phone' => $contact ? $contact->phone : '',
    ]);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('vehicles.edit', ['vehiculoId' => $id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    try {
        DB::beginTransaction();

        // Buscar el vehículo
        $vehiculo = Vehicles::findOrFail($id);

        // Actualizar datos del vehículo
        $vehiculo->update([
            'plate' => $request->plate,
            'brand' => $request->brand,
            'model' => $request->model,
            'manufacturing_year' => $request->manufacturing_year,
        ]);

        // Actualizar datos del contacto relacionado
        if ($vehiculo->contacts) {
            $vehiculo->contacts->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'document_number' => $request->document_number,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
        }

        DB::commit();

        return response()->json([
            'message' => 'Vehículo y contacto actualizados correctamente.'
        ]);
    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'message' => 'Ocurrió un error al actualizar.',
            'error' => $e->getMessage()
        ], 500);
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $vehiculo = Vehicles::with('contacts')->findOrFail($id);


        if ($vehiculo->contacts) {
            $vehiculo->contacts->delete();
        }

        $vehiculo->delete();
    
        return [
            'success' => true,
            'message' => 'Eliminado con éxito.'
        ];
    }
    
}
