@extends('layouts.app')

@section('title', 'Edit Permission')

@section('contents')

<!-- Other head content -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

<h1 class="mb-0">Edit Permission</h1>
<hr>

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
        });
    </script>
@endif

<form id="edit-permission-form" action="{{ route('permissions.update', $permission->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="role">Role Name</label>
        <input type="text" class="form-control" id="role" name="role" value="{{ old('role', $permission->role) }}" required>
    </div>

    <div class="form-group">
        <label>กำหนดสิทธิ์การใช้งาน</label>
        <table class="table">
            <thead>
                <tr>
                    <th>หน้าที่</th>
                    <th>ไม่ได้รับอนุญาติ</th>
                    <th>อ่านเท่านั้น</th>
                    <th>ควบคุมทั้งหมด</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $roles = ['Product_Set', 'Profile_Set', 'System_Users_Set', 'Permissions_Set'];
                @endphp
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role }}</td>
                        <td><input type="radio" name="{{ $role }}" value="0" {{ old($role, $permission->$role) == '0' ? 'checked' : '' }} required></td>
                        <td><input type="radio" name="{{ $role }}" value="1" {{ old($role, $permission->$role) == '1' ? 'checked' : '' }}></td>
                        <td><input type="radio" name="{{ $role }}" value="2" {{ old($role, $permission->$role) == '2' ? 'checked' : '' }}></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <button type="button" class="btn btn-success" id="confirm-button">บันทึก</button>
    <a href="{{ route('home.index') }}" class="btn btn-secondary">ยกเลิก</a>
</form>

<script>
    document.getElementById('confirm-button').addEventListener('click', function() {
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "คุณต้องการบันทึกการเปลี่ยนแปลงนี้!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, บันทึกเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('edit-permission-form').submit();
            }
        });
    });
</script>

@endsection
