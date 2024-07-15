@extends('layouts.app')

@php
use Illuminate\Support\Facades\DB;

$role_permissions = DB::table('users')
    ->select('role_permissions.*')
    ->join('role_permissions', 'users.role_id', '=', 'role_permissions.id')
    ->where('users.id', auth()->user()->id)
    ->first();
@endphp

@section('title', 'Home Product')

@section('contents')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="d-flex align-items-center justify-content-between">
    <form action="{{ route('products.index') }}" method="GET" class="d-flex">
        <input type="text" name="search" class="form-control" placeholder="Search" value="{{ request()->input('search') }}">
        <button type="submit" class="btn btn-primary ml-2">Search</button>
    </form>

    @if($role_permissions->Permissions_Set != 1)
    <div class="d-flex">
        {{-- ปุ่มนําเข้า Excel --}}
        <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
            @csrf
            <input type="file" name="file" class="form-control-file">
            <button type="submit" class="btn btn-info ml-2">Import Excel</button>
        </form>
        {{-- ปุ่มส่งออก Excel --}}
        <a href="{{ route('products.export', ['search' => request()->input('search')]) }}" class="btn btn-success ml-2">Export Excel</a>
        {{-- ถ้าค่า Permissions_Set ไม่ใช่ 1 ให้แสดงปุ่ม Add Permission --}}
        <a href="{{ route('products.create') }}" class="btn btn-primary ml-2">Add Product</a>
    </div>
    @endif
</div>
<hr>

@if(Session::has('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ Session::get('success') }}'
        });
    </script>
@endif

@if(Session::has('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: '{!! Session::get('error') !!}'
        });
    </script>
@endif

<table id="example" class="table table-striped table-bordered" style="width:100%">
    <thead class="table-primary">
        <tr>
            <th>No.</th>
            <th>Title</th>
            <th>Price</th>
            <th>Product Code</th>
            <th>Description</th>
            <th>Name</th>
            @if($role_permissions->Permissions_Set != 1)
            <th>Action</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @if($products->count() > 0)
            @foreach($products as $index => $rs)
                <tr>
                    <td class="align-middle">{{ $products->firstItem() + $index }}</td>
                    <td class="align-middle">{{ $rs->title }}</td>
                    <td class="align-middle">{{ $rs->price }}</td>
                    <td class="align-middle">{{ $rs->product_code }}</td>
                    <td class="align-middle">{{ $rs->description }}</td>
                    <td class="align-middle">{{ $rs->user ? $rs->user->name : 'N/A' }}</td>
                    @if($role_permissions->Permissions_Set != 1)
                    <td class="align-middle">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('products.show', $rs->id) }}" type="button" class="btn btn-secondary" style="border: none; width: 40px; height: 40px;">
                                <i class="fas fa-info-circle"></i>
                            </a>
                            <a href="{{ route('products.edit', $rs->id) }}" type="button" class="btn btn-warning" style="border: none; width: 40px; height: 40px;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('products.destroy', $rs->id) }}" method="POST" class="p-0 m-0 delete-form" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger m-0 p-0 delete-btn" style="border: none; width: 40px; height: 40px;">
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
                <td class="text-center" colspan="7">Product not found</td>
            </tr>
        @endif
    </tbody>
</table>

{{ $products->links('pagination::bootstrap-5') }}

<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const form = this.closest('form');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

@endsection
