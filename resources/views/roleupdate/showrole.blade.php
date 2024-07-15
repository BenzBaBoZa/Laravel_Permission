@extends('layouts.app')

@section('title', 'Show User')

@section('contents')
    <h1 class="mb-0">Detail User</h1>
    <hr />
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $user->name }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Email</label>
            <input type="text" name="email" class="form-control" placeholder="Email" value="{{ $user->email }}" readonly>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Role</label>
            <input type="text" name="role_id" class="form-control" placeholder="Role" value="{{ optional($user->role_permissions)->role ?? 'N/A' }}" readonly>
        </div>
        <div class="col mb-3">
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">Created At</label>
            <input type="text" name="created_at" class="form-control" placeholder="Created At" value="{{ optional($user->created_at)->format('d/m/Y H:i:s') }}" readonly>
        </div>
        <div class="col mb-3">
            <label class="form-label">Updated At</label>
            <input type="text" name="updated_at" class="form-control" placeholder="Updated At" value="{{ optional($user->updated_at)->format('d/m/Y H:i:s') }}" readonly>
        </div>
    </div>
    <div class="row">
        <div class="col text-center">
            <a href="{{ route('role.index') }}" class="btn btn-secondary mx-2">Back</a>
        </div>
    </div>
@endsection
