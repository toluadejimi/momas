@extends('layouts.main')
@section('content')

    @if(auth::user()->role == 0)
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">


                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Credit Token</h4>
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
                                            <h5 class="card-title text-black mb-0">Generate Credit Token</h5>
                                        </div>

                                        <div class="col-xl-8 col-sm-12">
                                            <form action="validate-meter" method="POST"
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
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-xl-6 my-2 col-sm-12">
                                                                <label class="my-2">Tariff Amount</label>
                                                                <select class="form-control" required name="tariff_id"
                                                                        id="tariff_id" disabled>
                                                                    <option value="">--Select Tariff--</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-6 my-2 col-sm-12">
                                                            <label class="my-2">Enter Meter No</label>
                                                            <input type="number" class="form-control mb-3"
                                                                   name="meterNo" id="meterNo" required disabled>
                                                        </div>


                                                        <script
                                                            src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                                                        <script>
                                                            $(document).ready(function () {
                                                                $('#estate_id').on('change', function () {
                                                                    let estateId = $(this).val();
                                                                    let tariffSelect = $('#tariff_id');
                                                                    let meterNoField = $('#meterNo');

                                                                    tariffSelect.attr('disabled', true).html('<option value="">--Select Tariff--</option>');
                                                                    meterNoField.attr('disabled', true);

                                                                    if (estateId) {
                                                                        // Fetch the tariffs based on the selected estate
                                                                        $.ajax({
                                                                            url: '/get-tariffs/' + estateId, // Replace with your route
                                                                            method: 'GET',
                                                                            success: function (response) {
                                                                                // Populate the tariffs dropdown
                                                                                response.forEach(function (tariff) {
                                                                                    tariffSelect.append(new Option(tariff.amount, tariff.tariff_id));
                                                                                });
                                                                                tariffSelect.attr('disabled', false);
                                                                            },
                                                                            error: function () {
                                                                                alert('Failed to load tariffs. Please try again.');
                                                                            }
                                                                        });
                                                                    }
                                                                });

                                                                $('#tariff_id').on('change', function () {
                                                                    let tariffId = $(this).val();
                                                                    let meterNoField = $('#meterNo');

                                                                    if (tariffId) {
                                                                        meterNoField.attr('disabled', false);
                                                                    } else {
                                                                        meterNoField.attr('disabled', true);
                                                                    }
                                                                });
                                                            });
                                                        </script>


                                                        <div class="col-xl-6 my-2 col-sm-12">
                                                            <label class="my-2">Amount</label>
                                                            <input type="number" class="form-control mb-3" name="amount"
                                                                   required>
                                                        </div>

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
                                                <th scope="col" class="cursor-pointer">Meter Number</th>
                                                <th scope="col" class="cursor-pointer">Estate</th>
                                                <th scope="col" class="cursor-pointer">Amount</th>
                                                <th scope="col" class="cursor-pointer">Tariff Index</th>
                                                <th scope="col" class="cursor-pointer desc">Unit</th>
                                                <th scope="col" class="cursor-pointer desc">Status</th>
                                                <th scope="col" class="cursor-pointer desc">Date/Time</th>
                                                <th scope="col" class="cursor-pointer desc">Action</th>


                                            </tr>
                                            </thead>
                                            <tbody>


                                            @foreach($credit_tokens as $data)

                                                <tr>
                                                    <td>
                                                        <a href="view-user?id={{$data->id}}">{{$data->user->last_name ?? "name"}} {{$data->user->first_name ?? "name"}}</a>
                                                    </td>
                                                    <td>{{$data->meterNo}}</a> </td>
                                                    <td>{{$data->estate->title ?? "name"}}</td>
                                                    <td>{{number_format($data->amount, 2)}}</td>
                                                    <td>{{$data->tariff_id}}</td>
                                                    <td>{{$data->unitkwh}}kw/N</td>
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
                                                            <a href="recepit?trx_id={{$data->order_id}}"
                                                               onclick="return confirmreprint();"
                                                               class="btn btn-primary">Reprint</a>
                                                            <script>

                                                                function confirmreprint() {
                                                                    return confirm('Are you sure you want to reprint');
                                                                }
                                                            </script>

                                                        @elseif($data->status == 0)

                                                            <a href="retry-generate-tamper-token?trx_id={{$data->order_id}}"
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

    @elseif(auth::user()->role == 1)
    @elseif(auth::user()->role == 2)
    @elseif(auth::user()->role == 3)

        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">


                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Credit Token</h4>
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
                                            <h5 class="card-title text-black mb-0">Generate Credit Token</h5>
                                        </div>

                                        <div class="col-xl-8 col-sm-12">
                                            <form action="validate-meter" method="POST"
                                                  enctype="multipart/form-data">
                                                @csrf

                                                <div class="modal-body">

                                                    @if($preview == null)
                                                        <div class="col-xl-6 col-sm-12">
                                                            <form action="validate-meter" method="POST"
                                                                  enctype="multipart/form-data">
                                                                @csrf

                                                                <div class="modal-body">

                                                                    @if($preview == null)


                                                                        <div class="row">
                                                                            <div class="col-xl-6 my-2 col-sm-12">
                                                                                <label class="my-2">Estate</label>
                                                                                <input  class="form-control" value="{{$title}}" disabled required name="estate_id">
                                                                                <input  class="form-control" value="{{$estate_id}}" hidden required name="estate_id">

                                                                            </div>
                                                                        </div>


                                                                        <div class="row">
                                                                            <div class="col-xl-6 my-2 col-sm-12">
                                                                                <label class="my-2">Tariff Amount</label>
                                                                                <select class="form-control" required name="tariff_id">
                                                                                    <option value="">--Select Tariff--
                                                                                    </option>
                                                                                    @foreach($tariff as $data)
                                                                                        <option value="{{$data->tariff_id}}">{{$data->amount}}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-xl-6 my-2 col-sm-12">
                                                                            <label class="my-2">Enter Meter No</label>
                                                                            <input type="number"
                                                                                   class="form-control mb-3"
                                                                                   name="meterNo" id="meterNo" required>
                                                                        </div>



                                                                        <div class="col-xl-6 my-2 col-sm-12">
                                                                            <label class="my-2">Amount</label>
                                                                            <input type="number"
                                                                                   class="form-control mb-3"
                                                                                   name="amount" required>
                                                                        </div>



                                                                    @else
                                                                        <div class="col-xl-6 my-2 col-sm-12">
                                                                            <label class="my-2">Enter Meter No</label>
                                                                            <input type="number" disabled
                                                                                   class="form-control mb-3"
                                                                                   value="{{$meter->meterNo}}"
                                                                                   name="meterNo" required>
                                                                        </div>


                                                                        <div class="col-xl-6 my-2 col-sm-12">
                                                                            <label class="my-2">Amount</label>
                                                                            <input type="number" disabled
                                                                                   value="{{$amount}}"
                                                                                   class="form-control mb-3"
                                                                                   name="amount" required>
                                                                        </div>

                                                                    @endif




                                                                    @if($preview == null)

                                                                        <div class="col-xl-6 my-2 col-sm-12">
                                                                            <button type="submit"
                                                                                    class="btn btn-primary">Continue
                                                                            </button>
                                                                        </div>

                                                                    @else



                                                                    @endif


                                                                </div>


                                                            </form>
                                                        </div>
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
                                                <th scope="col" class="cursor-pointer">Meter Number</th>
                                                <th scope="col" class="cursor-pointer">Estate</th>
                                                <th scope="col" class="cursor-pointer">Amount</th>
                                                <th scope="col" class="cursor-pointer">Tariff Index</th>
                                                <th scope="col" class="cursor-pointer desc">Unit</th>
                                                <th scope="col" class="cursor-pointer desc">Status</th>
                                                <th scope="col" class="cursor-pointer desc">Date/Time</th>
                                                <th scope="col" class="cursor-pointer desc">Action</th>


                                            </tr>
                                            </thead>
                                            <tbody>


                                            @foreach($credit_tokens as $data)

                                                <tr>
                                                    <td>
                                                        <a href="view-user?id={{$data->id}}">{{$data->user->last_name ?? "name"}} {{$data->user->first_name ?? "name"}}</a>
                                                    </td>
                                                    <td>{{$data->meterNo}}</a> </td>
                                                    <td>{{$data->estate->title ?? "name"}}</td>
                                                    <td>{{number_format($data->amount, 2)}}</td>
                                                    <td>{{$data->tariff_id}}</td>
                                                    <td>{{$data->unitkwh}}kw/H</td>
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
                                                            <a href="recepit?trx_id={{$data->order_id}}"
                                                               onclick="return confirmreprint();"
                                                               class="btn btn-primary">Reprint</a>
                                                            <script>

                                                                function confirmreprint() {
                                                                    return confirm('Are you sure you want to reprint');
                                                                }
                                                            </script>

                                                        @elseif($data->status == 0)

                                                            <a href="retry-generate-token?trx_id={{$data->order_id}}"
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

    @elseif(auth::user()->role == 4)
    @elseif(auth::user()->role == 5)
    @else
    @endif

@endsection
