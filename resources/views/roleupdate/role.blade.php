@extends('layouts.app')

@php
use Illuminate\Support\Facades\DB;

$role_permissions = DB::table('users')
    ->select('role_permissions.*')
    ->join('role_permissions', 'users.role_id', '=', 'role_permissions.id')
    ->where('users.id', auth()->user()->id)
    ->first();
@endphp

@section('title', 'System Users')

@section('contents')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<h1 class="mb-0"></h1>
<hr>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Topbar Search and Add User Button -->
<div class="d-flex justify-content-between mb-3">
    <form class="form-inline" action="{{ route('role.search') }}" method="GET">
        <input class="form-control mr-sm-2" type="search" placeholder="Search Users" aria-label="Search" name="query">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    @if($role_permissions->Permissions_Set != 1)
    {{-- ถ้าค่า Permissions_Set ไม่ใช่ 1 ให้แสดงปุ่ม Add Permission --}}
    <a href="{{ route('user.add') }}" class="btn btn-success">Add User</a>
    @endif
</div>

<table class="table">
    <thead>
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            @if($role_permissions->Permissions_Set != 1)
    {{-- ถ้าค่า Permissions_Set ไม่ใช่ 1 ให้แสดงปุ่ม Add Permission --}}
            <th>Action</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @if($users->count() > 0)
            @foreach ($users as $index => $rn)
                <tr>
                    <td class="align-middle">{{ $users->firstItem() + $index }}</td>
                    <td class="align-middle">{{ $rn->name }}</td>
                    <td class="align-middle">{{ $rn->email }}</td>
                    <td class="align-middle">{{ optional($rn->role_permissions)->role ?? 'N/A' }}</td>
                    @if($role_permissions->Permissions_Set != 1)
    {{-- ถ้าค่า Permissions_Set ไม่ใช่ 1 ให้แสดงปุ่ม Add Permission --}}
                    <td class="align-middle">
                        @if($rn->id != 1)
                        <div class="btn-group" role="group" aria-label="Actions">
                            <a href="{{ route('user.show', $rn->id) }}" type="button" class="btn btn-secondary" style="border: none; width: 40px; height: 40px;">
                                <i class="fas fa-info-circle"></i>
                            </a>
                            <a href="{{ route('user.edit', $rn->id) }}" type="button" class="btn btn-warning" style="border: none; width: 40px; height: 40px;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('user.destroy', $rn->id) }}" method="POST" class="p-0 m-0 delete-form" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger m-0 p-0 delete-btn" style="border: none; width: 40px; height: 40px;" onclick="return confirmDelete(this);">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                        @else
                        <span class="text-danger">Unable to edit data</span>
                        @endif
                    </td>
                    @endif
                </tr>
            @endforeach
        @else
        <tr>
            <td class="text-center" colspan="5">User not found</td>
        </tr>
        @endif
    </tbody>
</table>

{{ $users->links('pagination::bootstrap-5') }}

<script>
    function confirmDelete(button) {
        event.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }
</script>

@endsection
