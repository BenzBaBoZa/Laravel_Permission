@extends('layouts.app')

@section('title', 'Show Permission')

@section('contents')

<h1 class="mb-0">Detail Permission</h1>
<hr>

<div class="form-group">
    <label for="role">Role Name</label>
    <input type="text" class="form-control" id="role" name="role" value="{{ $permission->role }}" readonly>
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
                    <td><input type="radio" name="{{ $role }}" value="0" {{ $permission->$role == '0' ? 'checked' : '' }} disabled></td>
                    <td><input type="radio" name="{{ $role }}" value="1" {{ $permission->$role == '1' ? 'checked' : '' }} disabled></td>
                    <td><input type="radio" name="{{ $role }}" value="2" {{ $permission->$role == '2' ? 'checked' : '' }} disabled></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col text-center">
        <a href="{{ route('home.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

@endsection
