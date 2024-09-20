@extends('layouts.main')
@section('content')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

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


            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">{{$user->first_name }} {{$user->last_name }}</h4>
                </div>
            </div>


            <div class="row">

                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <form action="update-user" method="post">
                                @csrf

                                <div class="row">

                                    <h6 class="d-flex justify-content-start my-4">User Information</h6>

                                    <div class="col-3">
                                        <label class="my-2">First Name</label>
                                        <input type="text" value="{{$user->first_name}}" name="first_name"
                                               class="form-control" required>
                                    </div>

                                    <div class="col-3">
                                        <label class="my-2">Last Name</label>
                                        <input type="text" value="{{$user->last_name}}" name="last_name"
                                               class="form-control" required>
                                    </div>

                                    <div class="col-3">
                                        <label class="my-2">Email</label>
                                        <input type="email" disabled value="{{$user->email}}" name="email" class="form-control"
                                               required>
                                    </div>

                                    <div class="col-3">
                                        <label class="my-2">Phone</label>
                                        <input type="number" value="{{$user->phone}}" name="phone" class="form-control"
                                               required>
                                    </div>

                                    <div class="col-3">
                                        <label class="my-2">Address</label>
                                        <input type="text" value="{{$user->address}}" name="addreess"
                                               class="form-control" required>
                                    </div>

                                    <div class="col-3">
                                        <label class="my-2">City</label>
                                        <input type="text" value="{{$user->city}}" name="city" class="form-control"
                                               required>
                                    </div>

                                    <div class="col-3">
                                        <label class="my-2">State</label>
                                        <select type="text" name="state" class="form-control" required>
                                            <option value="{{$user->state}}">{{$user->state}}</option>
                                            <option value="Lagos">Lagos</option>
                                            <option value="oyo">Oyo</option>
                                            <option value="Abia">Abia</option>
                                            <option value="Adamawa">Adamawa</option>
                                        </select>

                                    </div>

                                    <div class="col-3">
                                        <label class="my-2">LGA</label>
                                        <input type="text" value="{{$user->lga}}" name="lga" class="form-control"
                                               required>
                                    </div>


                                </div>

                                <button type="submit" class="col-3 d-flex btn btn-primary my-3">
                                    Update User Information
                                </button>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="card">

                    <div class="card-body">
                        <div class="row">
                            <form action="update-meter-info" method="post">
                                @csrf
                                <div class="row">

                                    <h6 class="d-flex justify-content-start my-2">Meter Information</h6>

                                    <div class="col-3">
                                        <label class="my-2">Meter No</label>
                                        <input type="text" value="{{$user->meterNo}}" name="meterNo"
                                               class="form-control" required>
                                    </div>

                                    <div class="col-3">
                                        <label class="my-2">Meter Type</label>
                                        <select type="text" name="meterType" class="form-control" required>
                                            <option
                                                value="{{$user->meterType}}">{{strtoupper($user->meterType)}}</option>
                                            <option value="prepaid">Prepaid</option>
                                            <option value="postpaid">Postpaid</option>
                                        </select>

                                    </div>


                                </div>

                                <button type="submit" class="col-3 d-flex btn btn-primary my-3">
                                    Update meter information
                                </button>

                            </form>
                        </div>
                    </div>
                </div>





                <div class="card">

                    <div class="card-body">

                        <div class="row">

                            <h6 class="d-flex justify-content-start my-2">Vending Information</h6>
                            <div class="card-body">
                                <table id="datatable-buttons"
                                       class="table table-striped table-bordered dt-responsive nowrap">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="cursor-pointer">ID</th>
                                        <th scope="col" class="cursor-pointer">Estate</th>
                                        <th scope="col" class="cursor-pointer">MeterNo</th>
                                        <th scope="col" class="cursor-pointer">Token</th>
                                        <th scope="col" class="cursor-pointer">Amount</th>
                                        <th scope="col" class="cursor-pointer">Unit</th>
                                        <th scope="col" class="cursor-pointer">VAT</th>
                                        <th scope="col" class="cursor-pointer">Status</th>
                                        <th scope="col" class="cursor-pointer">Action</th>
                                        <th scope="col" class="cursor-pointer">Date/Time</th>


                                    </tr>
                                    </thead>
                                    <tbody>


                                    @foreach($vending as $data)

                                        <tr>
                                            <td>{{$data->order_id}} </td>
                                            <td>{{$data->estate_name}}</td>
                                            <td>{{$data->meterNo}}</td>
                                            <td>{{$data->token}}</td>
                                            <td>{{number_format($data->amount, 2)}}</td>
                                            <td>{{number_format($data->unit, 2)}}</td>
                                            <td>{{number_format($data->vat, 2)}}</td>
                                            <td>
                                                @if($data->status == 2)
                                                    <span class="badge text-bg-primary">Completed</span>
                                                @elseif($data->status == 3)
                                                    <span class="badge text-bg-dark">Error</span>
                                                @elseif($data->status == 0)
                                                    <span class="badge text-bg-warning">Pending</span>
                                                @endif

                                            </td>
                                            <td><a href="send-token-email?email={{$user->email}}&amount={{$data->amount}}&token={{$data->token}}&unit={{$data->unit}}" onclick="return confirmDelete();" class="btn btn-primary">Send</a> </td>
                                            <script>
                                                function confirmDelete() {
                                                    return confirm('Are you sure you want to send email to  {{$user->email}}?');
                                                }
                                            </script>

                                            <td>{{$data->created_at}}</td>

                                        </tr>

                                    @endforeach


                                    </tbody><!-- end tbody -->

                                    <tfoot>

                                    {{ $vending->links() }}


                                    </tfoot>
                                </table><!-- end table -->
                            </div>
                        </div>


                    </div>

                </div>


                <div class="card">

                    <div class="card-body">

                        <div class="row">

                            <h6 class="d-flex justify-content-start my-2">Utility Information</h6>
                            <div class="card-body">
                                <table id="datatable-buttons"
                                       class="table table-striped table-bordered dt-responsive nowrap">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="cursor-pointer">ID</th>
                                        <th scope="col" class="cursor-pointer">Estate</th>
                                        <th scope="col" class="cursor-pointer">Duration</th>
                                        <th scope="col" class="cursor-pointer">Amount</th>
                                        <th scope="col" class="cursor-pointer">Status</th>
                                        <th scope="col" class="cursor-pointer">Date/Time</th>


                                    </tr>
                                    </thead>
                                    <tbody>


                                    @foreach($upayment as $data)

                                        <tr>
                                            <td> {{$data->id}} </td>
                                            <td>{{$estate_name}}</td>
                                            <td>{{strtoupper($data->duration)}}</td>
                                            <td>{{number_format($data->amount, 2)}}</td>
                                            <td>
                                                @if($data->status == 2)
                                                    <span class="badge text-bg-primary">Active</span>
                                                @elseif($data->status == 3)
                                                    <span class="badge text-bg-dark">Banned</span>
                                                @elseif($data->status == 0)
                                                    <span class="badge text-bg-warning">Pending</span>
                                                @endif

                                            </td>
                                            <td>{{$data->created_at}}</td>

                                        </tr>

                                    @endforeach


                                    </tbody><!-- end tbody -->

                                    <tfoot>

                                    {{ $upayment->links() }}


                                    </tfoot>
                                </table><!-- end table -->
                            </div>
                        </div>


                    </div>

                </div>


            </div>
        </div>
    </div> <!-- container-fluid -->

@endsection
