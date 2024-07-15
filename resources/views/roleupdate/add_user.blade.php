@extends('layouts.app')

@section('title', 'Add User')

@section('contents')
<h1 class="mb-0">Add User</h1>
<hr>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('user.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ old('name') }}" required>
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required>
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
            <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
            @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-sm-6">
            <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
            <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password" required>
            @error('password_confirmation')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
        <select name="role_id" id="role_id" class="form-control @error('role_id') is-invalid @enderror" required>
            <option value="">Select Role</option>
            @foreach(\App\Models\RolePermission::all() as $rolePermission)
                <option value="{{ $rolePermission->id }}">{{ $rolePermission->role }}</option>
            @endforeach
        </select>
        @error('role_id')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    <div class="row">
        <div class="col text-center">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('role.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</form>
@endsection
