@extends('layouts.main')
@section('content')

    @if(auth::user()->role == 0)
        <div class="content">
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
                                        <input type="text" name="flutterwave_secret" class="form-control"
                                               value="{{$set->flutterwave_secret}}">

                                    </div>

                                    <div class="col-6">
                                        <label class="my-2">Flutterwave Public</label>
                                        <input type="text" name="flutterwave_public" class="form-control"
                                               value="{{$set->flutterwave_public}}">

                                    </div>

                                    <div class="col-6">
                                        <label class="my-2">Paystack Secret</label>
                                        <input type="text" name="paystack_secret" class="form-control"
                                               value="{{$set->paystack_secret}}">

                                    </div>

                                    <div class="col-6">
                                        <label class="my-2">Paystack Public</label>
                                        <input type="text" name="paystack_public" class="form-control"
                                               value="{{$set->paystack_public}}">

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
                                        <input type="text" name="payment_support" class="form-control"
                                               value="{{$set->payment_support}}">

                                    </div>

                                    <div class="col-6">
                                        <label class="my-2">Meter Support</label>
                                        <input type="text" name="meter_support" class="form-control"
                                               value="{{$set->meter_support}}">

                                    </div>

                                    <div class="col-6">
                                        <label class="my-2">General Support</label>
                                        <input type="text" name="general_support" class="form-control"
                                               value="{{$set->general_support}}">

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

                                <div class="card">

                                    <div class="card-body">

                                        <form action="estate-update-info" method="post">
                                            @csrf

                                            <div class="row">

                                                <h6 class="d-flex justify-content-start my-4">Estate Information</h6>

                                                <div class="col-4">
                                                    <label class="my-2">Estate Name</label>
                                                    <input type="text" readonly name="title" value="{{$org->title}}"
                                                           class="form-control"
                                                           required>
                                                    <input hidden name="id" value="{{$org->id}}" class="form-control"
                                                           required>

                                                </div>

                                                <div class="col-4">
                                                    <label class="my-2">State</label>
                                                    <input type="text" name="state" value="{{$org->state}}"
                                                           class="form-control"
                                                           required>

                                                </div>

                                                <div class="col-4">
                                                    <label class="my-2">City</label>
                                                    <input type="text" name="city" value="{{$org->city}}"
                                                           class="form-control"
                                                           required>

                                                </div>

                                                <div class="col-4">
                                                    <label class="my-2">LGA</label>
                                                    <input type="text" name="lga" value="{{$org->lga}}"
                                                           class="form-control"
                                                           required>

                                                </div>

                                                <div class="col-3">
                                                    <label class="my-2">Status</label>
                                                    @if($org->status == 2)
                                                        <input type="text" readonly  value="Active" class="form-control" required>
                                                    @else
                                                        <input type="text" readonly  value="Inactive" class="form-control" required>
                                                    @endif


                                                </div>

                                            </div>

                                            <hr class="my-4">

                                            <button type="submit" class="col-2 d-flex btn btn-primary">
                                                Update Info
                                            </button>


                                        </form>

                                    </div>


                                </div>




                            </div>


                            <div class="row">

                                <div class="card" style="background: #d1fff1">

                                    <div class="card-body">


                                        <div class="d-flex justify-content-between my-4">
                                            <h6 class="">Utilities Information</h6>
                                            <h6 class="mb-0">Total Utilities <span
                                                    class="badge text-bg-secondary">NGN {{number_format($total_utility, 2)}}</span>
                                            </h6>

                                            @if($utl != null)
                                                @if($utl->duration != null)
                                                    <h6 class="mb-0">Duration <span
                                                            class="badge text-bg-danger">{{strtoupper($utl->duration)}}</span>
                                                    </h6>
                                                @else
                                                    <h6 class="mb-0">Duration <span class="badge text-bg-secondary">Set Duration</span>
                                                    </h6>
                                                @endif

                                            @else


                                            @endif
                                        </div>


                                        <hr class="my-2">


                                        @if($utility != null)

                                            <h6 class="my-3">Available Utilities</h6>

                                            @foreach($utility as $index => $data)

                                                <form action="update-utility" method="get" class="row">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$data->id}}"
                                                           required>
                                                    <div class="col-xl-4 col-sm-12 my-1">
                                                        <label class="my-1">Utility</label>
                                                        <input type="text" name="title" id="title_{{$index}}"
                                                               class="form-control" value="{{$data->title}}"
                                                               required>
                                                    </div>

                                                    <div class="col-xl-4 col-sm-12 my-1">
                                                        <label class="my-1">Amount</label>
                                                        <input type="text" name="amount" id="amount_{{$index}}"
                                                               class="form-control" value="{{$data->amount}}"
                                                               required>
                                                    </div>

                                                    <div class="col-xl-4 col-sm-12 my-4">
                                                        <button type="submit" class="btn btn-primary">Update
                                                        </button>
                                                        <a href="delete-utility?id={{$data->id}}"
                                                           class="btn btn-danger"
                                                           onsubmit="return confirmDelete();"> Delete</a>

                                                    </div>
                                                    <script>

                                                        function confirmDelete() {
                                                            return confirm('Are you sure you want to delete this item?');
                                                        }
                                                    </script>
                                                </form>

                                            @endforeach

                                        @else
                                            <p>No utilities available.</p>
                                        @endif


                                        <hr class="my-2">


                                        <form id="utility-form" action="estate-update-utilities" method="post">
                                            @csrf

                                            <div class="row">


                                                <div class="col-6 mb-3">
                                                <h6 class="my-3">Add New Utility</h6>

                                                <label class="my-2">Set Duration</label>
                                                <select name="duration" required class="form-control">
                                                    <option value=" ">Choose Duration</option>
                                                    <option value="weekly">Weekly</option>
                                                    <option value="monthly">Monthly</option>
                                                    <option value="yearly">Yearly</option>

                                                </select>
                                                </div>

                                                <!-- Container to hold dynamic fields -->
                                                <div id="utility-fields"></div>

                                                <!-- Add more button -->
                                                <div class="col-12 my-4">
                                                    <button type="button" class="btn btn-success" id="add-more">
                                                        Add Utility
                                                    </button>
                                                </div>

                                                <!-- Hidden template for the new fields -->
                                                <div id="template" class="d-none">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <label class="my-2">Title</label>
                                                            <input type="text" name="title[]"
                                                                   class="form-control"
                                                                   required>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="my-2">Amount</label>
                                                            <input type="text" name="amount[]"
                                                                   class="form-control"
                                                                   required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Hidden input to hold all the utilities data -->
                                                <input type="hidden" id="utilities-data" name="utilities_data">

                                                <hr class="my-4">

                                                <!-- Save Button to submit the form -->
                                                <button style="width: 200px" type="button"
                                                        class="btn btn-primary w-40" id="save">Save Utility
                                                </button>
                                            </div>
                                        </form>

                                        <!-- JavaScript to handle adding fields and saving the data -->
                                        <script>
                                            let utilities = [];

                                            // Add More functionality
                                            document.getElementById('add-more').addEventListener('click', function () {
                                                // Clone the template
                                                var template = document.getElementById('template').cloneNode(true);
                                                template.classList.remove('d-none');
                                                template.removeAttribute('id');

                                                // Append the cloned fields to the utility fields container
                                                document.getElementById('utility-fields').appendChild(template);
                                            });

                                            // Save functionality
                                            document.getElementById('save').addEventListener('click', function () {
                                                // Get all the dynamic fields
                                                let titles = document.querySelectorAll('input[name="title[]"]');
                                                let amounts = document.querySelectorAll('input[name="amount[]"]');

                                                // Clear the previous utilities data
                                                utilities = [];

                                                // Loop through each input and store the data in an array
                                                for (let i = 0; i < titles.length; i++) {
                                                    utilities.push({
                                                        title: titles[i].value,
                                                        amount: amounts[i].value
                                                    });
                                                }

                                                // Check the result in the console
                                                console.log("Utilities Data: ", utilities);

                                                // Save the data in a hidden input as a JSON string
                                                document.getElementById('utilities-data').value = JSON.stringify(utilities);

                                                // Debugging: Check if the hidden input is being populated
                                                console.log("Hidden Input Value: ", document.getElementById('utilities-data').value);

                                                // Now submit the form after setting the value
                                                document.getElementById('utility-form').submit();
                                            });
                                        </script>


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
