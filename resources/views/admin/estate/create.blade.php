@extends('layouts.main')
@section('content')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Add New Estate</h4>
                </div>
            </div>


            <div class="row">

                <div class="card">

                    <div class="card-body">

                        <form action="estate-store" method="post">
                            @csrf

                            <div class="row">

                                <h6 class="d-flex justify-content-start my-4">Estate Information</h6>

                                <div class="col-4">
                                    <label class="my-2">Estate Name</label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>

                                <div class="col-4">
                                    <label class="my-2">State</label>
                                    <input type="text" name="state" class="form-control" required>
                                </div>

                                <div class="col-4">
                                    <label class="my-2">LGA</label>
                                    <input type="text" name="lga" class="form-control" required>
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