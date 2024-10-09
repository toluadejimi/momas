@extends('layouts.main')
@section('content')


    @if(auth::user()->role == 0)
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Project Settings</h4>
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

                    <div class="card">

                        <div class="card-body">

                            <form action="features" method="post">
                                @csrf

                                <div class="row">

                                    <h6 class="d-flex justify-content-start my-4">Project Features</h6>

                                    <div class="col-2">
                                        <label class="my-2">Momas Meter</label>
                                        <select type="text" name="momas_meter" class="form-control" required>
                                            @if($fea->momas_meter == 1)
                                                <option value="1">ON</option>
                                            @elseif($fea->momas_meter == 0)
                                                <option value="0">OFF</option>
                                            @endif
                                            <option value="1">ON</option>
                                            <option value="0">OFF</option>
                                        </select>

                                    </div>


                                    <div class="col-2">
                                        <label class="my-2">Other Meter</label>
                                        <select type="text" name="other_meter" class="form-control" required>
                                            @if($fea->other_meter == 1)
                                                <option value="1">ON</option>
                                            @elseif($fea->other_meter == 0)
                                                <option value="0">OFF</option>
                                            @endif
                                            <option value="1">ON</option>
                                            <option value="0">OFF</option>
                                        </select>

                                    </div>


                                    <div class="col-2">
                                        <label class="my-2">Print Token</label>
                                        <select type="text" name="print_token" class="form-control" required>
                                            @if($fea->print_token == 1)
                                                <option value="1">ON</option>
                                            @elseif($fea->print_token == 0)
                                                <option value="0">OFF</option>
                                            @endif
                                            <option value="1">ON</option>
                                            <option value="0">OFF</option>
                                        </select>

                                    </div>

                                    <div class="col-2">
                                        <label class="my-2">Access Token</label>
                                        <select type="text" name="access_token" class="form-control" required>
                                            @if($fea->access_token == 1)
                                                <option value="1">ON</option>
                                            @elseif($fea->access_token == 0)
                                                <option value="0">OFF</option>
                                            @endif
                                            <option value="1">ON</option>
                                            <option value="0">OFF</option>
                                        </select>

                                    </div>

                                    <div class="col-2">
                                        <label class="my-2">Services</label>
                                        <select type="text" name="services" class="form-control" required>
                                            @if($fea->services == 1)
                                                <option value="1">ON</option>
                                            @elseif($fea->services == 0)
                                                <option value="0">OFF</option>
                                            @endif
                                            <option value="1">ON</option>
                                            <option value="0">OFF</option>
                                        </select>

                                    </div>

                                    <div class="col-2">
                                        <label class="my-2">Bill Payment</label>
                                        <select type="text" name="bill_payment" class="form-control" required>
                                            @if($fea->bill_payment == 1)
                                                <option value="1">ON</option>
                                            @elseif($fea->bill_payment == 0)
                                                <option value="0">OFF</option>
                                            @endif
                                            <option value="1">ON</option>
                                            <option value="0">OFF</option>
                                        </select>

                                    </div>

                                    <div class="col-2">
                                        <label class="my-2">Support</label>
                                        <select type="text" name="support" class="form-control" required>
                                            @if($fea->support == 1)
                                                <option value="1">ON</option>
                                            @elseif($fea->support == 0)
                                                <option value="0">OFF</option>
                                            @endif
                                            <option value="1">ON</option>
                                            <option value="0">OFF</option>
                                        </select>

                                    </div>

                                    <div class="col-2">
                                        <label class="my-2">Analysis</label>
                                        <select type="text" name="analysis" class="form-control" required>
                                            @if($fea->analysis == 1)
                                                <option value="1">ON</option>
                                            @elseif($fea->analysis == 0)
                                                <option value="0">OFF</option>
                                            @endif
                                            <option value="1">ON</option>
                                            <option value="0">OFF</option>
                                        </select>

                                    </div>


                                </div>


                                <hr class="my-4">

                                <button type="submit" class="col-2 d-flex btn btn-primary">
                                    Update Features
                                </button>


                            </form>


                        </div>


                    </div>


                </div>

                <div class="row">

                    <div class="card">

                        <div class="card-body">

                            <form action="payment-keys" method="post">
                                @csrf

                                <div class="row">

                                    <h6 class="d-flex justify-content-start my-4">Payment Keys</h6>

                                    <div class="col-6">
                                        <label class="my-2">Flutterwave Secret</label>
                                        <input type="text" name="flutterwave_secret" class="form-control" value="{{$set->flutterwave_secret}}">

                                    </div>

                                    <div class="col-6">
                                        <label class="my-2">Flutterwave Public</label>
                                        <input type="text" name="flutterwave_public" class="form-control" value="{{$set->flutterwave_public}}">

                                    </div>

                                    <div class="col-6">
                                        <label class="my-2">Paystack Secret</label>
                                        <input type="text" name="paystack_secret" class="form-control" value="{{$set->paystack_secret}}">

                                    </div>

                                    <div class="col-6">
                                        <label class="my-2">Paystack Public</label>
                                        <input type="text" name="paystack_public" class="form-control" value="{{$set->paystack_public}}">

                                    </div>




                                </div>


                                <hr class="my-4">

                                <button type="submit" class="col-2 d-flex btn btn-primary">
                                    Update Payment Keys
                                </button>


                            </form>


                        </div>


                    </div>


                </div>


                <div class="row">

                    <div class="card">

                        <div class="card-body">

                            <form action="support-set" method="post">
                                @csrf

                                <div class="row">

                                    <h6 class="d-flex justify-content-start my-4">Support Settings</h6>

                                    <div class="col-6">
                                        <label class="my-2">Payment Support</label>
                                        <input type="text" name="payment_support" class="form-control" value="{{$set->payment_support}}">

                                    </div>

                                    <div class="col-6">
                                        <label class="my-2">Meter Support</label>
                                        <input type="text" name="meter_support" class="form-control" value="{{$set->meter_support}}">

                                    </div>

                                    <div class="col-6">
                                        <label class="my-2">General Support</label>
                                        <input type="text" name="general_support" class="form-control" value="{{$set->general_support}}">

                                    </div>





                                </div>


                                <hr class="my-4">

                                <button type="submit" class="col-2 d-flex btn btn-primary">
                                    Update Support
                                </button>


                            </form>


                        </div>


                    </div>


                </div>


            </div>


        </div>
    @elseif(auth::user()->role == 1)
    @elseif(auth::user()->role == 2)
    @elseif(auth::user()->role == 3)
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Estate Settings</h4>
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

                    <div class="card">

                        <div class="card-body">


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


                    </div>


                </div>




            </div>


        </div>
    @elseif(auth::user()->role == 4)
    @elseif(auth::user()->role == 5)
    @else
    @endif




@endsection
