@extends('layouts.adminBase')


@section('content')


        <!-- Sidebar Start -->
@include('admin.includes.sidebar')
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            @include('admin.includes.navbar')
            <!-- Navbar End -->

            <div class="container-fluid pt-4 px-4">
                <div class="bg-light text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Recent Orders</h6>
                        <div class="col-dm3">
                            {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#NewProduct">
                                Add New Product
                              </button> --}}
                        </div>
                        {{-- <a href="">Show All</a> --}}
                    </div>
                    <div class="table-responsive">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col">Date</th>
                                    <th scope="col">Names</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    {{-- @foreach($order->orderItems as $item) --}}
                                        <tr>
                                            <td>{{ $order->created_at }}</td>
                                            <td>{{ $order->fName }} {{ $order->lName }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>{{ $order->phone }}</td>
                                            <td>{{ $order->orderItems->count() }}</td>
                                            <td>{{ $order->orderItems->sum('price') }}</td>
                                            <td>
                                                <div class="bg-light rounded">
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-danger"><i class="fa fa-eye"></i></button>
                                                        <button type="button" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                                        <button type="button" class="btn btn-success"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    {{-- @endforeach --}}
                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>

        </div>
        <!-- Content End -->


 @endsection