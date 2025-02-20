@extends('layouts.main')
@section('content')



    @if(Auth::user()->role == 0)
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

                                    <h6 class="d-flex justify-content-start my-4">Customer Information</h6>

                                    <div class="col-xl-3 col-sm-12">
                                        <label class="my-2">First Name</label>
                                        <input type="text" name="first_name" class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-sm-12">
                                        <label class="my-2">Last Name</label>
                                        <input type="text" name="last_name" class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-sm-12">
                                        <label class="my-2">Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-sm-12">
                                        <label class="my-2">Phone</label>
                                        <input type="number" name="phone" class="form-control" required>
                                    </div>


                                    <div class="col-xl-3 col-sm-12">
                                        <label class="my-2">Estate</label>
                                        <select type="text" name="estate_id" class="form-control" required>
                                            <option value="1">None</option>
                                            @foreach($estate as $data)
                                                <option value="{{$data->id}}">{{$data->title}}</option>
                                            @endforeach
                                        </select>

                                    </div>

                                    <div class="col-xl-3 col-sm-12">
                                        <label class="my-2">Address</label>
                                        <input type="text" name="address" class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-sm-12">
                                        <label class="my-2">City</label>
                                        <input type="text" name="city" class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-sm-12">
                                        <label class="my-2">Designation</label>
                                        <input type="text" name="desgination" class="form-control" required>
                                    </div>


                                    <div class="col-xl-3 col-sm-12">
                                        <label class="my-2">State</label>
                                        <select type="text" name="state" class="form-control" required>
                                            <option disabled selected>--Select State--</option>
                                            <option value="Abia">Abia</option>
                                            <option value="Adamawa">Adamawa</option>
                                            <option value="Akwa Ibom">Akwa Ibom</option>
                                            <option value="Anambra">Anambra</option>
                                            <option value="Bauchi">Bauchi</option>
                                            <option value="Bayelsa">Bayelsa</option>
                                            <option value="Benue">Benue</option>
                                            <option value="Borno">Borno</option>
                                            <option value="Cross River">Cross River</option>
                                            <option value="Delta">Delta</option>
                                            <option value="Ebonyi">Ebonyi</option>
                                            <option value="Edo">Edo</option>
                                            <option value="Ekiti">Ekiti</option>
                                            <option value="Enugu">Enugu</option>
                                            <option value="FCT">Federal Capital Territory</option>
                                            <option value="Gombe">Gombe</option>
                                            <option value="Imo">Imo</option>
                                            <option value="Jigawa">Jigawa</option>
                                            <option value="Kaduna">Kaduna</option>
                                            <option value="Kano">Kano</option>
                                            <option value="Katsina">Katsina</option>
                                            <option value="Kebbi">Kebbi</option>
                                            <option value="Kogi">Kogi</option>
                                            <option value="Kwara">Kwara</option>
                                            <option value="Lagos">Lagos</option>
                                            <option value="Nasarawa">Nasarawa</option>
                                            <option value="Niger">Niger</option>
                                            <option value="Ogun">Ogun</option>
                                            <option value="Ondo">Ondo</option>
                                            <option value="Osun">Osun</option>
                                            <option value="Oyo">Oyo</option>
                                            <option value="Plateau">Plateau</option>
                                            <option value="Rivers">Rivers</option>
                                            <option value="Sokoto">Sokoto</option>
                                            <option value="Taraba">Taraba</option>
                                            <option value="Yobe">Yobe</option>
                                            <option value="Zamfara">Zamfara</option>
                                        </select>

                                    </div>
                                </div>


                                <hr class="my-4">



                                <div class="row">


                                    <hr class="my-4">
                                    <h6 class="d-flex justify-content-start my-2">Login Information</h6>

                                    <div class="col-xl-4 col-sm-12">
                                        <label class="my-2">User Role</label>
                                        <select type="text" name="role" class="form-control" required>
                                            <option value="2">Customer</option>
                                            <option value="0">Super Admin</option>
                                            <option value="3">Estate Admin</option>
                                            <option value="4">Estate Staff</option>


                                        </select>

                                    </div>

                                    <div class="col-xl-4 col-sm-12">
                                        <label class="my-2">Password</label>
                                        <input type="password" name="password" value="123456" class="form-control" required>
                                    </div>

                                    <div class="col-xl-4 col-sm-12">
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
    @elseif(Auth::user()->role == 1)
    @elseif(Auth::user()->role == 2)
    @elseif(Auth::user()->role == 3)
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

                                    <h6 class="d-flex justify-content-start my-4">Customer Information</h6>

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
                                        <input type="text" value="{{$estate->title}}" class="form-control" disabled required>
                                        <input type="text" value="{{$estate->id}}" name="estate_id"  hidden>

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
                                            <option disabled selected>--Select State--</option>
                                            <option value="Abia">Abia</option>
                                            <option value="Adamawa">Adamawa</option>
                                            <option value="Akwa Ibom">Akwa Ibom</option>
                                            <option value="Anambra">Anambra</option>
                                            <option value="Bauchi">Bauchi</option>
                                            <option value="Bayelsa">Bayelsa</option>
                                            <option value="Benue">Benue</option>
                                            <option value="Borno">Borno</option>
                                            <option value="Cross River">Cross River</option>
                                            <option value="Delta">Delta</option>
                                            <option value="Ebonyi">Ebonyi</option>
                                            <option value="Edo">Edo</option>
                                            <option value="Ekiti">Ekiti</option>
                                            <option value="Enugu">Enugu</option>
                                            <option value="FCT">Federal Capital Territory</option>
                                            <option value="Gombe">Gombe</option>
                                            <option value="Imo">Imo</option>
                                            <option value="Jigawa">Jigawa</option>
                                            <option value="Kaduna">Kaduna</option>
                                            <option value="Kano">Kano</option>
                                            <option value="Katsina">Katsina</option>
                                            <option value="Kebbi">Kebbi</option>
                                            <option value="Kogi">Kogi</option>
                                            <option value="Kwara">Kwara</option>
                                            <option value="Lagos">Lagos</option>
                                            <option value="Nasarawa">Nasarawa</option>
                                            <option value="Niger">Niger</option>
                                            <option value="Ogun">Ogun</option>
                                            <option value="Ondo">Ondo</option>
                                            <option value="Osun">Osun</option>
                                            <option value="Oyo">Oyo</option>
                                            <option value="Plateau">Plateau</option>
                                            <option value="Rivers">Rivers</option>
                                            <option value="Sokoto">Sokoto</option>
                                            <option value="Taraba">Taraba</option>
                                            <option value="Yobe">Yobe</option>
                                            <option value="Zamfara">Zamfara</option>
                                        </select>

                                    </div>
                                </div>


                                <hr class="my-4">

                                <div class="row">


                                    <h6 class="d-flex justify-content-start my-2">Attach Meter</h6>

                                    <div class="col-3">
                                        <label class="my-2">Choose Meter</label>
                                        <div>
                                            <select style="border-color:rgb(0, 11, 136); padding: 10px" class="w-100"  id="dropdownMenu" class="dropdown-content" name="meterid">
                                                <option
                                                    value="{{$user->meterid ?? "id"}}">{{$user->meterNo ?? "Select Meter"}}</option>
                                                @foreach($meters as $data)
                                                    <option value="{{$data->id}}">{{$data->meterNo}}</option>
                                                @endforeach
                                            </select>
                                        </div>
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

    @elseif(Auth::user()->role == 4)
    @elseif(Auth::user()->role == 5)
    @else
    @endif


@endsection
