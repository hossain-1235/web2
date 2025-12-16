@extends('layouts.admin')

@section('content')
<div class="row">
    @can('show_product')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Product List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Discount %</th>
                        <th>Preview</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($products as $index=>$product)                        
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>&#2547;{{ $product->price }}</td>
                        <td>{{ $product->discount }}%</td>
                        <td>
                            <img src="{{ asset('uploads/product/preview') }}/{{ $product->preview }}" alt="">
                        </td>
                        <td>
                            <a href="{{ route('inventory', $product->id) }}" class="btn btn-info">Inventory</a>
                            <a href="" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @else
    <div>
        <h3>tomar permission nai ja vaag!!</h3>
    </div>
    @endcan
</div>
@endsection