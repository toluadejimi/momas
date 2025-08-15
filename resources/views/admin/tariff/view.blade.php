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
                        <h4 class="fs-18 fw-semibold m-0">Add New Tariff</h4>
                    </div>
                </div>


                <div class="col-xl-6">
                    <div class="card">
                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop"
                             data-bs-backdrop="static" data-bs-keyboard="false"
                             tabindex="-1" aria-labelledby="staticBackdropLabel"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5"
                                            id="staticBackdropLabel">Add New Tariff State</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>

                                    <form action="/admin/add-new-tariffstate" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="modal-body">

                                            <label class="my-2">Tariff Index</label>
                                            <select class="form-control my-1" name="t_index" required>
                                                    <option value="">---Select Index-----</option>
                                                @php
                                                    for ($i = 1; $i <= 99; $i++) {
                                                        echo "<option value=\"$i\">$i</option>";
                                                    }
                                                @endphp

                                            </select>


                                            <label class="my-1">Tariff Amount </label>
                                            <input type="text"  class="form-control mb-3" name="amount" required>

                                            <label class="my-1">Vat %</label>
                                            <input type="text" value="1.075" class="form-control mb-3" name="vat" required>

                                            <div class="col-12 my-3">
                                                <label class="my-2">Choose Estate</label>
                                                <select name="estate_id" class="form-control" required>
                                                    <option value="">---Select---</option>
                                                    @foreach($estate as $item)
                                                        <option value="{{$item->id}}">{{$item->title}}</option>
                                                    @endforeach
                                                </select>

                                            </div>


                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="my-1">Effective Date From</label>
                                                    <input type="date" value="{{$effictive_date ?? null}}"
                                                           class="form-control mb-3" name="date_from"
                                                           required>
                                                </div>
                                                <div class="col-5">
                                                    <label class="my-1">Effective Date To</label>
                                                    <input type="date" class="form-control mb-3" name="date_to"
                                                           >

                                                    <input type="text" name="tariff_id" value="{{$tr->id}}" hidden>




                                                </div>


                                                <div class="col-5">

                                                    <label class="my-1">Never Expire</label>
                                                    <select class="form-control" name="never_expire" required>
                                                        <option value="">--select option---</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>


                                                </div>


                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">Continue</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div>


                <div class="row">

                    <div class="card">

                        <div class="card-body">

                            <form action="update-the-tariff" method="post">
                                @csrf

                                <div class="row">

                                    <h6 class="d-flex justify-content-start my-4">Tariff Information</h6>
                                    <div class="col-3">
                                        <label class="my-2">Tariff Title</label>
                                        <input type="text" value="{{$tr->title ?? "name"}}" name="title"
                                               class="form-control" required>
                                        <input type="text" name="id" value="{{$tr->id}}" hidden>


                                    </div>


                                    <hr class="my-4">

                                    <button type="submit" class="col-2 d-flex btn btn-primary">
                                        Update Tariff
                                    </button>

                                </div>


                            </form>


                        </div>


                    </div>

                    <div class="card">

                        <div class="card-body">

