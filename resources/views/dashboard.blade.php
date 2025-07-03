@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="py-6">
    <header class="mb-6">
        <h1 class="text-2xl font-bold mb-1">Dashboard</h1>
        <div class="text-gray-500" id="currentDate"></div>
    </header>

    <div class="card bg-base-100 shadow p-6">
        <div class="card-title text-lg font-semibold mb-4">Summary</div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <div class="stat-box bg-indigo-50 rounded-lg p-4 flex flex-col items-center">
                <div class="stat-number text-2xl font-bold">{{ $totalTasks }}</div>
                <div class="stat-label text-gray-600">Total Tasks</div>
            </div>
            <div class="stat-box bg-green-50 rounded-lg p-4 flex flex-col items-center">
                <div class="stat-number text-2xl font-bold">{{ $completedCount }}</div>
                <div class="stat-label text-gray-600">Completed</div>
            </div>
            <div class="stat-box bg-yellow-50 rounded-lg p-4 flex flex-col items-center">
                <div class="stat-number text-2xl font-bold">{{ $dueTodayCount }}</div>
                <div class="stat-label text-gray-600">Due Today</div>
            </div>
            <div class="stat-box bg-red-50 rounded-lg p-4 flex flex-col items-center">
                <div class="stat-number text-2xl font-bold">{{ $overdueCount }}</div>
                <div class="stat-label text-gray-600">Overdue</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('currentDate').textContent = new Date().toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
</script>
@endpush
