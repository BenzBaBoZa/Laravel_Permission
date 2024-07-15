@extends('layouts.app')

@php
use Illuminate\Support\Facades\DB;

$role_permissions = DB::table('users')
    ->select('role_permissions.*')
    ->join('role_permissions', 'users.role_id', '=', 'role_permissions.id')
    ->where('users.id', auth()->user()->id)
    ->first();
@endphp

@section('title', 'System Permissions')

@section('contents')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<h1 class="mb-0">Permissions</h1>
<hr>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Topbar Search and Add Permission Button -->
<div class="d-flex justify-content-between mb-3">
    <form class="form-inline" action="{{ route('permissionssearch.search') }}" method="POST">
        @csrf
        <input class="form-control mr-sm-2" type="text" placeholder="Search Permissions" aria-label="Search" name="query">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    @if($role_permissions->Permissions_Set != 1)
    {{-- ถ้าค่า Permissions_Set ไม่ใช่ 1 ให้แสดงปุ่ม Add Permission --}}
    <a href="{{ route('permissions.create') }}" class="btn btn-success">Add Permission</a>
    @endif
</div>

<table class="table">
    <thead>
        <tr>
            <th>No.</th>
            <th>Role</th>
            <th>Product Set</th>
            <th>Profile Set</th>
            <th>System Users Set</th>
            <th>Permissions Set</th>
            <th>Created At</th>
            <th>Updated At</th>
            @if($role_permissions->Permissions_Set != 1)
            {{-- ถ้าค่า Permissions_Set ไม่ใช่ 1 ให้แสดงคอลัมน์ Action --}}
            <th>Action</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @if($permissions->count() > 0)
            @foreach ($permissions as $index => $permission)
                <tr>
                    <td class="align-middle">{{ $permissions->firstItem() + $index }}</td>
                    <td class="align-middle">{{ $permission->role }}</td>
                    <td class="align-middle">{{ permissionText($permission->Product_Set) }}</td>
                    <td class="align-middle">{{ permissionText($permission->Profile_Set) }}</td>
                    <td class="align-middle">{{ permissionText($permission->System_Users_Set) }}</td>
                    <td class="align-middle">{{ permissionText($permission->Permissions_Set) }}</td>
                    <td class="align-middle">{{ formatDateThai($permission->created_at) }}</td>
                    <td class="align-middle">{{ formatDateThai($permission->updated_at) }}</td>
                    @if($role_permissions->Permissions_Set != 1)
                    {{-- ถ้าค่า Permissions_Set ไม่ใช่ 1 ให้แสดงปุ่ม Action --}}
                    <td class="align-middle">
                        <div class="btn-group" role="group" aria-label="Actions">
                            <a href="{{ route('permissions.show', $permission->id) }}" type="button" class="btn btn-secondary" style="border: none; width: 40px; height: 40px;">
                                <i class="fas fa-info-circle"></i>
                            </a>
                            <a href="{{ route('permissions.edit', $permission->id) }}" type="button" class="btn btn-warning" style="border: none; width: 40px; height: 40px;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="p-0 m-0 delete-form" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger m-0 p-0 delete-btn" style="border: none; width: 40px; height: 40px;" onclick="return confirmDelete(this);">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="9">Permission not found</td>
            </tr>
        @endif
    </tbody>
</table>

{{ $permissions->links('pagination::bootstrap-5') }}

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

<?php
function permissionText($value) {
    switch ($value) {
        case 0:
            return 'ไม่ได้รับอนุญาติ';
        case 1:
            return 'อ่านเท่านั้น';
        case 2:
            return 'ควบคุมทั้งหมด';
        default:
            return 'Unknown';
    }
}

function formatDateThai($date) {
    return $date->format('d/m/') . ($date->year + 543) . $date->format(' H:i:s');
}
?>
