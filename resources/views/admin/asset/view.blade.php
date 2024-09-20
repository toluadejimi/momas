@extends('layouts.main')
@section('content')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">


            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Add New Asset</h4>
                </div>
            </div>


            <div class="row">

                <div class="card">

                    <div class="card-body">

                        <form action="asset-update" method="post">
                            @csrf

                            <div class="row">

                                <h6 class="d-flex justify-content-start my-4">Asset Information</h6>

                                <div class="col-4">
                                    <label class="my-2">Asset Name</label>
                                    <input type="text" name="title" value="{{$asset->title}}" class="form-control"
                                           required>
                                    <input hidden name="id" value="{{$asset->id}}" class="form-control" required>

                                </div>

                                <div class="col-4">
                                    <label class="my-2">Organization Name</label>
                                    <select type="text" name="organization_id" class="form-control" required>
                                    <option value="{{$org->id}}}">{{$org->title}}</option>
                                    @foreach($orgs as $data)
                                        <option value="{{$data->id}}">{{$data->title}}</option>
                                    @endforeach
                                    </select>

                                </div>

                                <div class="col-4">
                                    <label class="my-2">Estate Name</label>
                                    <select type="text" name="estate_id" class="form-control" required>
                                        <option value="{{$estate->id}}}">{{$estate->title}}</option>
                                        @foreach($estates as $data)
                                            <option value="{{$data->id}}">{{$data->title}}</option>
                                        @endforeach
                                    </select>

                                </div>


                            </div>

                            <hr class="my-4">

                            <button type="submit" class="col-2 d-flex btn btn-primary">
                                Update Asset
                            </button>


                        </form>


                    </div>


                </div>


            </div>


        </div>


    </div> <!-- container-fluid -->

@endsection
