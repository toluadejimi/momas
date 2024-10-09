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
                    <h4 class="fs-18 fw-semibold m-0">Add New Estate</h4>
                </div>
            </div>


            <div class="row">

                <div class="card" >

                    <div class="card-body">

                        <form action="estate-update-info" method="post">
                            @csrf

                            <div class="row">

                                <h6 class="d-flex justify-content-start my-4">Estate Information</h6>

                                <div class="col-4">
                                    <label class="my-2">Estate Name</label>
                                    <input type="text" name="title" value="{{$org->title}}" class="form-control"
                                           required>
                                    <input hidden name="id" value="{{$org->id}}" class="form-control" required>

                                </div>

                                <div class="col-4">
                                    <label class="my-2">State</label>
                                    <input type="text" name="state" value="{{$org->state}}" class="form-control"
                                           required>

                                </div>

                                <div class="col-4">
                                    <label class="my-2">City</label>
                                    <input type="text" name="city" value="{{$org->city}}" class="form-control"
                                           required>

                                </div>

                                <div class="col-4">
                                    <label class="my-2">LGA</label>
                                    <input type="text" name="lga" value="{{$org->lga}}" class="form-control"
                                           required>

                                </div>

                                <div class="col-3">
                                    <label class="my-2">Status</label>
                                    <select type="text" name="status" class="form-control" required>
                                        <option value="2">Activate</option>
                                        <option value="0">Deactivate</option>

                                    </select>

                                </div>

                            </div>

                            <hr class="my-4">

                            <button type="submit" class="col-2 d-flex btn btn-primary">
                                Update Info
                            </button>


                        </form>

                    </div>


                </div>

                <div class="card " style="background: #f3ffff">
                    <div class="card-body">
                        <form action="estate-update-tariff" method="post">
                            @csrf

                            <div class="row">

                                <h6 class="d-flex justify-content-start my-4">Tariff Information</h6>

                                <div class="col-4">
                                    <label class="my-2">Tariff Amount</label>
                                    <input type="number" step="0.01" name="amount" value="{{$tar->estate_tariff_cost}}"
                                           class="form-control"
                                           required>

                                    <input hidden name="id" value="{{$org->id}}" class="form-control" required>


                                </div>


                                <div class="col-4">
                                    <label class="my-2">VAT</label>
                                    <input type="number" step="0.01" name="vat" value="{{$tar->vat}}"
                                           class="form-control"
                                           required>


                                </div>

                                <hr class="my-4">

                                <h6 class="d-flex justify-content-start my-4">MIN/MAX PURCHASE Information</h6>


                                <div class="col-4">
                                    <label class="my-2">MIN Purchase</label>
                                    <input type="number" step="0.01" name="min_pur" value="{{$tar->min_pur}}"
                                           class="form-control"
                                           required>


                                </div>


                                <div class="col-4">
                                    <label class="my-2">MAX Purchase</label>
                                    <input type="number" step="0.01" name="max_pur" value="{{$tar->max_pur}}"
                                           class="form-control"
                                           required>


                                </div>



                            </div>

                            <hr class="my-4">

                            <button type="submit" class="col-2 d-flex btn btn-primary">
                                Update
                            </button>


                        </form>
                    </div>
                </div>


            </div>


            <div class="row">

                <div class="card" style="background: #f3fffa">

                    <div class="card-body" >

                        <form action="estate-update-utilities" method="post">
                            @csrf

                            <div class="row">

                                <div class="d-flex justify-content-between my-4">
                                    <h6 class="">Utilities Information</h6>
                                    <h6 class="mb-0">Total Utilities <span
                                            class="badge text-bg-secondary">NGN {{number_format($total_utility, 2)}}</span>
                                    </h6>
                                    @if($utl->duration != null)
                                        <h6 class="mb-0">Duration <span
                                                class="badge text-bg-danger">{{strtoupper($utl->duration)}}</span></h6>
                                    @else
                                        <h6 class="mb-0">Duration <span
                                                class="badge text-bg-secondary">Set Duration</span></h6>
                                    @endif
                                </div>

                                <div class="col-4">
                                    <label class="my-2">Water</label>
                                    <input type="text" name="water" value="{{$utl->water}}" class="form-control"
                                           required>
                                    <input hidden name="id" value="{{$org->id}}" class="form-control" required>

                                </div>

                                <div class="col-4">
                                    <label class="my-2">Electricity</label>
                                    <input type="text" name="eletricity" value="{{$utl->eletricity}}"
                                           class="form-control"
                                           required>

                                </div>

                                <div class="col-4">
                                    <label class="my-2">Security</label>
                                    <input type="text" name="security" value="{{$utl->security}}" class="form-control"
                                           required>

                                </div>


                                <div class="col-4">
                                    <label class="my-2">Waste</label>
                                    <input type="text" name="waste" value="{{$utl->waste}}" class="form-control"
                                           required>

                                </div>

                                <div class="col-4">
                                    <label class="my-2">Cleaners</label>
                                    <input type="text" name="cleaners" value="{{$utl->cleaners}}" class="form-control"
                                           required>

                                </div>

                                <div class="col-4">
                                    <label class="my-2">Gardner</label>
                                    <input type="text" name="grardners" value="{{$utl->grardners}}" class="form-control"
                                           required>

                                </div>

                                <div class="col-4">
                                    <label class="my-2">Service Charge</label>
                                    <input type="text" name="service_charge" value="{{$utl->service_charge}}"
                                           class="form-control"
                                           required>

                                </div>


                                <div class="col-4">
                                    <label class="my-2">Duration</label>
                                    <select type="text" name="duration" class="form-control" required>
                                        @if($utl->duration != null)
                                            <option value="{{$utl->duration}}">{{strtoupper($utl->duration)}}</option>
                                        @else
                                            <option value=" ">Set Duration</option>
                                        @endif
                                        <option value="daily">Daily</option>
                                        <option value="daily">Daily</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly">Monthly</option>
                                        <option value="quarterly">Quarterly</option>
                                        <option value="annually">Annually</option>
                                        <option value="onetime">OneTime</option>


                                    </select>

                                </div>


                                <div class="col-4">
                                    <label class="my-2">Status</label>
                                    <select type="text" name="status" class="form-control" required>
                                        <option value="2">Activate</option>
                                        <option value="0">Deactivate</option>

                                    </select>

                                </div>

                            </div>

                            <hr class="my-4">

                            <button type="submit" class="col-2 d-flex btn btn-primary">
                                Update Utility Bills
                            </button>


                        </form>


                    </div>


                </div>


            </div>



        </div>


    </div> <!-- container-fluid -->

@endsection
