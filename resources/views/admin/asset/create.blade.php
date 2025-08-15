@extends('layouts.main')
@section('content')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Add New Assets</h4>
                </div>
            </div>


            <div class="row">

                <div class="card">

                    <div class="card-body">

                        <form action="asset-store" method="post">
                            @csrf

                            <div class="row">

                                <h6 class="d-flex justify-content-start my-4">Asset Information</h6>

                                <div class="col-4">
                                    <label class="my-2">Choose Asset</label>
                                    <select type="text" name="title" class="form-control" required>
                                        <option value=" ">Set Asset</option>
                                        <option value="Meter">Meter</option>
                                        <option value="Transformer">Transformer</option>
                                        <option value="Generator">Generator</option>

                                    </select>
                                </div>

                                <div class="col-4">
                                    <label class="my-2">Choose Organization </label>
                                    <select type="text" name="organization_id" class="form-control" required>
                                        <option value=" ">Set Organization</option>
                                        @foreach($org as $data)
                                            <option value="{{$data->id}}">{{$data->title}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label class="my-2">Choose Estate</label>
                                    <select type="text" name="estate_id" class="form-control" required>
                                        <option value=" ">Set Estate</option>
                                        @foreach($estate as $data)
                                            <option value="{{$data->id}}">{{$data->title}}</option>
                                        @endforeach
                                    </select>
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
