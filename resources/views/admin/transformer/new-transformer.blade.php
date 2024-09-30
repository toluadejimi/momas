@extends('layouts.main')
@section('content')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Add New Transformer</h4>
                </div>
            </div>


            <div class="row">

                <div class="card">

                    <div class="card-body">

                        <form action="add-new-transformer" method="post">
                            @csrf

                            <div class="row">

                                <h6 class="d-flex justify-content-start my-4">Transformer Information</h6>


                                <div class="col-3">
                                    <label class="my-2">Meter Title</label>
                                    <input type="text" name="Title" class="form-control" required>
                                </div>

                                <div class="col-3">
                                    <label class="my-2">Capacity</label>
                                    <input type="text" name="Capacity" class="form-control" required>
                                </div>


                                <div class="col-3">
                                    <label class="my-2">MD Meter SN</label>
                                    <input type="text" name="MDMeterSN" class="form-control" required>
                                </div>


                                <div class="col-3 mt-4">
                                    <input type="checkbox" name="Multiplier" class="form-check-input"
                                           style="border: 10px">
                                    <label class="form-check-label">Multiplier</label>

                                </div>


                                <hr class="my-4">


                                <div class="col-3">
                                    <label class="my-2">Estate</label>
                                    <select type="text" name="Estate_id" class="form-control" required>
                                        <option value=" ">Select</option>
                                        @foreach($estate as $data)
                                            <option value="{{$data->id}}">{{$data->title}} </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-3">
                                    <label class="my-2">Address</label>
                                    <input type="text" name="Location" class="form-control" required>
                                </div>


                                <div class="col-3">
                                    <label class="my-2">City</label>
                                    <input type="text" name="City" class="form-control" required>
                                </div>


                                <div class="col-3">
                                    <label class="my-2">State</label>
                                    <input type="text" name="State" class="form-control" required>
                                </div>


                                <hr class="my-4">


                                <div class="col-3">
                                    <label class="my-2">CT Ratio</label>
                                    <input type="text" name="CTRatio" class="form-control" required>
                                </div>


                                <hr class="my-4">

                                <button type="submit" class="col-2 d-flex btn btn-primary">
                                    Add Transformer
                                </button>

                            </div>


                        </form>


                    </div>


                </div>


            </div>


        </div>


    </div> <!-- container-fluid -->

@endsection
