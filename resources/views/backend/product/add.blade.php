@extends('layouts.admin')

@section('content')
<div class="row">
    @can('add_product')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Add New Product</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('store.product') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Select Category</label>
                                <select name="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)                                        
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Select Sub Category</label>
                                <select name="subcategory_id" class="form-control">
                                    <option value="">Select Sub Category</option>
                                    @foreach ($subcategories as $subcategory)                                        
                                        <option value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Select Tag</label>
                                <select id="select-gear" name="tag_id[]" class="demo-default" multiple placeholder="Select gear...">
                                    <option value="">Select Tag...</option>
                                    <optgroup label="Climbing">
                                        @foreach ($tags as $tag)                                            
                                            <option value="{{ $tag->id }}">{{ $tag->tag_name }}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="product_name" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Product Discount</label>
                                <input type="text" name="discount" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Short Description</label>
                                <input type="text" name="short_desp" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Long Description</label>
                                <textarea id="summernote" name="long_desp" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Preview</label>
                                <input type="file" name="preview" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Gallery</label>
                                <input type="file" name="gallery[]" class="form-control" multiple>
                            </div>
                        </div>
                        <div class="m-auto col-lg-6">
                            <div class="mt-5 mb-3">
                                <button class="btn btn-primary form-control">Add Product</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else
    <div>
        <h3>You dont have permission to see this page</h3>
    </div>
    @endcan
</div>
@endsection

@section('footer_script')
<script>
    $('#select-gear').selectize({ sortField: 'text' })

    $('#summernote').summernote();
</script>
@endsection