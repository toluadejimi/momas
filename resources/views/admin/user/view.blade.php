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

                                    <h6 class="d-flex justify-content-start my-4">Customer Information</h6>

                                    <div class="col-xl-3 col-sm-12">
                                        <label class="my-2">First Name</label>
                                        <input type="text" value="{{$user->first_name}}" name="first_name"
                                               class="form-control" required>

                                        <input type="text" value="{{$user->email}}" name="email"
                                               hidden>


                                    </div>

                                    <div class="col-xl-3 col-sm-12">
                                        <label class="my-2">Last Name</label>
                                        <input type="text" value="{{$user->last_name}}" name="last_name"
                                               class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-sm-12">
                                        <label class="my-2">Email</label>
                                        <input type="email" disabled value="{{$user->email}}" name="email"
                                               class="form-control"
                                               required>
                                    </div>

                                    <div class="col-xl-3 col-sm-12">
                                        <label class="my-2">Phone</label>
                                        <input type="number" value="{{$user->phone}}" name="phone" class="form-control"
                                               required>
                                    </div>

                                    <div class="col-xl-3 col-sm-12">
                                        <label class="my-2">Estate</label>
                                        <input type="text" value="{{$estate_title}}" name="estate_title"
                                               class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-sm-12">
                                        <label class="my-2">Address</label>
                                        <input type="text" value="{{$user->address}}" name="address"
                                               class="form-control" required>
                                    </div>

                                    <div class="col-xl-3 col-sm-12">
                                        <label class="my-2">City</label>
                                        <input type="text" value="{{$user->city}}" name="city" class="form-control"
                                               required>
                                    </div>

                                    <div class="col-xl-3 col-sm-12">
                                        <label class="my-2">State</label>
                                        <select type="text" name="state" class="form-control" required>
                                            <option value="{{$user->state}}">{{$user->state}}</option>
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
                                        <label class="my-2">LGA</label>
                                        <input type="text" value="{{$user->lga}}" name="lga" class="form-control"
                                               required>
                                    </div>

                                    <div class="col-xl-3 col-sm-12">
                                        <label class="my-2">Designation</label>
                                        <input type="text" value="{{$user->desgination}}" name="desgination"
                                               class="form-control"
                                               required>
                                    </div>


                                    <div class="col-xl-3 col-sm-12">
                                        <label class="my-2">Status</label>
                                        <select type="text" name="status" class="form-control" required>
                                            @if($user->status == 2)
                                                <option value="{{$user->status}}">Active</option>
                                            @elseif($user->status == 0)
                                                <option value="{{$user->status}}">Pending</option>
                                            @elseif($user->status == 3)
                                                <option value="{{$user->status}}"><span
                                                        style="color: red">Inactive</span></option>
                                            @endif
                                            <option value="3">Deactivate</option>
                                            <option value="1">Activate</option>

                                        </select>
                                    </div>


                                </div>

                                <button type="submit" class="col-xl-3 col-sm-12 d-flex btn btn-primary my-3">
                                    Update Customer Information
                                </button>

                            </form>
                        </div>
                    </div>
                </div>


                @if($user->role == 2)
                    <div class="row ">

                        <div class="card col-xl-6 mr-3 col-sm-12 card mr-3">
                            <div class="card-body">
                                <div class="row">
                                    <form action="update-meter" method="post">
                                        @csrf
                                        <div class="row">

                                            <h6 class="d-flex justify-content-start my-2">Attach Information</h6>


                                            <div class="col-xl-5 col-sm-12" style="position: relative;">


                                                <label class="my-2">Choose Meter</label>
                                                @if($meter_count > 0)
                                                    <span
                                                        class="badge text-bg-danger">{{$user->meterNo}}</span>
                                                @else
                                                    <span class="badge text-bg-danger">No meter found</span>
                                                @endif


                                                <input type="text" name="meterNo"
                                                       value="{{$user->meterNo }}" id="searchMeter"
                                                       placeholder="Type meter number..." class="form-control" required
                                                       autocomplete="off">
                                                <div id="meterResult" class="search-result"></div>

                                                <input type="text" name="user_id" value="{{$user->id}}" hidden>

                                                <input type="text" name="old_value" value="{{$user->meterNo}}" hidden>


                                                <script>
                                                    document.getElementById('searchMeter').addEventListener('keyup', function () {
                                                        let query = this.value;
                                                        console.log('User input:', query); // Log user input

                                                        if (query.length > 2) { // Only search if input has more than 2 characters
                                                            let xhr = new XMLHttpRequest();
                                                            xhr.open('GET', '/search-meter?q=' + query, true); // Replace with the correct URL

                                                            xhr.onreadystatechange = function () {
                                                                if (xhr.readyState == 4 && xhr.status == 200) {
                                                                    console.log('Response received:', xhr.responseText); // Log the response

                                                                    let meters = JSON.parse(xhr.responseText);
                                                                    let meterResultDiv = document.getElementById('meterResult');
                                                                    meterResultDiv.innerHTML = ''; // Clear previous results

                                                                    if (meters.length > 0) {
                                                                        meters.forEach(meter => {
                                                                            let div = document.createElement('div');
                                                                            div.textContent = meter.meterNo;
                                                                            div.setAttribute('data-id', meter.id);

                                                                            // Add click event to populate the input with the selected suggestion
                                                                            div.addEventListener('click', function () {
                                                                                document.getElementById('searchMeter').value = meter.meterNo;
                                                                                meterResultDiv.style.display = 'none'; // Hide suggestions
                                                                            });

                                                                            meterResultDiv.appendChild(div);
                                                                        });
                                                                        meterResultDiv.style.display = 'block'; // Show results
                                                                    } else {
                                                                        let noResultDiv = document.createElement('div');
                                                                        noResultDiv.textContent = 'No meters found';
                                                                        noResultDiv.style.color = 'red';
                                                                        meterResultDiv.appendChild(noResultDiv);
                                                                        meterResultDiv.style.display = 'block'; // Show the "No meters found" message
                                                                    }
                                                                } else if (xhr.readyState == 4) {
                                                                    console.log('Error: Status', xhr.status); // Log error status
                                                                }
                                                            };

                                                            xhr.onerror = function () {
                                                                console.error('Request error'); // Log any request errors
                                                            };

                                                            xhr.send();
                                                        } else {
                                                            document.getElementById('meterResult').style.display = 'none'; // Hide if input is too short
                                                        }
                                                    });
                                                </script>


                                            </div>

                                            <div class="col-xl-6 col-sm-12">

                                            </div>



                                            @if($user->meterNo == null)

                                                <div class="col-xl-3 col-sm-12">
                                                    <button type="submit" class="col-12 d-flex w-100 btn btn-primary my-3">
                                                        Update
                                                    </button>
                                                </div>

                                            @else
                                                <a href="detach-meter?meterNo={{$user->meterNo}}" class="col-4 d-flex  btn btn-danger my-3">
                                                    Detach Meter
                                                </a>
                                            @endif


                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="card col-xl-6 mr-3 col-sm-12 card">
                            <div class="card-body">
                                <div class="row">
                                    <form action="set-percentage" method="post">
                                        @csrf
                                        <div class="row">

                                            <h6 class="d-flex justify-content-start my-2">Set Utilities percentage</h6>


                                            <div class="col-xl-4 col-sm-12" style="position: relative;">

                                                <label class="my-2">Set percentage %</label>
                                                <input type="number" step="0.01" name="percent" class="form-control"
                                                       value="{{$percentage}}" required>
                                                <input type="text" name="user_id" value="{{$user->id}}" hidden>
                                                <input type="text" name="estate_id" value="{{$user->estate_id}}" hidden>

                                            </div>

                                            <div class="col-xl-6 col-sm-12">

                                            </div>

                                            <div class="col-xl-3 col-sm-12">
                                                <button type="submit" class="col-12 d-flex w-100 btn btn-primary my-3">
                                                    Update
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>







                    <div class="col-xl-12">
                        <div class="card">

                            <div class="card-header">
                                <h5 class="card-title mb-0">Vending Information</h5>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <ul class="nav nav-pills nav-justified bg-light" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#navpills2-home"
                                           role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-cog"></i></span>
                                            <span class="d-none d-sm-block">Tokens</span>
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#navpills2-messages" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-cog"></i></span>
                                            <span class="d-none d-sm-block">KCT Tokens</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#navpills2-settings" role="tab">
                                            <span class="d-block d-sm-none"><i class="mdi mdi-cog"></i></span>
                                            <span class="d-none d-sm-block">Tariff</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content p-3 text-muted">

                                    {{-- TOKENS--}}
                                    <div class="tab-pane active show" id="navpills2-home" role="tabpanel">
                                        <div class="row">
                                            <div class="d-flex justify-content-between my-4">
                                                <h5 class="card-title text-black mb-0">Meter Token Information</h5>

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
                                                                            id="staticBackdropLabel">Generate Meter
                                                                            Token </h1>
                                                                        <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                    </div>


                                                                    <form action="generate-token" method="POST"
                                                                          enctype="multipart/form-data">
                                                                        @csrf

                                                                        <div class="modal-body">


                                                                            @if($meter_count == 0)

                                                                                <label class="my-2">Meter No</label>
                                                                                <input class="form-control mb-3"
                                                                                       disabled name="meterNo"
                                                                                       value="{{$meter->meterNo ?? "No meter attached"}}">

                                                                            @else


                                                                                <label class="my-2">TRX ID</label>
                                                                                <input class="form-control mb-3"
                                                                                       name="trxid" required>

                                                                                <label class="my-2">Meter No</label>
                                                                                <input class="form-control mb-3"
                                                                                       name="meterNo"
                                                                                       value="{{$meter->meterNo ?? "No meter attached"}}">
                                                                                <input class="form-control mb-3"
                                                                                       name="user_id"
                                                                                       hidden
                                                                                       value="{{$user->id}}">

                                                                            @endif

                                                                            <label class="my-2">Select Vending
                                                                                Type</label>
                                                                            @if($meter_count == 0 && $tariff_count == 0)
                                                                                <span class="badge text-bg-danger">No tariff attached</span>
                                                                                <a href="/admin/new-tariff">Add new
                                                                                    tariff</a>
                                                                            @else
                                                                                @foreach($tariffs as $data)
                                                                                    <span
                                                                                        class="badge text-bg-danger">{{strtoupper($data->type)}}</span>
                                                                                @endforeach
                                                                            @endif

                                                                            @if($meter_count != 0 && $tariff_count != 0)
                                                                                <select class="form-control"
                                                                                        name="tariff_id">
                                                                                    <option value="">--select--</option>
                                                                                    @foreach($tariffs as $data)
                                                                                        <option
                                                                                            value="{{$data->id}}">{{$data->title}}
                                                                                            - {{strtoupper($data->type)}}</option>
                                                                                    @endforeach
                                                                                </select>

                                                                            @else
                                                                                <input class="form-control mb-3"
                                                                                       value="No Tariff found" disabled>
                                                                            @endif


                                                                            @if($meter_count != 0 && $tariff_count != 0)
                                                                                <div class="col">

                                                                                    <label class="my-2">Amount</label>
                                                                                    <input type="number"
                                                                                           class="form-control mb-3"
                                                                                           name="amount">

                                                                                </div>

                                                                            @else
                                                                                <label class="my-2">Amount</label>
                                                                                <input class="form-control mb-3"
                                                                                       value=" " disabled>
                                                                            @endif


                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-light"
                                                                                    data-bs-dismiss="modal">
                                                                                Close
                                                                            </button>
                                                                            @if($meter_count != 0 && $tariff_count != 0)
                                                                                <button type="submit"
                                                                                        class="btn btn-primary">Create
                                                                                </button>
                                                                            @else

                                                                            @endif


                                                                        </div>

                                                                    </form>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> <!-- end card -->
                                                </div> <!-- end col -->
                                                @if($ptype == 1)
                                                @else
                                                    <a href="#" data-bs-toggle="modal"
                                                       data-bs-target="#staticBackdrop"
                                                       class="btn btn-primary text-white justify-content-end">Generate
                                                        new
                                                        Meter Token</a>
                                                @endif

                                            </div>
                                            <div class="card-body">
                                                <table id="datatable"
                                                       class="table table-bordered dt-responsive table-responsive nowrap">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col" class="cursor-pointer">ID</th>
                                                        <th scope="col" class="cursor-pointer">Estate</th>
                                                        <th scope="col" class="cursor-pointer">MeterNo</th>
                                                        <th scope="col" class="cursor-pointer">Token</th>
                                                        <th scope="col" class="cursor-pointer">Amount</th>
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
                                                            <td>{{$data->estate->title}}</td>
                                                            <td>{{$data->meterNo}}</td>
                                                            <td>{{$data->token}}</td>
                                                            <td>{{number_format($data->amount, 2)}}</td>
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
                                                            <td>
                                                                <a href="send-token-email?email={{$user->email}}&amount={{$data->amount}}&token={{$data->token}}&unit={{$data->unit}}"
                                                                   onclick="return confirmDelete();"
                                                                   class="btn btn-primary">Send</a>
                                                            </td>
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


                                    {{-- KCT TOKENS--}}
                                    <div class="tab-pane" id="navpills2-messages" role="tabpanel">
                                        <div class="row">
                                            <div class="d-flex justify-content-between my-4">
                                                <h5 class="card-title text-black mb-0">KCT Token Information</h5>

                                                <div class="col-xl-6">
                                                    <div class="card">
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="kcttoken"
                                                             data-bs-backdrop="static" data-bs-keyboard="false"
                                                             tabindex="-1" aria-labelledby="kcttoken"
                                                             aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5"
                                                                            id="kcttoken">Generate KCT Tokens </h1>


                                                                        <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close"></button>
                                                                    </div>

                                                                    <form action="generate-kct-token" method="POST"
                                                                          enctype="multipart/form-data">
                                                                        @csrf

                                                                        <div class="modal-body">

                                                                            <label class="my-2">Meter No</label>
                                                                            <input class="form-control mb-3" disabled
                                                                                   name="meterNo"
                                                                                   value="{{$meter->meterNo ?? "No meter attached"}}">
                                                                            <input hidden name="meterNo"
                                                                                   value="{{$meter->meterNo ?? "No meter attached"}}">
                                                                            <input hidden name="user_id"
                                                                                   value="{{$user->id}}">


                                                                            @if($meter_count == 0)

                                                                            @else
                                                                                <div class="row">
                                                                                    <div class="col-6">

                                                                                        <label class="my-2">NEW
                                                                                            SGC</label>
                                                                                        <input type="text"
                                                                                               class="form-control mb-3"
                                                                                               value="{{$meter->NewSGC}}"
                                                                                               disabled
                                                                                               name="NewSGC">
                                                                                        <input type="text"
                                                                                               value="{{$meter->NewSGC}}"
                                                                                               hidden
                                                                                               name="NewSGC">

                                                                                    </div>

                                                                                    <div class="col-6">
                                                                                        <label class="my-2">OLD
                                                                                            SGC</label>
                                                                                        <input type="text"
                                                                                               class="form-control mb-3"
                                                                                               disabled
                                                                                               value="{{$meter->OldSGC}}"
                                                                                               name="OldSGC">
                                                                                        <input type="text"
                                                                                               hidden
                                                                                               value="{{$meter->OldSGC}}"
                                                                                               name="OldSGC">
                                                                                    </div>

                                                                                </div>
                                                                            @endif

                                                                            @if($meter_count != 0 && $tariff_count != 0)

                                                                            @else

                                                                            @endif


                                                                        </div>

                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-light"
                                                                                    data-bs-dismiss="modal">
                                                                                Close
                                                                            </button>
                                                                            @if($meter_count != 0 && $tariff_count != 0)
                                                                                <button type="submit"
                                                                                        class="btn btn-primary">Generate
                                                                                    KCT Tokens
                                                                                </button>
                                                                            @else

                                                                            @endif


                                                                        </div>

                                                                    </form>


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> <!-- end card -->
                                                </div> <!-- end col -->
                                                <a href="#" data-bs-toggle="modal"
                                                   data-bs-target="#kcttoken"
                                                   class="btn btn-primary text-white justify-content-end">Generate new
                                                    KCT Tokens</a>
                                            </div>
                                            <div class="card-body">
                                                <table id="datatable"
                                                       class="table table-bordered dt-responsive table-responsive nowrap">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col" class="cursor-pointer">ID</th>
                                                        <th scope="col" class="cursor-pointer">Estate</th>
                                                        <th scope="col" class="cursor-pointer">MeterNo</th>
                                                        <th scope="col" class="cursor-pointer">KCT TOKENS</th>
                                                        <th scope="col" class="cursor-pointer">Action</th>
                                                        <th scope="col" class="cursor-pointer">Date/Time</th>


                                                    </tr>
                                                    </thead>
                                                    <tbody>


                                                    @foreach($kcttokens as $data)

                                                        <tr>
                                                            <td>{{$data->id}} </td>
                                                            <td>{{$data->estate->title}}</td>
                                                            <td>{{$data->meterNo}}</td>
                                                            <td>{{$data->kct_token}}</td>

                                                            <td>
                                                                <a href="send-token-email?email={{$user->email}}&amount={{$data->amount}}&token={{$data->token}}&unit={{$data->unit}}"
                                                                   onclick="return confirmDelete();"
                                                                   class="btn btn-primary">Send</a>
                                                            </td>
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


                                    <div class="tab-pane" id="navpills2-settings" role="tabpanel">

                                        <div class="row">
                                            <div class="col-xl-6 mr-3 col-sm-12 card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <form action="update-nepa" method="post">
                                                            @csrf
                                                            <div class="row">

                                                                <h6 class="d-flex justify-content-start my-2">Tariff
                                                                    Information</h6>


                                                                <div class="col-xl-6 col-sm-12"
                                                                     style="position: relative;">

                                                                    <h6 class="mb-4">NEPA TARIFF <span
                                                                            class="badge text-bg-secondary">{{$nepa_tariff_title   ?? "Set Tariff"}} | ID - {{$tariff_index_nepa ?? " "}}</span>
                                                                    </h6>

                                                                    <select class="form-control my-3" name="id">

                                                                        @foreach($tariff as $data)
                                                                            <option
                                                                                value="{{$data->id}}">{{$data->title}}
                                                                                |
                                                                                ID - {{$data->tariff_index}}</option>
                                                                        @endforeach

                                                                        <input name="user_id" hidden
                                                                               value="{{$user->id}}">


                                                                    </select>


                                                                    @if($tariff_count_nepa == 0)

                                                                        <button type="submit"
                                                                                class="col-12 d-flex w-100 btn btn-primary my-3">
                                                                            Attach Tariff
                                                                        </button>

                                                                    @else

                                                                        <a href="detach-nepa-tariff?id={{$tariff_id_nepa}}" class="col-12 d-flex w-100 btn btn-danger my-3">
                                                                            Detach  Tariff
                                                                        </a>



                                                                    @endif




                                                                </div>


                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-sm-12 card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <form action="update-gen" method="post">
                                                            @csrf
                                                            <div class="row">

                                                                <h6 class="d-flex justify-content-start my-2">Tariff
                                                                    Information</h6>


                                                                <div class="col-xl-6 col-sm-12"
                                                                     style="position: relative;">

                                                                    <h6 class="mb-4">GENERATOR TARIFF <span
                                                                            class="badge text-bg-secondary">{{$gen_tariff_title   ?? "Set Tariff"}} | ID - {{$tariff_index_gen ?? " "}}</span>
                                                                    </h6>

                                                                    <select class="form-control my-3" name="tariff">

                                                                        @foreach($tariff as $data)
                                                                            <option
                                                                                value="{{$data->id}}">{{$data->title}}
                                                                                |
                                                                                ID - {{$data->tariff_index}}</option>
                                                                        @endforeach


                                                                    </select>


                                                                    <input name="user_id" hidden
                                                                           value="{{$user->id}}">


                                                                    @if($tariff_count_gen == 0)

                                                                        <button type="submit"
                                                                                class="col-12 d-flex w-100 btn btn-primary my-3">
                                                                            Attach Tariff
                                                                        </button>

                                                                    @else

                                                                        <a href="detach-gen-tariff?id={{$tariff_id_gen}}" class="col-12 d-flex w-100 btn btn-danger my-3">
                                                                            Detach  Tariff
                                                                        </a>



                                                                    @endif

                                                                </div>


                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>


                                </div>
                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end col -->



                    <div class="card">

                        <div class="card-body">


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
                @else
                @endif


            </div>
        </div>
    </div> <!-- container-fluid -->

@endsection
