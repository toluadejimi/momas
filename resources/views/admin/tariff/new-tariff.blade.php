@extends('layouts.main')
@section('content')


    @if(auth::user()->role == 0)
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


                <div class="row">

                    <div class="card">

                        <div class="card-body">

                            <form action="add-new-Tariff" method="post">
                                @csrf

                                <div class="row">

                                    <h6 class="d-flex justify-content-start my-4">Tariff Information</h6>

                                    <div class="col-3">
                                        <label class="my-2">Tariff Title</label>
                                        <input type="text" value="TF" name="title" class="form-control" required>
                                        <input type="text" name="estate_id" value="{{auth::user()->estate_id}}"  hidden >
                                    </div>


                                    <hr class="my-4">


                                    <button type="submit" class="col-2 d-flex btn btn-primary">
                                        Create
                                    </button>

                                </div>


                            </form>


                        </div>


                    </div>


                </div>


            </div>


        </div> <!-- container-fluid -->
    @elseif(auth::user()->role == 1)
    @elseif(auth::user()->role == 2)
    @elseif(auth::user()->role == 3)
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


                <div class="row">

                    <div class="card">

                        <div class="card-body">

                            <form action="add-new-Tariff" method="post">
                                @csrf

                                <div class="row">

                                    <h6 class="d-flex justify-content-start my-4">Tariff Information</h6>


                                    <div class="col-3">
                                        <label class="my-2">Tariff Title</label>
                                        <input type="text" value="TF" name="title" class="form-control" required>
                                        <input type="text" name="estate_id" value="{{auth::user()->estate_id}}"  hidden >

                                    </div>


                                    <div class="col-3">
                                        <select name="type" class="form-control">

                                            <option

                                        </select>

                                    </div>

                                    <hr class="my-4">

                                    <button type="submit" class="col-2 d-flex btn btn-primary">
                                        Create Tariff
                                    </button>

                                </div>


                            </form>


                        </div>


                    </div>


                </div>


            </div>


        </div> <!-- container-fluid -->
    @elseif(auth::user()->role == 4)
    @elseif(auth::user()->role == 5)
    @else
    @endif



@endsection
