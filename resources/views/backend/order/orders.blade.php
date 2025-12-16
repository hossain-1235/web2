@extends('layouts.admin')
@section('content')
<div class="row">
    @can('order')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Orders List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Order ID</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($orders as $index=>$order)                        
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $order->order_id }}</td>
                        <td>&#2547;{{ $order->total }}</td>
                        <td>
                           @if ($order->status == 0)
                                <span class="badge badge-primary">Placed</span>
                           @elseif ($order->status == 1)
                                <span class="badge badge-info">Processing</span>
                           @elseif ($order->status == 2)
                                <span class="badge badge-warning">Shipping</span>
                           @elseif ($order->status == 3)
                                <span class="badge badge-success">Delivered</span>
                           @elseif ($order->status == 4)
                                <span class="badge badge-danger">Cancel</span>
                           @endif
                        </td>
                        <td>
                            @can('order_status')
                            <form action="{{ route('order.status', $order->id) }}" method="POST">
                                @csrf
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Change Status
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <button  name="status" class="dropdown-item {{ $order->status == 0 ? 'bg-primary text-white':'' }}" value="0" type="submit">Placed</button>
                                        <button name="status" class="dropdown-item {{ $order->status == 1 ? 'bg-primary text-white':'' }}" value="1" type="submit">Processing</button>
                                        <button name="status" class="dropdown-item {{ $order->status == 2 ? 'bg-primary text-white':'' }}" value="2" type="submit">Shipping</button>
                                        <button  name="status" class="dropdown-item {{ $order->status == 3 ? 'bg-primary text-white':'' }}" value="3" type="submit">Delivered</button>
                                        <button name="status" class="dropdown-item {{ $order->status == 4 ? 'bg-primary text-white':'' }}" value="4" type="submit">Cancel</button>
                                    </div>
                                    </div>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @else
    <div>
        <h3>you dont have permission to see this page</h3>
    </div>
    @endcan
</div>
@endsection