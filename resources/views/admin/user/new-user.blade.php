@extends('layouts.main')
@section('content')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Add New User</h4>
                </div>
            </div>


            <div class="row">

                <div class="card">

                    <div class="card-body">

                        <form action="add-new-user" method="post">
                            @csrf

                            <div class="row">

                                <h6 class="d-flex justify-content-start my-4">User Information</h6>

                                <div class="col-3">
                                    <label class="my-2">First Name</label>
                                    <input type="text" name="first_name" class="form-control" required>
                                </div>

                                <div class="col-3">
                                    <label class="my-2">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" required>
                                </div>

                                <div class="col-3">
                                    <label class="my-2">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>

                                <div class="col-3">
                                    <label class="my-2">Phone</label>
                                    <input type="number" name="phone" class="form-control" required>
                                </div>


                                <div class="col-3">
                                    <label class="my-2">Estate</label>
                                    <select type="text" name="estate_id" class="form-control" required>
                                        <option value="1">None</option>
                                        @foreach($estate as $data)
                                            <option value="{{$data->id}}">{{$data->title}}</option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="col-3">
                                    <label class="my-2">Address</label>
                                    <input type="text" name="address" class="form-control" required>
                                </div>

                                <div class="col-3">
                                    <label class="my-2">City</label>
                                    <input type="text" name="city" class="form-control" required>
                                </div>

                                <div class="col-3">
                                    <label class="my-2">State</label>
                                    <select type="text" name="state" class="form-control" required>
                                        <option value="Lagos">Lagos</option>
                                        <option value="oyo">Oyo</option>
                                        <option value="Abia">Abia</option>
                                        <option value="Adamawa">Adamawa</option>
                                    </select>

                                </div>
                            </div>


                            <hr class="my-4">

                            <div class="row">


                                <h6 class="d-flex justify-content-start my-2">Meter Information</h6>

                                <div class="col-3">
                                    <label class="my-2">Meter No</label>
                                    <input type="number" name="meterNo" class="form-control" required>
                                </div>

                                <div class="col-3">
                                    <label class="my-2">Meter Type</label>
                                    <select type="text" name="meterType" class="form-control" required>
                                        <option value="prepaid">Prepaid</option>
                                        <option value="postpaid">Postpaid</option>
                                    </select>

                                </div>



                            </div>

                            <hr class="my-4">


                            <div class="row">


                                <hr class="my-4">
                                <h6 class="d-flex justify-content-start my-2">Login Information</h6>

                                <div class="col-4">
                                    <label class="my-2">User Role</label>
                                    <select type="text" name="role" class="form-control" required>
                                        <option value="2">Customer</option>
                                        <option value="1">Admin</option>
                                        <option value="3">Estate Admin</option>
                                        <option value="4">Estate Staff</option>


                                    </select>

                                </div>

                                <div class="col-4">
                                    <label class="my-2">Password</label>
                                    <input type="password" name="password" value="123456" class="form-control" required>
                                </div>

                                <div class="col-4">
                                    <label class="my-2">Confirm Password</label>
                                    <input type="password" name="password_confirmation" value="123456" class="form-control" required>


                                </div>



                            </div>

                            <hr class="my-4">
                            <button type="submit" class="col-2 d-flex btn btn-primary">
                                Create
                            </button>




                        </form>


                    </div>


                </div>


            </div>


        </div>


    </div> <!-- container-fluid -->

@endsection
