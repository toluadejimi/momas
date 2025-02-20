@extends('layouts.main')
@section('content')


    @if(Auth::user()->role == 0)
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
                        <h4 class="fs-18 fw-semibold m-0">Add New Merchant</h4>
                    </div>
                </div>


                <div class="row">

                    <div class="card">

                        <div class="card-body">

                            <form action="add-merchant" method="post">
                                @csrf

                                <div class="row">

                                    <h6 class="d-flex justify-content-start my-4">Merchant Information</h6>


                                    <div class="row">

                                        <div class="col-xl-3 col-sm-12">
                                            <label class="my-2">First Name</label>
                                            <input  type="text" class="form-control" name="first_name"  required>
                                        </div>

                                        <div class="col-xl-3 col-sm-12">
                                            <label class="my-2">Last Name</label>
                                            <input  type="text" class="form-control" name="last_name"  required>
                                        </div>

                                        <div class="col-xl-3 col-sm-12">
                                            <label class="my-2">State</label>
                                            <select type="text" name="state" class="form-control" >
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

                                        <div class="col-xl-3 col-sm-12">
                                            <label class="my-2">City</label>
                                            <input  type="text" class="form-control" name="city"  required>
                                        </div>



                                        <div class="col-xl-3 col-sm-12">
                                            <label class="my-2">Phone No</label>
                                            <input  type="number" class="form-control" name="phone_no">
                                        </div>

                                    </div>


                                    <hr class="my-4">



                                    <div class="row">

                                        <div class="col-xl-3 col-sm-12">
                                            <label class="my-2">Serial No</label>
                                            <input  type="number" class="form-control" name="serial_no"  required>
                                        </div>

                                        <div class="col-xl-3 col-sm-12">
                                            <label class="my-2">TID</label>
                                            <input  type="text" class="form-control" name="tid"  required>
                                        </div>


                                    </div>




                                    <hr class="my-4">


                                    <button type="submit" class="col-xl-2 col-sm-12 d-flex btn btn-primary">
                                        Create Merchant
                                    </button>

                                </div>


                            </form>


                        </div>


                    </div>


                </div>


            </div>


        </div> <!-- container-fluid -->
    @elseif(Auth::user()->role == 1)
    @elseif(Auth::user()->role == 2)
    @elseif(Auth::user()->role == 3)

    @elseif(Auth::user()->role == 4)
    @elseif(Auth::user()->role == 5)
    @else
    @endif



@endsection
