@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-slate-900 flex items-center gap-3">
        <i class="fas fa-chart-line text-blue-600"></i> Dashboard
    </h1>
    <p class="text-slate-500 mt-2">Overview of your garage metrics and recent activity.</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-8">
    <div class="card stat-card stat-card-blue">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide">Total Clients</p>
                <p class="mt-2 text-4xl font-bold text-blue-700">{{ \App\Models\Client::count() }}</p>
            </div>
            <i class="fas fa-users text-blue-400 text-4xl"></i>
        </div>
    </div>
    <div class="card stat-card stat-card-green">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide">Total Vehicles</p>
                <p class="mt-2 text-4xl font-bold text-green-700">{{ \App\Models\Vehicle::count() }}</p>
            </div>
            <i class="fas fa-car text-green-400 text-4xl"></i>
        </div>
    </div>
    <div class="card stat-card stat-card-amber">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide">Total Jobs</p>
                <p class="mt-2 text-4xl font-bold text-amber-700">{{ \App\Models\Job::count() }}</p>
            </div>
            <i class="fas fa-tools text-amber-400 text-4xl"></i>
        </div>
    </div>
    <div class="card stat-card stat-card-purple">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide">Total Revenue</p>
                <p class="mt-2 text-4xl font-bold text-purple-700">UGX {{ number_format(\App\Models\Payment::sum('amount_paid'), 2) }}</p>
            </div>
            <i class="fas fa-money-bill text-purple-400 text-4xl"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-md border border-slate-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-cyan-600 px-6 py-4 flex items-center gap-2">
            <i class="fas fa-history text-white"></i>
            <h2 class="text-lg font-bold text-white">Recent Jobs</h2>
        </div>
        <div class="p-6 space-y-3">
            @forelse(\App\Models\Job::latest()->take(5)->get() as $job)
                <div class="rounded-lg border border-slate-200 p-4 hover:border-blue-300 transition">
                    <div class="flex justify-between items-center">
                        <p class="font-semibold text-slate-800">{{ $job->job_number }}</p>
                        <span class="text-xs px-2 py-1 rounded-full {{ $job->status === 'Completed' ? 'status-completed' : ($job->status === 'In Progress' ? 'status-in-progress' : 'status-pending') }}">{{ $job->status }}</span>
                    </div>
                    <p class="text-sm text-slate-500 mt-1">{{ Str::limit($job->description, 80) }}</p>
                    <p class="text-xs text-slate-400 mt-2">{{ $job->client->name }} • {{ $job->vehicle->car_model ?? 'No vehicle' }}</p>
                </div>
            @empty
                <p class="text-slate-500 text-center py-4">No jobs available.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-slate-100 overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-fuchsia-600 px-6 py-4 flex items-center gap-2">
            <i class="fas fa-credit-card text-white"></i>
            <h2 class="text-lg font-bold text-white">Pending Payments</h2>
        </div>
        <div class="p-6 space-y-3">
            @forelse(\App\Models\Invoice::whereIn('status', ['Unpaid', 'Partially Paid'])->latest()->take(5)->get() as $invoice)
                <div class="rounded-lg border border-slate-200 p-4 hover:border-purple-300 transition">
                    <div class="flex justify-between items-center">
                        <p class="font-semibold text-slate-800">{{ $invoice->invoice_number }}</p>
                        <span class="text-xs px-2 py-1 rounded-full {{ $invoice->status === 'Partially Paid' ? 'status-partially-paid' : 'status-unpaid' }}">{{ $invoice->status }}</span>
                    </div>
                    <p class="text-sm text-slate-500 mt-1">UGX {{ number_format($invoice->total_amount, 2) }}</p>
                    <p class="text-xs text-slate-400 mt-2">Job: {{ $invoice->job->job_number ?? 'N/A' }}</p>
                </div>
            @empty
                <p class="text-slate-500 text-center py-4">No pending payments.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
