<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Client;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with('client', 'vehicle')->paginate(15);
        return view('jobs.index', compact('jobs'));
    }

    public function create()
    {
        $clients = Client::all();
        $vehicles = Vehicle::all();
        return view('jobs.create', compact('clients', 'vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:garage_clients,id',
            'vehicle_id' => 'required|exists:garage_vehicles,id',
            'description' => 'required|string',
            'assigned_mechanic' => 'nullable|string|max:255',
        ]);

        // Generate job number
        $lastJob = Job::orderBy('id', 'desc')->first();
        $jobNumber = 'JOB-' . str_pad((($lastJob?->id ?? 0) + 1), 4, '0', STR_PAD_LEFT);

        Job::create([
            'garage_client_id' => $validated['client_id'],
            'garage_vehicle_id' => $validated['vehicle_id'],
            'job_number' => $jobNumber,
            'description' => $validated['description'],
            'assigned_mechanic' => $validated['assigned_mechanic'],
        ]);

        return redirect()->route('jobs.index')->with('success', 'Job created successfully!');
    }

    public function show(Job $job)
    {
        $job->load('client', 'vehicle', 'invoice.items');
        return view('jobs.show', compact('job'));
    }

    public function edit(Job $job)
    {
        $clients = Client::all();
        $vehicles = Vehicle::all();
        return view('jobs.edit', compact('job', 'clients', 'vehicles'));
    }

    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:garage_clients,id',
            'vehicle_id' => 'required|exists:garage_vehicles,id',
            'description' => 'required|string',
            'assigned_mechanic' => 'nullable|string|max:255',
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        $job->update([
            'garage_client_id' => $validated['client_id'],
            'garage_vehicle_id' => $validated['vehicle_id'],
            'description' => $validated['description'],
            'assigned_mechanic' => $validated['assigned_mechanic'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('jobs.index')->with('success', 'Job updated successfully!');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully!');
    }
}
