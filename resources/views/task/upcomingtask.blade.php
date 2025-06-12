@extends('layouts.app')

@section('title', 'Upcoming Tasks')

@push('styles')
<style>
    .task-list { list-style-type: none; padding: 0; }
    .task-item {
        display: flex;
        align-items: center;
        padding: 0.85rem 0.25rem;
        border-bottom: 1px solid #f2f2f2;
        gap: 0.75rem;
    }
    .task-item:last-child { border-bottom: none; }
    .task-checkbox { width: 18px; height: 18px; cursor: pointer; flex-shrink: 0; }
    .priority-indicator { width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0; }
    .priority-high { background-color: #f72585; }
    .priority-medium { background-color: #f8961e; }
    .priority-low { background-color: #4cc9f0; }
    .task-text { flex-grow: 1; font-size: 0.95rem; }
    .task-date { font-size: 0.85rem; color: #6c757d; flex-shrink: 0; min-width: 50px; text-align: right; }
    .task-item.completed .task-text { text-decoration: line-through; color: #6c757d; }
</style>
@endpush

@section('content')
@php
    $tasks = [
        ['title' => 'Quarterly review meeting', 'priority' => 'high', 'due_date' => '2025-06-15'],
        ['title' => 'Client presentation', 'priority' => 'high', 'due_date' => '2025-06-18'],
        ['title' => 'Update documentation', 'priority' => 'medium', 'due_date' => '2025-06-20'],
        ['title' => 'Review Q2 budget', 'priority' => 'medium', 'due_date' => '2025-06-25'],
        ['title' => 'Plan team outing', 'priority' => 'low', 'due_date' => '2025-06-27'],
        ['title' => 'Submit monthly report', 'priority' => 'medium', 'due_date' => '2025-06-30'],
        ['title' => 'Prepare for July kickoff', 'priority' => 'high', 'due_date' => '2025-07-01'],
        ['title' => 'Order new office supplies', 'priority' => 'low', 'due_date' => '2025-07-03'],
    ];
@endphp

<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Upcoming Tasks</div>
            <div class="card-stats">{{ count($tasks) }} tasks</div>
        </div>
        <div class="card-body">
            <ul class="task-list" id="upcoming-task-list">
                @forelse ($tasks as $task)
                    <li class="task-item">
                        <div class="priority-indicator priority-{{ $task['priority'] }}"></div>
                        <input type="checkbox" class="task-checkbox">
                        <span class="task-text">{{ $task['title'] }}</span>
                        <div class="task-date">
                            {{ \Carbon\Carbon::parse($task['due_date'])->format('M d') }}
                        </div>
                    </li>
                @empty
                    <li class="task-item text-muted">
                        No upcoming tasks. Great job!
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const taskList = document.getElementById('upcoming-task-list');
        if (taskList) {
            taskList.addEventListener('change', function(e) {
                if (e.target.classList.contains('task-checkbox')) {
                    e.target.closest('.task-item').classList.toggle('completed', e.target.checked);
                }
            });
        }
    });
</script>
@endpush
