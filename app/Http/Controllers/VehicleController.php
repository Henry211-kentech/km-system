<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Client;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('client', 'jobs')->paginate(15);
        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $clients = Client::all();
        return view('vehicles.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:garage_clients,id',
            'car_model' => 'required|string|max:255',
            'number_plate' => 'required|string|unique:garage_vehicles,number_plate',
        ]);

        Vehicle::create([
            'garage_client_id' => $validated['client_id'],
            'car_model' => $validated['car_model'],
            'number_plate' => $validated['number_plate'],
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle created successfully!');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load('client', 'jobs');
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $clients = Client::all();
        return view('vehicles.edit', compact('vehicle', 'clients'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:garage_clients,id',
            'car_model' => 'required|string|max:255',
            'number_plate' => 'required|string|unique:garage_vehicles,number_plate,' . $vehicle->id,
        ]);

        $vehicle->update([
            'garage_client_id' => $validated['client_id'],
            'car_model' => $validated['car_model'],
            'number_plate' => $validated['number_plate'],
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully!');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully!');
    }
}
