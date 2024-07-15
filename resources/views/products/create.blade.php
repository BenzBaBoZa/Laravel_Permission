@extends('layouts.app')

@section('title', 'Create Product')

@section('contents')
<h1 class="mb-0">Add Product</h1>
<hr>
<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row mb-3">
        <div class="col">
            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" placeholder="Title" value="{{ old('title') }}" required>
            @if ($errors->has('title'))
                <span class="text-danger">{{ $errors->first('title') }}</span>
            @endif
        </div>
        <div class="col">
            <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
            <input type="text" name="price" class="form-control" placeholder="Price" value="{{ old('price') }}" required>
            @if ($errors->has('price'))
                <span class="text-danger">{{ $errors->first('price') }}</span>
            @endif
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <label for="product_code" class="form-label">Product Code <span class="text-danger">*</span></label>
            <input type="text" name="product_code" class="form-control" placeholder="Product Code" value="{{ old('product_code') }}" required>
            @if ($errors->has('product_code'))
                <span class="text-danger">{{ $errors->first('product_code') }}</span>
            @endif
        </div>
        <div class="col">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" placeholder="Description">{{ old('description') }}</textarea>
            @if ($errors->has('description'))
                <span class="text-danger">{{ $errors->first('description') }}</span>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col text-center">
            <button type="submit" class="btn btn-primary mx-2">Submit</button>
            <a href="/products" class="btn btn-secondary mx-2">Back</a>
        </div>
    </div>
</form>
@endsection
