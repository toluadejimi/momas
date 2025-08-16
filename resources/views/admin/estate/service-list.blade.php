@extends('layouts.main')
@section('content')

    @if(Auth::user()->role == 0)

        <div class="content">
            <div class="container-fluid">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Estates Service List</h4>
                    </div>
                </div>

                {{-- Error / Success Messages --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                @if (session()->has('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- Stats --}}
                <div class="row">
                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="widget-first">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-secondary-subtle rounded-circle p-2 me-2 border border-dashed border-secondary">
                                            <svg width="20" height="17" viewBox="0 0 20 17" fill="none">
                                                <path d="M7 0h10a3 3 0 0 1 3 3v11a3 3 0 0 1-3 3H3a3 3 0 0 1-3-3V3a3 3 0 0 1 3-3z" fill="#D60574" fill-opacity="0.57"/>
                                            </svg>
                                        </div>
                                        <p class="mb-0 text-dark fs-15">Total Estates Service</p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <h3 class="mb-0 fs-24 text-black me-2">{{ $service_count }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Table --}}
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card overflow-hidden">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title text-black mb-0">Estates Service List</h5>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                       class="btn btn-primary text-white">Add new Service</a>

                                </div>
                            </div>

                            <div class="card-body">
                                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap">
                                    <thead>
                                    <tr>
                                        <th>Profession</th>
                                        <th>Estate</th>
                                        <th>Full Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($services as $data)
                                        <tr>
                                            <td><a href="view-service?id={{$data->id}}">{{$data->service_title}}</a></td>
                                            <td>{{ $data->estate->title }}</td>
                                            <td>{{ $data->professional_name }}</td>
                                            <td><a href="tel:{{$data->professional_phone}}">{{ $data->professional_phone }}</a></td>
                                            <td>{{ $data->professional_email }}</td>
                                            <td>
                                                @if($data->status == 2)
                                                    <span class="badge bg-primary">Active</span>
                                                @elseif($data->status == 0)
                                                    <span class="badge bg-warning">Inactive</span>
                                                @elseif($data->status == 3)
                                                    <span class="badge bg-danger">Blocked</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="service-delete?id={{$data->id}}" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger">Delete</a>
                                            </td>
                                            <td>
                                                @if($data->status == 2)
                                                    <a href="service-deactivate?id={{$data->id}}" onclick="return confirm('Are you sure you want to deactivate this Service?');" class="btn btn-warning">Deactivate</a>
                                                @else
                                                    <a href="service-activate?id={{$data->id}}" onclick="return confirm('Are you sure you want to activate this Service?');" class="btn btn-primary">Activate</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    {{ $services->links() }}
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card overflow-hidden">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title text-black mb-0">Profession Service List</h5>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop2"
                                       class="btn btn-primary text-white">Add new Profession</a>
                                </div>
                            </div>

                            <div class="card-body">
                                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap">
                                    <thead>
                                    <tr>
                                        <th>Profession Title</th>
                                        <th>Status</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($prof_service as $data)
                                        <tr>
                                            <td><a href="view-service?id={{$data->id}}">{{$data->service_title}}</a></td>

                                            <td>
                                                @if($data->status == 2)
                                                    <span class="badge bg-primary">Active</span>
                                                @elseif($data->status == 0)
                                                    <span class="badge bg-warning">Inactive</span>
                                                @elseif($data->status == 3)
                                                    <span class="badge bg-danger">Blocked</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="profession-delete?id={{$data->id}}" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger">Delete</a>
                                            </td>
                                            <td>
                                                @if($data->status == 2)
                                                    <a href="profession-deactivate?id={{$data->id}}" onclick="return confirm('Are you sure you want to deactivate this Service?');" class="btn btn-warning">Deactivate</a>
                                                @else
                                                    <a href="profession-activate?id={{$data->id}}" onclick="return confirm('Are you sure you want to activate this Service?');" class="btn btn-primary">Activate</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    {{ $prof_service->links() }}
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal --}}
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="add-new-service-list" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Add New Service</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label class="my-2">Select Estate</label>
                                    <select class="form-control mb-3" name="service" required>
                                        <option value="" disabled selected>Select a Estate</option>
                                        @foreach($estate as $data)
                                            <option value="{{ $data->id }}">{{ $data->title }}</option>
                                        @endforeach
                                    </select>

                                    <label class="my-2">Select Service</label>
                                    <select class="form-control mb-3" name="service" required>
                                        <option value="" disabled selected>Select a job</option>
                                        @foreach($prof_services as $data)
                                            <option value="{{ $data->id }}">{{ $data->service_title }}</option>
                                        @endforeach
                                    </select>
                                    <label class="my-2">Full Name</label>
                                    <input type="text" class="form-control mb-3" name="professional_name" placeholder="Surname Lastname" required>
                                    <div class="row">
                                        <div class="col">
                                            <label class="my-2">Email</label>
                                            <input type="email" class="form-control mb-3" name="professional_email">
                                            <input type="hidden" value="{{ $estate_id }}" name="estate_id">
                                        </div>
                                        <div class="col">
                                            <label class="my-2">Phone No</label>
                                            <input type="number" class="form-control mb-3" name="professional_phone" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false"
                     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="add-new-proffession" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Add New Profession</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <label class="my-2">Profession Title</label>
                                    <input type="text" class="form-control mb-3" name="title" placeholder="Enter Title" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    @endif

@endsection