{{--                            <form action="update-the-tariff" method="post">--}}
{{--                                @csrf--}}


                                <div class="row">

                                    <div class="d-flex justify-content-between">
                                        <h6 class="d-flex justify-content-start my-4">Tariff History</h6>
                                        <a href="#" data-bs-toggle="modal"
                                           data-bs-target="#staticBackdrop"
                                           class="btn btn-primary d-flex justify-content-end my-4">Add Rate</a>

                                    </div>

                                    <hr>

                                    @foreach($tstate as $data)

                                        <div class="col-3">
                                            <label class="my-1">Tariff Amount</label>
                                            <a href="#" data-bs-toggle="modal"
                                               data-bs-target="#updatestate{{$data->id}}">
                                                <h6>{{$data->amount}}</h6></a>

                                            <div class="modal fade" id="updatestate{{$data->id}}"
                                                 data-bs-backdrop="static" data-bs-keyboard="false"
                                                 tabindex="-1" aria-labelledby="staticBackdropLabel"
                                                 aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5"
                                                                id="staticBackdropLabel">Update State</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                        </div>

                                                        <form action="update-tariffstate" method="POST"
                                                              enctype="multipart/form-data">
                                                            @csrf

                                                            <div class="modal-body">

                                                                    <label class="my-2">Tariff Index</label>
                                                                    <select class="form-control my-1" name="t_index" required>
                                                                        @if($data->t_index != null)
                                                                            <option value="">{{$data->t_index}}</option>
                                                                        @else
                                                                            <option value="">---Select Index-----</option>
                                                                        @endif
                                                                        @php
                                                                            for ($i = 1; $i <= 99; $i++) {
                                                                                echo "<option value=\"$i\">$i</option>";
                                                                            }
                                                                        @endphp

                                                                    </select>


                                                                <label class="my-1">Tariff Amount</label>
                                                                <input type="number" class="form-control mb-3"
                                                                       value="{{$data->amount}}" name="amount" required>

                                                                <input value="{{$data->id}}" hidden="" name="id" required>

                                                                <label class="my-1">Vat %</label>
                                                                <input type="number" class="form-control mb-3"
                                                                       value="{{$data->vat}}" name="vat" readonly>


                                                                <input type="text" name="estate_id" value="{{$data->estate_id}}" hidden>
                                                                <input hidden type="text" name="id" value="{{$data->id}}" >

                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <label class="my-1">Status</label>
                                                                        <select name="status" class="form-control">
                                                                            @if($data->status == 2)
                                                                                <option value="2">Active</option>
                                                                                <option value="0">Inactive</option>
                                                                            @elseif($data->status == 0)
                                                                                <option value="0">Inactive</option>
                                                                                <option value="2">Active</option>
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light"
                                                                        data-bs-dismiss="modal">Close
                                                                </button>
                                                                <button type="submit" class="btn btn-primary">Continue
                                                                </button>
                                                            </div>

                                                        </form>

                                                    </div>
                                                </div>
                                            </div>



                                        </div>


                                        <div class="col-3">

                                            <label class="my-1">Tariff ID</label>
                                            <h6>{{$data->t_index}}</h6>

                                        </div>

                                        <div class="col-3">

                                            <label class="my-1">Date Effective From</label>
                                            <h6>{{$data->effective_from}}</h6>

                                        </div>


                                        <div class="col-3">

                                            <label class="my-1">VAT</label>
                                            <h6>{{$data->vat}}%</h6>

                                        </div>

                                        <div class="col-3">

                                            <label class="my-1">Date Effective To</label>
                                            <h6>{{$data->effective_to}}</h6>

                                        </div>

                                        <div class="col-3">

                                            <label class="my-1">Status</label>
                                            @if($data->status == 0)
                                                <span class="btn btn-warning">Inactive</span>
                                            @elseif($data->status == 2)
                                                <span class="badge text-bg-primary">Active</span>
                                            @endif

                                        </div>



                                        <hr>

                                    @endforeach
                                </div>
{{--                            </form>--}}

                        </div>
                    </div>


                </div>


            </div>

        </div>
    @elseif(Auth::user()->role == 1)
    @elseif(Auth::user()->role == 2)
    @elseif(Auth::user()->role == 3)
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
                        <h4 class="fs-18 fw-semibold m-0">Add New Tariff</h4>
                    </div>
                </div>


                <div class="col-xl-6">
                    <div class="card">
                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop"
                             data-bs-backdrop="static" data-bs-keyboard="false"
                             tabindex="-1" aria-labelledby="staticBackdropLabel"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5"
                                            id="staticBackdropLabel">Add New Tariff</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>

                                    <form action="/admin/add-new-tariffstate" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="modal-body">

                                            <label class="my-1">Tariff Amount</label>
                                            <input type="text"  class="form-control mb-3" name="amount" required>

                                            <label class="my-1">Vat %</label>
                                            <input type="text" value="1.075" class="form-control mb-3" name="vat" required>


                                            <div class="row">
                                                <div class="col-6">
                                                    <label class="my-1">Effective Date From</label>
                                                    <input type="date" value="{{$effictive_date ?? null}}"
                                                           class="form-control mb-3" name="date_from"
                                                           required>
                                                </div>

                                                <div class="col-5">
                                                    <label class="my-1">Effective Date To</label>
                                                    <input type="date" class="form-control mb-3" name="date_to"
                                                           >

                                                    <input type="text" name="id" value="{{$tr->id}}" hidden>

                                                    <input type="text" name="estate_id" value="{{Auth::user()->estate_id}}" hidden>


                                                </div>





                                                <div class="col-5">

                                                    <label class="my-1">Never Expire</label>
                                                    <select class="form-control" name="never_expire" required>
                                                        <option value="">--select option---</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>


                                                </div>


                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close
                                            </button>
                                            <button type="submit" class="btn btn-primary">Continue</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div> <!-- end card -->
                </div>


                <div class="row">

                    <div class="card">

                        <div class="card-body">

                            <form action="update-the-tariff" method="post">
                                @csrf

                                <div class="row">

                                    <h6 class="d-flex justify-content-start my-4">Tariff Information</h6>
                                    <div class="col-3">
                                        <label class="my-2">Tariff Title</label>
                                        <input type="text" value="{{$tr->title ?? "name"}}" name="title"
                                               class="form-control" required>
                                        <input type="text" name="estate_id" value="{{Auth::user()->estate_id}}" hidden>
                                        <input type="text" name="id" value="{{$tr->id}}" hidden>


                                    </div>


                                    <hr class="my-4">

                                    <button type="submit" class="col-2 d-flex btn btn-primary">
                                        Update Tariff
                                    </button>

                                </div>


                            </form>


                        </div>


                    </div>

                    <div class="card">

                        <div class="card-body">

                            <form action="update-the-tariff" method="post">
                                @csrf


                                <div class="row">

                                    <div class="d-flex justify-content-between">
                                        <h6 class="d-flex justify-content-start my-4">Tariff History</h6>
                                        <a href="#" data-bs-toggle="modal"
                                           data-bs-target="#staticBackdrop"
                                           class="btn btn-primary d-flex justify-content-end my-4">Add Rate</a>

                                    </div>

                                    <hr>

                                    @foreach($tstate as $data)


                                        <div class="col-3">

                                            <label class="my-1">Tariff Amount</label>
                                            <a href="#" data-bs-toggle="modal"
                                               data-bs-target="#updatestate{{$data->id}}">
                                                <h6>{{$data->amount}}</h6></a>

                                            <div class="modal fade" id="updatestate{{$data->id}}"
                                                 data-bs-backdrop="static" data-bs-keyboard="false"
                                                 tabindex="-1" aria-labelledby="staticBackdropLabel"
                                                 aria-hidden="true">

                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5"
                                                                id="staticBackdropLabel">Update State</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                        </div>

                                                        <form action="update-tariffstate" method="POST"
                                                              enctype="multipart/form-data">
                                                            @csrf

                                                            <div class="modal-body">

                                                                <label class="my-1">Tariff Amount</label>
                                                                <input type="number" class="form-control mb-3"
                                                                       value="{{$data->amount}}" name="amount" required>

                                                                <input name="id" hidden value="{{$data->id}}">


                                                                <label class="my-1">Vat %</label>
                                                                <input type="number" class="form-control mb-3"
                                                                       value="{{$data->vat}}" name="vat" required>


                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <label class="my-1">Status</label>
                                                                        <select name="status" class="form-control">
                                                                            @if($data->status == 2)
                                                                                <option value="2">Active</option>
                                                                                <option value="0">Inactive</option>
                                                                            @elseif($data->status == 0)
                                                                                <option value="0">Inactive</option>
                                                                                <option value="2">Active</option>
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light"
                                                                        data-bs-dismiss="modal">Close
                                                                </button>
                                                                <button type="submit" class="btn btn-primary">Continue
                                                                </button>
                                                            </div>

                                                        </form>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="col-3">

                                            <label class="my-1">Vat</label>
                                            <h6>{{$data->vat}}%</h6>

                                        </div>



                                        <div class="col-3">

                                            <label class="my-1">Date Effective From</label>
                                            <h6>{{$data->effective_from}}</h6>

                                        </div>



                                        <div class="col-3">

                                            <label class="my-1">Date Effective To</label>
                                            <h6>{{$data->effective_to}}</h6>

                                        </div>



                                        <div class="col-3">

                                            <label class="my-1">Status</label>
                                            @if($data->status == 0)
                                                <span class="btn btn-warning">Inactive</span>
                                            @elseif($data->status == 2)
                                                <span class="badge text-bg-primary">Active</span>
                                            @endif

                                        </div>



                                        <hr>

                                    @endforeach
                                </div>
                            </form>

                        </div>
                    </div>


                </div>


            </div>

        </div>


    @elseif(Auth::user()->role == 4)
    @elseif(Auth::user()->role == 5)
    @else
    @endif

@endsection



