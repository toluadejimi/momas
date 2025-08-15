@php use App\Models\Estate;use App\Models\User; @endphp
@extends('layouts.main')
@section('content')

    @if(Auth::user()->role == 0)

        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">


                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Clear Credit Token</h4>
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
                    <div class="col-xl-12">
                        <div class="card overflow-hidden">

                            <div class="card">

                                <div class="card-header">
                                    <h5 class="card-title mb-0">Vending Information</h5>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="row">


                                        <div class="d-flex justify-content-between my-4">
                                            <h5 class="card-title text-black mb-0">Generate Clear Credit Token</h5>
                                        </div>

                                        <div class="col-xl-8 col-sm-12">
                                            <form action="validate-clear-credit-meter" method="POST"
                                                  enctype="multipart/form-data">
                                                @csrf

                                                <div class="modal-body">

                                                    @if($preview == null)
                                                        <div class="row">
                                                            <div class="col-xl-6 my-2 col-sm-12">
                                                                <label class="my-2">Estate</label>
                                                                <select class="form-control" required name="estate_id"
                                                                        id="estate_id">
                                                                    <option value="">--Select Estate--</option>
                                                                    @foreach($estate as $data)
                                                                        <option
                                                                            value="{{$data->id}}">{{$data->title}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>


                                                            <div class="col-xl-6 my-2 col-sm-12">
                                                                <label class="my-2">Enter Meter No</label>
                                                                <input type="number" class="form-control mb-3"
                                                                       name="meterNo" id="meterNo" required>
                                                            </div>


                                                            <div class="col-xl-6 my-2 col-sm-12">
                                                                <label class="my-2">Power Source</label>
                                                                <select class="form-control" required
                                                                        name="tariff_id"
                                                                        id="tariff_id" disabled>
                                                                    <option value="">--Select Tariff--</option>
                                                                </select>
                                                            </div>


                                                            <div class="col-xl-6 my-2 col-sm-12">
                                                                <label class="my-2">Amount</label>
                                                                <input type="number" readonly value="{{$amount}}"
                                                                       class="form-control mb-3" name="amount"
                                                                       required>
                                                            </div>


                                                        </div>



                                                        <script>
                                                            $(document).ready(function () {
                                                                $('#estate_id, #meterNo').on('change input', function () {
                                                                    var estate_id = $('#estate_id').val();
                                                                    var meterNo = $('#meterNo').val();

                                                                    if (estate_id && (meterNo.length === 11 || meterNo.length === 13)) {
                                                                        $.ajax({
                                                                            url: '/fetch-tariff', // Change this to your endpoint
                                                                            method: 'GET',
                                                                            data: {
                                                                                estate_id: estate_id,
                                                                                meterNo: meterNo
                                                                            },
                                                                            success: function (response) {
                                                                                // Check if response is 1, 2, or 3
                                                                                if (response == 1) {
                                                                                    alert("Error: User is not attached to any estate.");
                                                                                    return;
                                                                                }
                                                                                if (response == 2) {
                                                                                    alert("Error: Estate does not have any tariff");
                                                                                    return;
                                                                                }
                                                                                if (response == 3) {
                                                                                    alert("Error: Tariff index not set for customer.");
                                                                                    return;
                                                                                }

                                                                                if (response && response.tariffs) {
                                                                                    console.log(response);
                                                                                    var tariffSelect = $('#tariff_id');
                                                                                    tariffSelect.empty();
                                                                                    tariffSelect.append('<option value="">--Select Tariff--</option>');

                                                                                    response.tariffs.forEach(function (tariff) {
                                                                                        tariffSelect.append('<option value="' + tariff.id + '">' + tariff.type + '</option>');
                                                                                    });

                                                                                    tariffSelect.prop('disabled', false);
                                                                                } else {
                                                                                    $('#tariff_id').prop('disabled', true).empty();
                                                                                }
                                                                            },
                                                                            error: function () {
                                                                                $('#tariff_id').prop('disabled', true).empty();
                                                                                alert("Error fetching tariff data. Please try again.");
                                                                            }
                                                                        });
                                                                    } else {
                                                                        $('#tariff_id').prop('disabled', true).empty();
                                                                    }
                                                                });
                                                            });

                                                        </script>

                                                    @else
                                                        <div class="col-xl-6 my-2 col-sm-12">
                                                            <label class="my-2">Enter Meter No</label>
                                                            <input type="number" disabled class="form-control mb-3"
                                                                   value="{{$meter->meterNo}}" name="meterNo" required>
                                                        </div>




                                                        <div class="col-xl-6 my-2 col-sm-12">
                                                            <label class="my-2">Amount</label>
                                                            <input type="number" disabled value="{{$amount}}"
                                                                   class="form-control mb-3" name="amount" required>
                                                        </div>

                                                    @endif




                                                    @if($preview == null)

                                                        <div class="col-xl-6 my-2 col-sm-12">
                                                            <button type="submit" class="btn btn-primary">Continue
                                                            </button>
                                                        </div>

                                                    @else



                                                    @endif


                                                </div>


                                            </form>
                                        </div>


                                    </div>
                                    <hr>
                                    <div class="card-body">
                                        <table id="datatable-buttons"
                                               class="table table-striped table-bordered dt-responsive nowrap">
                                            <thead>
                                            <tr>
                                                <th scope="col" class="cursor-pointer">Customer Name</th>
                                                <th scope="col" class="cursor-pointer">Estate</th>
                                                <th scope="col" class="cursor-pointer">Meter Number</th>
                                                <th scope="col" class="cursor-pointer">Amount</th>
                                                <th scope="col" class="cursor-pointer desc">Status</th>
                                                <th scope="col" class="cursor-pointer desc">Date/Time</th>
                                                <th scope="col" class="cursor-pointer desc">Action</th>


                                            </tr>
                                            </thead>
                                            <tbody>


                                            @foreach($credit_tokens as $data)

                                                <tr>
                                                    <td>
                                                        @php
                                                            $user = User::where('id', $data->user_id)->first();
                                                        @endphp
                                                        <a href="view-user?id={{$data->user_id}}">{{$user->last_name ?? "name"}} {{$user->first_name ?? "name"}}</a>

                                                    </td>

                                                    <td>

                                                        @php
                                                            $estate = Estate::where('id', $data->estate_id)->first();
                                                        @endphp
                                                        {{$estate->title ?? "name"}}
                                                        {{$data->estate_id ?? "name"}}

                                                    </td>

                                                    <td>{{$data->meterNo}}</a> </td>
                                                    <td>{{number_format($data->amount, 2)}}</td>
                                                    <td>
                                                        @if($data->status == 2)
                                                            <span class="badge text-bg-primary">Successful</span>
                                                        @elseif($data->status == 0)
                                                            <span class="badge text-bg-warning">Pending</span>
                                                        @elseif($data->status == 3)
                                                            <span class="badge text-bg-danger">Declined</span>
                                                        @endif

                                                    </td>
                                                    <td>{{$data->created_at}}</td>


                                                    <td>
                                                        @if($data->status == 2)
                                                            <a href="recepit?trx_id={{$data->trx_id}}"
                                                               onclick="return confirmreprint();"
                                                               class="btn btn-primary">Reprint</a>
                                                            <script>

                                                                function confirmreprint() {
                                                                    return confirm('Are you sure you want to reprint');
                                                                }
                                                            </script>

                                                        @elseif($data->status == 0)

                                                            <a href="retry-generate-token?trx_id={{$data->trx_id}}"
                                                               onclick="return confirmgenertetoken();"
                                                               class="btn btn-secondary">Generate Token</a>
                                                            <script>

                                                                function confirmgenertetoken() {
                                                                    return confirm('Are you sure you want to generate token');
                                                                }
                                                            </script>

                                                        @elseif($data->status == 3)
                                                            <span class="badge text-bg-danger">Declined</span>
                                                        @endif

                                                    </td>


                                                </tr>

                                            @endforeach


                                            </tbody><!-- end tbody -->

                                            <tfoot>


                                            </tfoot>
                                        </table><!-- end table -->
                                    </div>
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
                        <h4 class="fs-18 fw-semibold m-0">Clear Credit Token</h4>
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
                    <div class="col-xl-12">
                        <div class="card overflow-hidden">

                            <div class="card">

                                <div class="card-header">
                                    <h5 class="card-title mb-0">Vending Information</h5>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="row">


                                        <div class="d-flex justify-content-between my-4">
                                            <h5 class="card-title text-black mb-0">Generate Clear Credit Token</h5>
                                        </div>

                                        <div class="col-xl-8 col-sm-12">
                                            <form action="validate-clear-credit-meter" method="POST"
                                                  enctype="multipart/form-data">
                                                @csrf

                                                <div class="modal-body">

                                                    @if($preview == null)
                                                        <div class="row">
                                                            <div class="col-xl-6 my-2 col-sm-12">
                                                                <div class="col-xl-6 my-2 col-sm-12">
                                                                    <label class="my-2">Estate</label>
                                                                    <input class="form-control" value="{{$title}}" required name="title" id="estate_id">
                                                                    <input class="form-control" value="{{$estate_id}}" hidden required name="estate_id" id="estate_id">
                                                                </div>
                                                            </div>


                                                            <div class="col-xl-6 my-2 col-sm-12">
                                                                <label class="my-2">Enter Meter No</label>
                                                                <input type="number" class="form-control mb-3"
                                                                       name="meterNo" id="meterNo" required>
                                                            </div>


                                                            <div class="col-xl-6 my-2 col-sm-12">
                                                                <label class="my-2">Power Source</label>
                                                                <select class="form-control" required
                                                                        name="tariff_id"
                                                                        id="tariff_id" disabled>
                                                                    <option value="">--Select Tariff--</option>
                                                                </select>
                                                            </div>


                                                            <div class="col-xl-6 my-2 col-sm-12">
                                                                <label class="my-2">Amount</label>
                                                                @php $cl_amount = \App\Models\Setting::where('id', 1)->first()->clear_credit_fee @endphp
                                                                <input type="number" readonly value="{{$cl_amount}}"
                                                                       class="form-control mb-3" name="amount"
                                                                       required>
                                                            </div>


                                                        </div>



                                                        <script>
                                                            $(document).ready(function () {
                                                                $('#estate_id, #meterNo').on('change input', function () {
                                                                    var estate_id = $('#estate_id').val();
                                                                    var meterNo = $('#meterNo').val();

                                                                    if (estate_id && (meterNo.length === 11 || meterNo.length === 13)) {
                                                                        $.ajax({
                                                                            url: '/fetch-tariff', // Change this to your endpoint
                                                                            method: 'GET',
                                                                            data: {
                                                                                estate_id: estate_id,
                                                                                meterNo: meterNo
                                                                            },
                                                                            success: function (response) {
                                                                                // Check if response is 1, 2, or 3
                                                                                if (response == 1) {
                                                                                    alert("Error: User is not attached to any estate.");
                                                                                    return;
                                                                                }
                                                                                if (response == 2) {
                                                                                    alert("Error: Estate does not have any tariff");
                                                                                    return;
                                                                                }
                                                                                if (response == 3) {
                                                                                    alert("Error: Tariff index not set for customer.");
                                                                                    return;
                                                                                }

                                                                                if (response && response.tariffs) {
                                                                                    console.log(response);
                                                                                    var tariffSelect = $('#tariff_id');
                                                                                    tariffSelect.empty();
                                                                                    tariffSelect.append('<option value="">--Select Tariff--</option>');

                                                                                    response.tariffs.forEach(function (tariff) {
                                                                                        tariffSelect.append('<option value="' + tariff.id + '">' + tariff.type + '</option>');
                                                                                    });

                                                                                    tariffSelect.prop('disabled', false);
                                                                                } else {
                                                                                    $('#tariff_id').prop('disabled', true).empty();
                                                                                }
                                                                            },
                                                                            error: function () {
                                                                                $('#tariff_id').prop('disabled', true).empty();
                                                                                alert("Error fetching tariff data. Please try again.");
                                                                            }
                                                                        });
                                                                    } else {
                                                                        $('#tariff_id').prop('disabled', true).empty();
                                                                    }
                                                                });
                                                            });

                                                        </script>

                                                    @else
                                                        <div class="col-xl-6 my-2 col-sm-12">
                                                            <label class="my-2">Enter Meter No</label>
                                                            <input type="number" disabled class="form-control mb-3"
                                                                   value="{{$meter->meterNo}}" name="meterNo" required>
                                                        </div>




                                                        <div class="col-xl-6 my-2 col-sm-12">
                                                            <label class="my-2">Amount</label>
                                                            <input type="number" disabled value="{{$amount}}"
                                                                   class="form-control mb-3" name="amount" required>
                                                        </div>

                                                    @endif




                                                    @if($preview == null)

                                                        <div class="col-xl-6 my-2 col-sm-12">
                                                            <button type="submit" class="btn btn-primary">Continue
                                                            </button>
                                                        </div>

                                                    @else



                                                    @endif


                                                </div>


                                            </form>
                                        </div>


                                    </div>
                                    <hr>
                                    <div class="card-body">
                                        <table id="datatable-buttons"
                                               class="table table-striped table-bordered dt-responsive nowrap">
                                            <thead>
                                            <tr>
                                                <th scope="col" class="cursor-pointer">Customer Name</th>
                                                <th scope="col" class="cursor-pointer">Estate</th>
                                                <th scope="col" class="cursor-pointer">Meter Number</th>
                                                <th scope="col" class="cursor-pointer">Amount</th>
                                                <th scope="col" class="cursor-pointer desc">Status</th>
                                                <th scope="col" class="cursor-pointer desc">Date/Time</th>
                                                <th scope="col" class="cursor-pointer desc">Action</th>


                                            </tr>
                                            </thead>
                                            <tbody>


                                            @foreach($credit_tokens as $data)

                                                <tr>
                                                    <td>
                                                        @php
                                                            $user = User::where('id', $data->user_id)->first();
                                                        @endphp
                                                        <a href="view-user?id={{$data->user_id}}">{{$user->last_name ?? "name"}} {{$user->first_name ?? "name"}}</a>

                                                    </td>

                                                    <td>

                                                        @php
                                                            $estate = Estate::where('id', $data->estate_id)->first();
                                                        @endphp
                                                        {{$estate->title ?? "name"}}
                                                        {{$data->estate_id ?? "name"}}

                                                    </td>

                                                    <td>{{$data->meterNo}}</a> </td>
                                                    <td>{{number_format($data->amount, 2)}}</td>
                                                    <td>
                                                        @if($data->status == 2)
                                                            <span class="badge text-bg-primary">Successful</span>
                                                        @elseif($data->status == 0)
                                                            <span class="badge text-bg-warning">Pending</span>
                                                        @elseif($data->status == 3)
                                                            <span class="badge text-bg-danger">Declined</span>
                                                        @endif

                                                    </td>
                                                    <td>{{$data->created_at}}</td>


                                                    <td>
                                                        @if($data->status == 2)
                                                            <a href="recepit?trx_id={{$data->trx_id}}"
                                                               onclick="return confirmreprint();"
                                                               class="btn btn-primary">Reprint</a>
                                                            <script>

                                                                function confirmreprint() {
                                                                    return confirm('Are you sure you want to reprint');
                                                                }
                                                            </script>

                                                        @elseif($data->status == 0)

                                                            <a href="retry-generate-token?trx_id={{$data->trx_id}}"
                                                               onclick="return confirmgenertetoken();"
                                                               class="btn btn-secondary">Generate Token</a>
                                                            <script>

                                                                function confirmgenertetoken() {
                                                                    return confirm('Are you sure you want to generate token');
                                                                }
                                                            </script>

                                                        @elseif($data->status == 3)
                                                            <span class="badge text-bg-danger">Declined</span>
                                                        @endif

                                                    </td>


                                                </tr>

                                            @endforeach


                                            </tbody><!-- end tbody -->

                                            <tfoot>


                                            </tfoot>
                                        </table><!-- end table -->
                                    </div>
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
