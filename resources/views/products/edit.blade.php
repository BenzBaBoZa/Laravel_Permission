@extends('layouts.app')

@section('title', 'Edit Product')

@section('contents')
<h1 class="mb-0">Edit Product</h1>
<hr />
<form id="update-form" action="{{ route('products.update', $product->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" placeholder="Title" value="{{ old('title', $product->title) }}">
            @if ($errors->has('title'))
                <span class="text-danger">{{ $errors->first('title') }}</span>
            @endif
        </div>
        <div class="col">
            <label class="form-label">Price <span class="text-danger">*</span></label>
            <input type="text" name="price" class="form-control" placeholder="Price" value="{{ old('price', $product->price) }}">
            @if ($errors->has('price'))
                <span class="text-danger">{{ $errors->first('price') }}</span>
            @endif
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <label class="form-label">Product Code <span class="text-danger">*</span></label>
            <input type="text" name="product_code" class="form-control" placeholder="Product Code" value="{{ old('product_code', $product->product_code) }}">
            @if ($errors->has('product_code'))
                <span class="text-danger">{{ $errors->first('product_code') }}</span>
            @endif
        </div>
        <div class="col">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" placeholder="Description">{{ old('description', $product->description) }}</textarea>
            @if ($errors->has('description'))
                <span class="text-danger">{{ $errors->first('description') }}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col text-center">
            <button type="button" id="update-button" class="btn btn-warning">Update</button>
            <a href="/products" class="btn btn-secondary mx-2">Back</a>
        </div>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('update-button').addEventListener('click', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to save the changes?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('update-form').submit();
            }
        });
    });
</script>
@endsection
