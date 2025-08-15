@extends('layouts.main')
@section('content')





    @if(Auth::user()->role == 0)
        <div class="content">
            <div class="container-fluid">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">{{$title}}</h4>
                    </div>
                </div>

                <!-- start row -->
                <div class="row">
                    <div class="col-md-12 col-xl-4">
                        <div class="row g-3">

                            <div class="col-md-6 col-xl-6">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="fs-16 mb-1">Total Users</div>
                                        </div>

                                        <div class="d-flex align-items-baseline mb-2">
                                            <div
                                                class="fs-22 mb-0 me-2 fw-semibold text-black">{{$users}}</div>
                                            <div class="me-auto">
                                            </div>
                                        </div>

                                        {{--                                    <div id="website-traffic" class="apex-charts"></div>--}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-6">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="fs-16 mb-1">Total Meter</div>
                                        </div>

                                        <div class="d-flex align-items-baseline mb-2">
                                            <div
                                                class="fs-22 mb-0 me-2 fw-semibold text-black">{{$meter}}</div>
                                        </div>
                                        {{--                                    <div id="conversion-visitors" class="apex-charts"></div>--}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-6">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="fs-16 mb-1">Total Estate</div>
                                        </div>

                                        <div class="d-flex align-items-baseline mb-2">
                                            <div
                                                class="fs-22 mb-0 me-2 fw-semibold text-black">{{$estate}}</div>
                                            <div class="me-auto">
                                            </div>
                                        </div>

                                        {{--                                    <div id="website-traffic" class="apex-charts"></div>--}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-6">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="fs-16 mb-1">Estate Token</div>
                                        </div>

                                        <div class="d-flex align-items-baseline mb-2">
                                            <div
                                                class="fs-22 mb-0 me-2 fw-semibold text-black">{{$token}}</div>
                                        </div>
                                        {{--                                    <div id="conversion-visitors" class="apex-charts"></div>--}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-6">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="fs-16 mb-1">Meter Token</div>
                                        </div>

                                        <div class="d-flex align-items-baseline mb-2">
                                            <div
                                                class="fs-22 mb-0 me-2 fw-semibold text-black">{{$meter_token}}</div>
                                        </div>
                                        {{--                                    <div id="conversion-visitors" class="apex-charts"></div>--}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-6">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="fs-16 mb-1">Estate Token</div>
                                        </div>

                                        <div class="d-flex align-items-baseline mb-2">
                                            <div
                                                class="fs-22 mb-0 me-2 fw-semibold text-black">{{$token}}</div>
                                        </div>
                                        {{--                                    <div id="conversion-visitors" class="apex-charts"></div>--}}
                                    </div>
                                </div>
                            </div>


                            {{--                        <div class="col-md-12 col-xl-12">--}}
                            {{--                            <div class="card">--}}
                            {{--                                <div class="card-body">--}}
                            {{--                                    <div class="d-flex align-items-center">--}}
                            {{--                                        <div class="fs-16 mb-1">Total Transaction</div>--}}
                            {{--                                    </div>--}}

                            {{--                                    <div class="d-flex align-items-baseline mb-2">--}}
                            {{--                                        <div class="fs-22 mb-0 me-2 fw-semibold text-black">NGN{{number_format($total_in, 2)}}</div>--}}
                            {{--                                    </div>--}}

                            {{--                                    <div id="average-daily-sales" class="apex-charts"></div>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            {{--                        </div>--}}


                        </div>
                    </div> <!-- end sales -->

                    <!-- Start Earning Reports -->
                    <div class="col-md-12 col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title text-black mb-0">Earning Reports</h5>
                                </div>
                            </div>

                            <div class="card-body">
                                <!-- Earning reports Chart -->
                                <div id="monthly-sales" class="apex-charts"></div>

                            </div>
                        </div>
                    </div>
                </div> <!-- end row -->


                <div class="row">
                    <div class="col-xl-12">
                        <div class="card overflow-hidden">

                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <h5 class="card-title text-black mb-0">Latest Transaction</h5>
                                </div>
                            </div>

                            <div class="card-body mt-0">
                                <div class="table-responsive table-card mt-0">
                                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                        <thead class="text-muted table-light">
                                        <tr>
                                            <th scope="col" class="cursor-pointer">Transaction ID</th>
                                            <th scope="col" class="cursor-pointer">User</th>
                                            <th scope="col" class="cursor-pointer">Trx Type</th>
                                            <th scope="col" class="cursor-pointer">Amount</th>
                                            <th scope="col" class="cursor-pointer">Status</th>
                                            <th scope="col" class="cursor-pointer desc">Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        @foreach($transaction as $data)

                                            <tr>
                                                <td>{{$data->trx_id}}</td>
                                                <td>{{$data->user->first_name ?? null}} {{$data->user->last_name ?? null}}</td>
                                                <td>
                                                    @if($data->service_type == "meter_token")
                                                        <span class="badge text-bg-dark">Meter Token</span>
                                                    @elseif($data->service_type == "airtime")
                                                        <span class="badge text-bg-dark">Airtime</span>
                                                    @elseif($data->service_type == "data")
                                                        <span class="badge text-bg-dark">Data</span>
                                                    @endif
                                                </td>
                                                <td>{{number_format($data->amount, 2)}}</td>
                                                <td>
                                                    @if($data->status == 2)
                                                        <span class="badge text-bg-primary">Completed</span>
                                                    @elseif($data->status == 3)
                                                        <span class="badge text-bg-dark">Reversed</span>
                                                    @elseif($data->status == 1)
                                                        <span class="badge text-bg-warning">Pending</span>
                                                    @elseif($data->status == 0)
                                                        <span class="badge text-bg-warning">initiated</span>
                                                    @elseif($data->status == 4)
                                                        <span class="badge text-bg-secondary">Payment Completed</span>
                                                    @else
                                                        <span class="badge text-bg-danger">Failed</span>
                                                    @endif

                                                </td>
                                                <td>{{$data->created_at}}</td>

                                            </tr>

                                        @endforeach


                                        </tbody><!-- end tbody -->

                                        <tfoot>

                                        {{ $transaction->links() }}


                                        </tfoot>
                                    </table><!-- end table -->
                                </div>
                            </div>

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

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">{{$title}}</h4>
                    </div>
                </div>

                <!-- start row -->
                <div class="row">
                    <div class="col-md-12 col-xl-12">
                        <div class="row g-3">

                            <div class="col-md-6 col-xl-6">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="fs-16 mb-1">Total Users</div>
                                        </div>

                                        <div class="d-flex align-items-baseline mb-2">
                                            <div
                                                class="fs-22 mb-0 me-2 fw-semibold text-black">{{$users}}</div>
                                            <div class="me-auto">
                                            </div>
                                        </div>

                                        {{--                                    <div id="website-traffic" class="apex-charts"></div>--}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-6">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="fs-16 mb-1">Total Customer</div>
                                        </div>

                                        <div class="d-flex align-items-baseline mb-2">
                                            <div
                                                class="fs-22 mb-0 me-2 fw-semibold text-black">{{$customers}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6 col-xl-6">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="fs-16 mb-1">Estate Meter</div>
                                        </div>

                                        <div class="d-flex align-items-baseline mb-2">
                                            <div
                                                class="fs-22 mb-0 me-2 fw-semibold text-black">{{$meter}}</div>
                                        </div>
                                        {{--                                    <div id="conversion-visitors" class="apex-charts"></div>--}}
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6 col-xl-6">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="fs-16 mb-1">Estate Token</div>
                                        </div>

                                        <div class="d-flex align-items-baseline mb-2">
                                            <div
                                                class="fs-22 mb-0 me-2 fw-semibold text-black">{{$token}}</div>
                                        </div>
                                        {{--                                    <div id="conversion-visitors" class="apex-charts"></div>--}}
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div> <!-- end sales -->

                    <!-- Start Earning Reports -->
                </div> <!-- end row -->



            </div> <!-- container-fluid -->
        </div> <!-- content -->
    @elseif(Auth::user()->role == 4)
    @elseif(Auth::user()->role == 5)
    @else
    @endif



@endsection
