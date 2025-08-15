@extends('layouts.main')
@section('content')



    @if(Auth::user()->role == 0)

        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">


                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Payment Report | {{Auth::user()->estate_name}}</h4>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif





                <div class="row">





                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="widget-first">

                                    <div class="d-flex align-items-center mb-2">
                                        <div
                                            class="bg-secondary-subtle rounded-circle p-2 me-2 border border-dashed border-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                 viewBox="0 0 640 512">
                                                <path fill="#963b68"
                                                      d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64m448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64m32 32h-64c-17.6 0-33.5 7.1-45.1 18.6c40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64m-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32S208 82.1 208 144s50.1 112 112 112m76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2m-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4"/>
                                            </svg>
                                        </div>

                                        <p class="mb-0 text-dark fs-15">Total Paid</p>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <h3 class="mb-0 fs-24 text-black me-2">{{number_format($total_completed)}}</h3>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="widget-first">

                                    <div class="d-flex align-items-center mb-2">
                                        <div
                                            class="bg-secondary-subtle rounded-circle p-2 me-2 border border-dashed border-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                 viewBox="0 0 640 512">
                                                <path fill="#963b68"
                                                      d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64m448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64m32 32h-64c-17.6 0-33.5 7.1-45.1 18.6c40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64m-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32S208 82.1 208 144s50.1 112 112 112m76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2m-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4"/>
                                            </svg>
                                        </div>

                                        <p class="mb-0 text-dark fs-15">Total Pending</p>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <h3 class="mb-0 fs-24 text-black me-2">{{number_format($total_pending)}}</h3>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>




                <div class="col-md-12 col-xl-12">

                    <div class="card">
                        <div class="card-body">

                            <div class="row">

                                <div class="element-box">

                                    <h6 class="element-header ">Filter</h6>

                                    <form action="search-utility-trx" method="post">
                                        @csrf

                                        <div class="row">
                                            <div class="col-3">
                                                <label>Date From</label>
                                                <input type="date" class="form-control"  name="from">
                                            </div>
                                            <div class="col-3">
                                                <label>Date To</label>
                                                <input type="date" class="form-control"   name="to">
                                            </div>
                                            <div class="col-3">
                                                <label>Payment Type</label>
                                                <select class="form-control" name="type">

                                                    <option value="">Select type</option>
                                                    <option value="admin_fee">Admin Fee</option>
                                                    <option value="utilities">Utility Fees</option>


                                                </select>


                                            </div>


                                            <div class="col-3">
                                                <label>Transaction Status</label>
                                                <select class="form-control" name="status">
                                                    <option value="">Select type</option>
                                                    <option value="0">Pending</option>
                                                    <option value="2">Successful</option>
                                                </select>

                                            </div>

                                        </div>

                                            <div class="row my-2">

                                                <div class="col-3">
                                                    <label>Estate</label>
                                                    <select class="form-control" name="estate_id">
                                                        <option value="">Select Estate</option>
                                                        <option value="all">All Estate</option>
                                                        @foreach($estate as $data)
                                                            <option value="{{$data->id}}">{{$data->title}}</option>
                                                        @endforeach


                                                    </select>

                                                </div>


                                                <div class="col-3">
                                                    <label>Customer</label>
                                                    <select class="form-control" name="user_id">
                                                        <option value="">Select Customer</option>
                                                        <option value="all">All Customer</option>
                                                        @foreach($customer as $data)
                                                            <option value="{{$data->id}}">{{$data->first_name}} {{$data->last_name}}</option>
                                                        @endforeach


                                                    </select>

                                                </div>



                                                <div class="col-3 mt-3 row">
                                                    <div class="col">
                                                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                                                    </div>


                                                </div>





                                        </div>



                                    </form>

                                </div>



                            </div>

                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-xl-12">
                        <div class="card overflow-hidden">

                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title text-black mb-0">All Payments</h5>

                                </div>


                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="cursor-pointer">Trx ID</th>
                                        <th scope="col" class="cursor-pointer">Trx Type</th>
                                        <th scope="col" class="cursor-pointer">Duration</th>
                                        <th scope="col" class="cursor-pointer">Customer</th>
                                        <th scope="col" class="cursor-pointer">Estate</th>
                                        <th scope="col" class="cursor-pointer">Amount</th>
                                        <th scope="col" class="cursor-pointer">Status</th>
                                        <th scope="col" class="cursor-pointer desc">Active Date</th>
                                        <th scope="col" class="cursor-pointer desc">Due Date</th>
                                        <th scope="col" class="cursor-pointer desc">Action</th>



                                    </tr>
                                    </thead>
                                    <tbody>


                                    @foreach($payment as $data)

                                        <tr>
                                            <td><a href="#" class="" data-bs-toggle="modal"
                                                data-bs-target="#staticBackdrop{{$data->id}}">{{$data->id}}</a>


                                                <div class="col-xl-6">
                                                    <div class="card">
                                                        <div class="modal fade" id="staticBackdrop{{$data->id}}"
                                                             data-bs-backdrop="static" data-bs-keyboard="false"
                                                             tabindex="-1" aria-labelledby="staticBackdropLabel"
                                                             aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5"
                                                                            id="staticBackdropLabel">{{$data->id}}</h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>


                                                                    <div class="modal-body">

                                                                    <div class="row">
                                                                        <div class="col-4">

                                                                            <label>Transaction ID</label>
                                                                            <div>{{$data->id}}</div>

                                                                        </div>

                                                                        @if($data->type == "admin_fee")
                                                                        <div class="col-4">
                                                                            <label>Admin Fee</label>
                                                                        </div>
                                                                        @else
                                                                            <div class="col-4">
                                                                                <label>Utility Payment</label>
                                                                            </div>
                                                                        @endif

                                                                        <div class="col-4">
                                                                            <label>Amount</label>
                                                                            <div>NGN {{number_format($data->total_amount, 2)}}</div>
                                                                        </div>

                                                                    </div>


                                                                    </div>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </td>




                                            <td>
                                                @if($data->type == "admin_fee")
                                                    <span class="badge text-bg-primary">Admin Fee</span>
                                                @elseif($data->type == "utilities")
                                                    <span class="badge text-bg-primary">Utilities</span>
                                                @else
                                                @endif
                                            </td>

                                            <td>{{$data->duration }}</td>



                                            <td><a href="view-user?id={{$data->user->first_name ?? "name"}}">{{$data->user->first_name ?? "name"}} {{$data->user->last_name ?? "name"}}</a></td>
                                            <td>{{$data->estate->title ?? "Estate"}}</td>
                                            <td>{{number_format($data->amount, 2)}}</td>
                                            <td>
                                                @if($data->status == 2)
                                                    <span class="badge text-bg-primary">Completed</span>
                                                @elseif($data->status == 0)
                                                    <span class="badge text-bg-warning">Pending</span>
                                                @elseif($data->status == 3)
                                                    <span class="badge text-bg-dark">Failed</span>
                                                @endif
                                            </td>


                                            <td>{{$data->created_at}}</td>

                                            <td>{{$data->next_due_date}}</td>



                                            <td>
                                                @if($data->status == 2)
                                                <a><a <a class="btn btn-danger" href="uncomplete-payment?id={{$data->id}}">Complete</a>
                                                @elseif($data->status == 0)
                                                <a><a class="btn btn-primary" href="complete-payment?id={{$data->id}}">Complete</a>
                                                @endif
                                            </td>


                                        </tr>

                                    @endforeach


                                    </tbody><!-- end tbody -->

                                    <tfoot>

                                    {{ $payment->links() }}


                                    </tfoot>
                                </table><!-- end table -->
                            </div>
                        </div>

                    </div>
                </div>


            </div>


        </div> <!-- container-fluid -->

        </div>

    @elseif(Auth::user()->role == 1)
    @elseif(Auth::user()->role == 2)
    @elseif(Auth::user()->role == 3)
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">


                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Transaction Report | {{Auth::user()->estate_name}}</h4>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif





                <div class="row">





                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="widget-first">

                                    <div class="d-flex align-items-center mb-2">
                                        <div
                                            class="bg-secondary-subtle rounded-circle p-2 me-2 border border-dashed border-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                 viewBox="0 0 640 512">
                                                <path fill="#963b68"
                                                      d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64m448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64m32 32h-64c-17.6 0-33.5 7.1-45.1 18.6c40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64m-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32S208 82.1 208 144s50.1 112 112 112m76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2m-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4"/>
                                            </svg>
                                        </div>

                                        <p class="mb-0 text-dark fs-15">Total Transaction</p>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <h3 class="mb-0 fs-24 text-black me-2">{{number_format($total)}}</h3>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>




                <div class="col-md-12 col-xl-12">

                    <div class="card">
                        <div class="card-body">

                            <div class="row">

                                <div class="element-box">

                                    <h6 class="element-header ">Filter</h6>

                                    <form action="search-trx" method="post">
                                        @csrf

                                        <div class="row">
                                            <div class="col-3">
                                                <label>Date From</label>
                                                <input type="date" class="form-control" required name="from">
                                            </div>
                                            <div class="col-3">
                                                <label>Date To</label>
                                                <input type="date" class="form-control"  required name="to">
                                            </div>
                                            <div class="col-3">
                                                <label>Transaction Type</label>
                                                <select class="form-control" name="transaction_type">

                                                    <option value="">Select type</option>
                                                    <option value="meter">Meter Token</option>
                                                    <option value="airtime">Airtime</option>
                                                    <option value="data">Data</option>
                                                    <option value="cable">Cable</option>


                                                </select>


                                            </div>


                                            <div class="col-3">
                                                <label>Transaction Status</label>
                                                <select class="form-control" name="status">
                                                    <option value="">Select type</option>
                                                    <option value="0">Pending</option>
                                                    <option value="2">Successful</option>
                                                    <option value="3">Failed</option>
                                                    <option value="4">Reversed</option>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="row my-3">


                                            <div class="col-4">
                                                <label>Transaction Refrence</label>
                                                <input type="text" class="form-control" name="rrn"
                                                       placeholder="Enter Transaction Refrence">

                                            </div>

                                            <div class="col-4 mt-4 row">
                                                <div class="col">
                                                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                                                </div>


                                            </div>


                                        </div>


                                    </form>





                                </div>



                            </div>

                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-xl-12">
                        <div class="card overflow-hidden">

                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title text-black mb-0">All Transaction</h5>

                                </div>


                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="cursor-pointer">Trx ID</th>
                                            <th scope="col" class="cursor-pointer">Customer</th>
                                            <th scope="col" class="cursor-pointer">Amount</th>
                                            <th scope="col" class="cursor-pointer">Type</th>
                                            <th scope="col" class="cursor-pointer">Status</th>
                                            <th scope="col" class="cursor-pointer desc">Date</th>


                                        </tr>
                                        </thead>
                                        <tbody>


                                        @foreach($transactions as $data)

                                            <tr>
                                                <td>{{$data->trx_id}}</td>
                                                <td><a href="view-user?id={{$data->user->first_name ?? "Name"}}">{{$data->user->last_name ?? "Name"}}</a></td>
                                                <td>{{number_format($data->amount, 2)}}</td>
                                                <td>{{$data->service}}</td>
                                                <td>
                                                    @if($data->status == 2)
                                                        <span class="badge text-bg-primary">Approved</span>
                                                    @elseif($data->status == 0)
                                                        <span class="badge text-bg-dark">Pending</span>
                                                    @elseif($data->status == 3)
                                                        <span class="badge text-bg-dark">Refunded</span>
                                                    @endif

                                                </td>
                                                <td>{{$data->created_at}}</td>

                                            </tr>

                                        @endforeach


                                        </tbody><!-- end tbody -->

                                        <tfoot>

                                        {{ $transactions->links() }}


                                        </tfoot>
                                    </table><!-- end table -->
                                </div>
                            </div>

                        </div>
                    </div>


                </div>


            </div> <!-- container-fluid -->

        </div>
    @elseif(Auth::user()->role == 4)
    @elseif(Auth::user()->role == 5)
    @else
    @endif


@endsection
