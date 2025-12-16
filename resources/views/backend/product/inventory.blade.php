@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4>Inventory for:</h4>
                <h3 class="text-info">{{ $product_info->product_name }}</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Discount Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($inventories as $index=>$inventory)                        
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $inventory->rel_to_color->color_name }}</td>
                        <td>{{ $inventory->rel_to_size->size_name }}</td>
                        <td>{{ $inventory->price }}</td>
                        <td>{{ $inventory->discount_price }}</td>
                        <td>{{ $inventory->quantity }}</td>
                        <td>
                            <a href="" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add Inventory</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('inventory.store', $product_info->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" disabled class="form-control" value="{{ $product_info->product_name }}">
                    </div>
                    <div class="mb-3">
                        <label for="">Select Color</label>
                        <select name="color_id" class="form-control">
                            <option value="">Select Color</option>
                            @foreach ($colors as $color)                            
                                <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">Select Size</label>
                        <select name="size_id" class="form-control">
                            <option value="">Select Size</option>
                            @foreach ($sizes as $size)                            
                                <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="text" class="form-control" name="price">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="text" class="form-control" name="quantity">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Inventory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection