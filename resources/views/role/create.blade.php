@extends('layouts.app')

@section('title', 'Add Role')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add New Role</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Role Name</label>
                    <input type="text" name="name" id="name" class="form-control form-control-lg" style="border: 2px solid #ccc; padding: 10px; border-radius: 5px;">
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
