@extends('layouts.main')
@section('content')



    @if(Auth::user()->role == 0)

        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">


                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Users List</h4>
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

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="widget-first">

                                    <div class="d-flex align-items-center mb-2">
                                        <div
                                            class="bg-secondary-subtle rounded-circle p-2 me-2 border border-dashed border-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                 viewBox="0 0 640 512">
                                                <path fill="#963b68"
                                                      d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64m448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64m32 32h-64c-17.6 0-33.5 7.1-45.1 18.6c40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64m-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32S208 82.1 208 144s50.1 112 112 112m76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2m-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4"/>
                                            </svg>
                                        </div>

                                        <p class="mb-0 text-dark fs-15">Total Users</p>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <h3 class="mb-0 fs-24 text-black me-2">{{number_format($users)}}</h3>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>


                <div class="row">
                    <div class="col-xl-12">
                        <div class="card overflow-hidden">

                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title text-black mb-0">Latest Transaction</h5>

                                    @if(Auth::user()->role == 0)
                                        <a href="new-user" class="btn btn-primary text-white justify-content-end">Add new</a>
                                    @else
                                    @endif



                                </div>


                            </div>

                            <div class="card-body">
                                <table id="datatable-buttons"
                                       class="table table-striped table-bordered dt-responsive nowrap">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="cursor-pointer">First Name</th>
                                        <th scope="col" class="cursor-pointer">Last Name</th>
                                        <th scope="col" class="cursor-pointer">Phone</th>
                                        <th scope="col" class="cursor-pointer">Email</th>
                                        <th scope="col" class="cursor-pointer">Role</th>
                                        <th scope="col" class="cursor-pointer">Designation</th>
                                        <th scope="col" class="cursor-pointer">Status</th>
                                        <th scope="col" class="cursor-pointer desc">Date Registered</th>
                                        @if(Auth::user()->role == 0)
                                            <th scope="col" class="cursor-pointer desc">Action</th>
                                        @endif

                                        <th scope="col" class="cursor-pointer desc">Action</th>


                                    </tr>
                                    </thead>
                                    <tbody>


                                    @foreach($users_lists as $data)

                                        <tr>
                                            <td><a href="view-user?id={{$data->id}}">{{$data->first_name}}</a></td>
                                            <td><a href="view-user?id={{$data->id}}">{{$data->last_name}}</a></td>
                                            <td>{{$data->phone}}</td>
                                            <td>{{$data->email}}</td>
                                            <td>
                                                @if($data->role == 2)
                                                    <span class="badge text-bg-primary">Customer</span>
                                                @elseif($data->role == 3)
                                                    <span class="badge text-bg-dark">Estate Admin</span>
                                                @elseif($data->role == 0)
                                                    <span class="badge text-bg-dark">Super Admin</span>
                                                @elseif($data->role == 1)
                                                    <span class="badge text-bg-dark"> Admin</span>
                                                @elseif($data->role == 4)
                                                    <span class="badge text-bg-warning">Estate Staff</span>
                                                @endif

                                            </td>
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

                                            @if(Auth::user()->role == 0)
                                                <td><a href="user-delete?id={{$data->id}}" onclick="return confirmDelete();" class="btn btn-danger">Delete</a>

                                                    <script>
                                                        function confirmDelete() {
                                                            return confirm('Are you sure you want to delete this item?');
                                                        }
                                                    </script>
                                                </td>
                                            @endif

                                            @if($data->status == 2)
                                                <td><a href="user-deactivate?id={{$data->id}}"  onclick="return confirmupdate();" class="btn btn-warning">Deactivate User</a>

                                                    <script>
                                                        function confirmupdate() {
                                                            return confirm('Are you sure you want to deactivate this user?');
                                                        }
                                                    </script>



                                                </td>
                                            @else

                                                <td><a href="user-activate?id={{$data->id}}"  onclick="return confirmupdate();" class="btn btn-primary">Activate User</a>

                                                    <script>
                                                        function confirmupdate() {
                                                            return confirm('Are you sure you want to activate this user?');
                                                        }
                                                    </script>



                                                </td>
                                            @endif

                                        </tr>

                                    @endforeach


                                    </tbody><!-- end tbody -->

                                    <tfoot>

                                    {{ $users_lists->links() }}


                                    </tfoot>
                                </table><!-- end table -->
                            </div>
                        </div>

                    </div>
                </div>


            </div>


        </div> <!-- container-fluid -->



    @elseif(Auth::user()->role == 1)
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">


                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Users List</h4>
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

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="widget-first">

                                    <div class="d-flex align-items-center mb-2">
                                        <div
                                            class="bg-secondary-subtle rounded-circle p-2 me-2 border border-dashed border-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                 viewBox="0 0 640 512">
                                                <path fill="#963b68"
                                                      d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64m448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64m32 32h-64c-17.6 0-33.5 7.1-45.1 18.6c40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64m-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32S208 82.1 208 144s50.1 112 112 112m76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2m-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4"/>
                                            </svg>
                                        </div>

                                        <p class="mb-0 text-dark fs-15">Total Users</p>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <h3 class="mb-0 fs-24 text-black me-2">{{number_format($users)}}</h3>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>


                <div class="row">
                    <div class="col-xl-12">
                        <div class="card overflow-hidden">

                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title text-black mb-0">Latest Transaction</h5>

                                    @if(Auth::user()->role == 0)
                                        <a href="new-user" class="btn btn-primary text-white justify-content-end">Add new</a>
                                    @else
                                    @endif



                                </div>


                            </div>

                            <div class="card-body">
                                <table id="datatable-buttons"
                                       class="table table-striped table-bordered dt-responsive nowrap">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="cursor-pointer">First Name</th>
                                        <th scope="col" class="cursor-pointer">Last Name</th>
                                        <th scope="col" class="cursor-pointer">Phone</th>
                                        <th scope="col" class="cursor-pointer">Email</th>
                                        <th scope="col" class="cursor-pointer">Role</th>
                                        <th scope="col" class="cursor-pointer">Type</th>
                                        <th scope="col" class="cursor-pointer">Status</th>
                                        <th scope="col" class="cursor-pointer desc">Date Registered</th>
                                        @if(Auth::user()->role == 0)
                                            <th scope="col" class="cursor-pointer desc">Action</th>
                                        @endif

                                    </tr>
                                    </thead>
                                    <tbody>


                                    @foreach($users_lists as $data)

                                        <tr>
                                            <td><a href="view-user?id={{$data->id}}">{{$data->first_name}}</a></td>
                                            <td><a href="view-user?id={{$data->id}}">{{$data->last_name}}</a></td>
                                            <td>{{$data->phone}}</td>
                                            <td>{{$data->email}}</td>
                                            <td>
                                                @if($data->role == 2)
                                                    <span class="badge text-bg-primary">Customer</span>
                                                @elseif($data->role == 3)
                                                    <span class="badge text-bg-dark">Estate Admin</span>
                                                @elseif($data->role == 0)
                                                    <span class="badge text-bg-dark">Super Admin</span>
                                                @elseif($data->role == 1)
                                                    <span class="badge text-bg-dark"> Admin</span>
                                                @elseif($data->role == 4)
                                                    <span class="badge text-bg-warning">Estate Staff</span>
                                                @endif

                                            </td>
                                            <td>{{$data->meterType}}</td>
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

                                            @if(Auth::user()->role == 0)
                                                <td><a href="user-delete?id={{$data->id}}" onclick="return confirmDelete();" class="btn btn-danger">Delete</a>

                                                    <script>
                                                        function confirmDelete() {
                                                            return confirm('Are you sure you want to delete this item?');
                                                        }
                                                    </script>
                                                </td>
                                            @endif

                                        </tr>

                                    @endforeach


                                    </tbody><!-- end tbody -->

                                    <tfoot>

                                    {{ $users_lists->links() }}


                                    </tfoot>
                                </table><!-- end table -->
                            </div>
                        </div>

                    </div>
                </div>


            </div>


        </div> <!-- container-fluid -->
    @elseif(Auth::user()->role == 2)
    @elseif(Auth::user()->role == 3)
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">


                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Users List</h4>
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

                    <div class="col-md-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="widget-first">

                                    <div class="d-flex align-items-center mb-2">
                                        <div
                                            class="bg-secondary-subtle rounded-circle p-2 me-2 border border-dashed border-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                 viewBox="0 0 640 512">
                                                <path fill="#963b68"
                                                      d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64m448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64m32 32h-64c-17.6 0-33.5 7.1-45.1 18.6c40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64m-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32S208 82.1 208 144s50.1 112 112 112m76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2m-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4"/>
                                            </svg>
                                        </div>

                                        <p class="mb-0 text-dark fs-15">Total Users</p>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <h3 class="mb-0 fs-24 text-black me-2">{{number_format($users)}}</h3>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>


                <div class="row">
                    <div class="col-xl-12">
                        <div class="card overflow-hidden">

                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title text-black mb-0">Latest Transaction</h5>

                                    @if(Auth::user()->role == 0)
                                        <a href="new-user" class="btn btn-primary text-white justify-content-end">Add new</a>
                                    @else
                                    @endif



                                </div>


                            </div>

                            <div class="card-body">
                                <table id="datatable-buttons"
                                       class="table table-striped table-bordered dt-responsive nowrap">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="cursor-pointer">First Name</th>
                                        <th scope="col" class="cursor-pointer">Last Name</th>
                                        <th scope="col" class="cursor-pointer">Phone</th>
                                        <th scope="col" class="cursor-pointer">Email</th>
                                        <th scope="col" class="cursor-pointer">Role</th>
                                        <th scope="col" class="cursor-pointer">Designation</th>
                                        <th scope="col" class="cursor-pointer">Status</th>
                                        <th scope="col" class="cursor-pointer desc">Date Registered</th>
                                        @if(Auth::user()->role == 3)
                                            <th scope="col" class="cursor-pointer desc">Action</th>
                                        @endif

                                        <th scope="col" class="cursor-pointer desc">Action</th>


                                    </tr>
                                    </thead>
                                    <tbody>


                                    @foreach($users_lists as $data)

                                        <tr>
                                            <td><a href="view-user?id={{$data->id}}">{{$data->first_name}}</a></td>
                                            <td><a href="view-user?id={{$data->id}}">{{$data->last_name}}</a></td>
                                            <td>{{$data->phone}}</td>
                                            <td>{{$data->email}}</td>
                                            <td>
                                                @if($data->role == 2)
                                                    <span class="badge text-bg-primary">Customer</span>
                                                @elseif($data->role == 3)
                                                    <span class="badge text-bg-dark">Estate Admin</span>
                                                @elseif($data->role == 0)
                                                    <span class="badge text-bg-dark">Super Admin</span>
                                                @elseif($data->role == 1)
                                                    <span class="badge text-bg-dark"> Admin</span>
                                                @elseif($data->role == 4)
                                                    <span class="badge text-bg-warning">Estate Staff</span>
                                                @endif

                                            </td>
                                            <td>{{$data->desgination}}</td>
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

                                            @if(Auth::user()->role == 3)
                                                <td><a href="user-delete?id={{$data->id}}" onclick="return confirmDelete();" class="btn btn-danger">Delete</a>

                                                    <script>
                                                        function confirmDelete() {
                                                            return confirm('Are you sure you want to delete this item?');
                                                        }
                                                    </script>
                                                </td>
                                            @endif

                                            @if($data->status == 2)
                                                <td><a href="user-deactivate?id={{$data->id}}"  onclick="return confirmupdate();" class="btn btn-warning">Deactivate User</a>

                                                    <script>
                                                        function confirmupdate() {
                                                            return confirm('Are you sure you want to deactivate this user?');
                                                        }
                                                    </script>



                                                </td>
                                            @else

                                                <td><a href="user-activate?id={{$data->id}}"  onclick="return confirmupdate();" class="btn btn-primary">Activate User</a>

                                                    <script>
                                                        function confirmupdate() {
                                                            return confirm('Are you sure you want to activate this user?');
                                                        }
                                                    </script>



                                                </td>
                                            @endif

                                        </tr>

                                    @endforeach


                                    </tbody><!-- end tbody -->

                                    <tfoot>

                                    {{ $users_lists->links() }}


                                    </tfoot>
                                </table><!-- end table -->
                            </div>
                        </div>

                    </div>
                </div>


            </div>


        </div> <!-- container-fluid -->
    @elseif(Auth::user()->role == 4)
    @elseif(Auth::user()->role == 5)
    @else
    @endif


@endsection
