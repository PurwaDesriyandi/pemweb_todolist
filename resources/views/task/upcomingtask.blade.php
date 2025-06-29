@extends('layouts.app')

@section('title', 'Upcoming Tasks')

@push('styles')
<style>
    .upcoming-tasks-card {
        margin-bottom: 2rem;
    }

    .task-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .task-item {
        display: flex;
        align-items: flex-start;
        padding: 1rem;
        margin-bottom: 0.75rem;
        background-color: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .task-item:hover {
        background-color: #e9ecef;
    }

    .task-item.completed {
        opacity: 0.7;
        background-color: #d1edff;
    }

    .task-item.completed .task-title {
        text-decoration: line-through;
        color: #6c757d;
    }

    .task-checkbox {
        margin-right: 1rem;
        margin-top: 0.25rem;
        transform: scale(1.2);
    }

    .task-content {
        flex-grow: 1;
    }

    .task-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #212529;
    }

    .task-deadline {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }

    .task-deadline.urgent {
        color: #dc3545;
        font-weight: 600;
    }

    .task-deadline.today {
        color: #fd7e14;
        font-weight: 600;
    }

    .task-description {
        font-size: 0.875rem;
        color: #6c757d;
        line-height: 1.4;
    }

    .days-remaining {
        font-size: 0.8rem;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-weight: 500;
        margin-left: 0.5rem;
    }

    .days-remaining.urgent {
        background-color: #f8d7da;
        color: #721c24;
    }

    .days-remaining.today {
        background-color: #fff3cd;
        color: #856404;
    }

    .days-remaining.normal {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .no-tasks {
        text-align: center;
        padding: 3rem 1rem;
        color: #6c757d;
    }

    .no-tasks i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #dee2e6;
    }
</style>
@endpush

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container">
    <div class="card upcoming-tasks-card">
        <div class="card-header">
            <h3 class="card-title">Upcoming Tasks</h3>
            <small class="text-muted">Tasks with deadlines from today onwards</small>
        </div>
        <div class="card-body">
            <ul class="task-list" id="upcoming-task-list">
                @forelse ($tasks as $task)
                    @php
                        $deadline = \Carbon\Carbon::parse($task->deadline);
                        $today = \Carbon\Carbon::today();
                        $daysRemaining = $today->diffInDays($deadline, false);
                        
                        $urgencyClass = '';
                        $urgencyText = '';
                        
                        if ($daysRemaining < 0) {
                            $urgencyClass = 'urgent';
                            $urgencyText = 'Overdue';
                        } elseif ($daysRemaining == 0) {
                            $urgencyClass = 'today';
                            $urgencyText = 'Due Today';
                        } elseif ($daysRemaining == 1) {
                            $urgencyClass = 'urgent';
                            $urgencyText = 'Due Tomorrow';
                        } elseif ($daysRemaining <= 3) {
                            $urgencyClass = 'urgent';
                            $urgencyText = $daysRemaining . ' days left';
                        } else {
                            $urgencyClass = 'normal';
                            $urgencyText = $daysRemaining . ' days left';
                        }
                    @endphp
                    
                    <li class="task-item {{ $task->status === 'Selesai' ? 'completed' : '' }}" data-status="{{ $task->status }}">
                        <input type="checkbox" class="task-checkbox" data-id="{{ $task->id }}" {{ $task->status === 'Selesai' ? 'checked' : '' }}>
                        <div class="task-content">
                            <div class="task-title">
                                {{ $task->title }}
                            </div>
                            <div class="task-deadline {{ $urgencyClass }}">
                                Deadline: {{ $deadline->format('d/m/Y') }}
                                <span class="days-remaining {{ $urgencyClass }}">
                                    {{ $urgencyText }}
                                </span>
                            </div>
                            @if($task->description)
                                <div class="task-description">
                                    {{ $task->description }}
                                </div>
                            @endif
                        </div>
                    </li>
                @empty
                    <li class="no-tasks">
                        <i class="fas fa-calendar-check"></i>
                        <div>
                            <h5>No upcoming tasks found</h5>
                            <p>All your tasks are either completed or you haven't added any tasks yet.</p>
                        </div>
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
                    const taskItem = e.target.closest('.task-item');
                    const taskId = e.target.dataset.id;
                    const isChecked = e.target.checked;
                    
                    // Update UI immediately
                    taskItem.classList.toggle('completed', isChecked);
                    
                    // Update status in backend
                    updateTaskStatus(taskId, isChecked ? 'Selesai' : 'Belum Dikerjakan');
                }
            });
        }
        
        function updateTaskStatus(taskId, status) {
            fetch(`/tasks/${taskId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to update task status');
                }
                return response.json();
            })
            .then(data => {
                console.log('Task status updated successfully:', data);
            })
            .catch(error => {
                console.error('Error updating task status:', error);
                // Optionally revert the UI change if the update failed
                location.reload();
            });
        }

        //search functionality
        const searchInput = document.querySelector('.form-control[placeholder="Search..."]');
        const tasks = document.querySelectorAll('.task-item');
        searchInput.addEventListener('input', () => {
            const query = searchInput.value.toLowerCase();

            tasks.forEach(task => {
                const title = task.querySelector('.task-title').textContent.toLowerCase();
                if (title.includes(query)) {
                    task.style.display = 'flex'; // Show task
                } else {
                    task.style.display = 'none'; // Hide task
                }
            });
        });
    });
</script>
@endpush