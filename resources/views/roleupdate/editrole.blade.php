@extends('layouts.app')

@section('title', 'Edit User')

@section('contents')
<h1>Edit User</h1>
<hr>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form id="edit-user-form" method="POST" action="{{ route('role.update', $user->id) }}">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Name <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="email">Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="form-group">
        <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
        <select name="role_id" id="role_id" class="form-control @error('role_id') is-invalid @enderror" required>
            <option value="">Select Role</option>
            @foreach($rolePermissions as $rolePermission)
                <option value="{{ $rolePermission->id }}" {{ old('role_id', $user->role_id ?? '') == $rolePermission->id ? 'selected' : '' }}>
                    {{ $rolePermission->role }}
                </option>
            @endforeach
        </select>
        @error('role_id')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
    
    <button type="button" class="btn btn-primary" onclick="confirmUpdate()">Update</button>
    <a href="{{ route('role.index') }}" class="btn btn-secondary">Cancel</a>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmUpdate() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to update the user information!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('edit-user-form').submit();
            }
        });
    }
</script>

@endsection
