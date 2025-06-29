@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <header>
        <h1>Dashboard</h1>
        <div class="date-display" id="currentDate"></div>
    </header>

    <div class="summary-card card">
        <div class="card-header">
            <div class="card-title">Summary</div>
        </div>
        <div class="summary-stats">
            <div class="stat-box">
            <div class="stat-number">{{ $totalTasks }}</div>
            <div class="stat-label">Total Tasks</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $completedCount }}</div>
            <div class="stat-label">Completed</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $dueTodayCount }}</div>
            <div class="stat-label">Due Today</div>
        </div>
        <div class="stat-box">
            <div class="stat-number">{{ $overdueCount }}</div>
            <div class="stat-label">Overdue</div>
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
