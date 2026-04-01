@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-slate-900 flex items-center gap-3">
        <i class="fas fa-th-large text-blue-600"></i>
        Home
    </h1>
    <p class="text-slate-500 mt-2">Select the module you want to manage.</p>
</div>

<div class="flex flex-wrap justify-center gap-4">
    <a href="{{ route('dashboard') }}" class="group home-card rounded-xl border border-blue-200 bg-gradient-to-br from-blue-100 to-blue-50 p-4 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-semibold text-blue-800">Dashboard</h3>
            <span class="text-blue-600 text-xl"><i class="fas fa-chart-line"></i></span>
        </div>
        <p class="text-sm text-blue-700 mt-2">Live KPIs and recent activity</p>
    </a>

    <a href="{{ route('users.index') }}" class="group home-card rounded-xl border border-purple-200 bg-gradient-to-br from-purple-100 to-purple-50 p-4 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-semibold text-purple-800">Users</h3>
            <span class="text-purple-600 text-xl"><i class="fas fa-user-shield"></i></span>
        </div>
        <p class="text-sm text-purple-700 mt-2">Manage system users</p>
    </a>

    <a href="{{ route('clients.index') }}" class="group home-card rounded-xl border border-green-200 bg-gradient-to-br from-green-100 to-green-50 p-4 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-semibold text-green-800">Clients</h3>
            <span class="text-green-600 text-xl"><i class="fas fa-users"></i></span>
        </div>
        <p class="text-sm text-green-700 mt-2">Manage customer records</p>
    </a>

    <a href="{{ route('vehicles.index') }}" class="group home-card rounded-xl border border-orange-200 bg-gradient-to-br from-orange-100 to-orange-50 p-4 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-semibold text-orange-800">Vehicles</h3>
            <span class="text-orange-600 text-xl"><i class="fas fa-car"></i></span>
        </div>
        <p class="text-sm text-orange-700 mt-2">Track vehicles in service</p>
    </a>

    <a href="{{ route('jobs.index') }}" class="group home-card rounded-xl border border-amber-200 bg-gradient-to-br from-amber-100 to-amber-50 p-4 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-semibold text-amber-800">Jobs</h3>
            <span class="text-amber-600 text-xl"><i class="fas fa-tools"></i></span>
        </div>
        <p class="text-sm text-amber-700 mt-2">Manage repair work orders</p>
    </a>

    <a href="{{ route('invoices.index') }}" class="group home-card rounded-xl border border-indigo-200 bg-gradient-to-br from-indigo-100 to-indigo-50 p-4 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-semibold text-indigo-800">Invoices</h3>
            <span class="text-indigo-600 text-xl"><i class="fas fa-file-invoice"></i></span>
        </div>
        <p class="text-sm text-indigo-700 mt-2">Create and manage invoices</p>
    </a>

    <a href="{{ route('payments.index') }}" class="group home-card rounded-xl border border-cyan-200 bg-gradient-to-br from-cyan-100 to-cyan-50 p-4 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-semibold text-cyan-800">Payments</h3>
            <span class="text-cyan-600 text-xl"><i class="fas fa-credit-card"></i></span>
        </div>
        <p class="text-sm text-cyan-700 mt-2">Record and track payments</p>
    </a>
    <a href="{{ route('receipts.index') }}" class="group home-card rounded-xl border border-pink-200 bg-gradient-to-br from-pink-100 to-pink-50 p-4 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-semibold text-pink-800">Receipts</h3>
            <span class="text-pink-600 text-xl"><i class="fas fa-receipt"></i></span>
        </div>
        <p class="text-sm text-pink-700 mt-2">Generate and print receipts</p>
    </a>

    <a href="{{ route('logs.index') }}" class="group home-card rounded-xl border border-slate-200 bg-gradient-to-br from-slate-100 to-slate-50 p-4 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-semibold text-slate-800">Activity Logs</h3>
            <span class="text-slate-600 text-xl"><i class="fas fa-history"></i></span>
        </div>
        <p class="text-sm text-slate-700 mt-2">Track system activities</p>
    </a>

    <a href="{{ route('backups.index') }}" class="group home-card rounded-xl border border-red-200 bg-gradient-to-br from-red-100 to-red-50 p-4 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-semibold text-red-800">Backups</h3>
            <span class="text-red-600 text-xl"><i class="fas fa-database"></i></span>
        </div>
        <p class="text-sm text-red-700 mt-2">Manage database backups</p>
    </a>

    <form method="POST" action="{{ route('logout') }}" class="group home-card rounded-xl border border-rose-200 bg-gradient-to-br from-rose-100 to-rose-50 p-4 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-transform duration-300">
        @csrf
        <button type="submit" class="w-full text-left">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-semibold text-rose-800">Logout</h3>
                <span class="text-rose-600 text-xl"><i class="fas fa-sign-out-alt"></i></span>
            </div>
            <p class="text-sm text-rose-700 mt-2">Sign out of the system</p>
        </button>
    </form>
</div>
@endsection