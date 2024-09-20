@extends('layouts.main')
@section('content')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Add New Meter</h4>
                </div>
            </div>


            <div class="row">

                <div class="card">

                    <div class="card-body">

                        <form action="add-new-meter" method="post">
                            @csrf

                            <div class="row">

                                <h6 class="d-flex justify-content-start my-4">Meter Information</h6>

                                <div class="col-4">
                                    <label class="my-2">Customer</label>
                                    <select type="text" name="user_id" class="form-control" required>
                                        <option value=" ">Select</option>
                                        @foreach($users as $data)
                                            <option value="{{$data->id}}">{{$data->first_name}} {{$data->last_name}}</option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="col-4">
                                    <label class="my-2">Meter Number</label>
                                    <input type="number" name="meterNo" class="form-control" required>
                                </div>

                                <div class="col-2">
                                    <label class="my-2">Pay Type</label>
                                    <select type="text" name="payType" class="form-control" required>
                                        <option value=" ">Select</option>
                                        <option value="prepaid">Prepaid</option>
                                        <option value="postpaid">Postpaid</option>
                                    </select>
                                </div>

                                <div class="col-2">
                                    <label class="my-2">Type</label>
                                    <select type="text" name="meterType" class="form-control" required>
                                        <option value=" ">Select</option>
                                        <option value="pro">PRO</option>
                                        <option value="normal">NORMAL</option>
                                    </select>

                                </div>
                            </div>


                            <hr class="my-4">

                            <button type="submit" class="col-2 d-flex btn btn-primary">
                                Assign Meter
                            </button>






                        </form>


                    </div>


                </div>


            </div>


        </div>


    </div> <!-- container-fluid -->

@endsection
