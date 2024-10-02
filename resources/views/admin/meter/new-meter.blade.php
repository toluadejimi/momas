@extends('layouts.main')
@section('content')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Add New Meter</h4>
                </div>
            </div>


            <div class="row">

                <div class="card">

                    <div class="card-body">

                        <form action="add-new-meter" method="post">
                            @csrf

                            <div class="row">

                                <h6 class="d-flex justify-content-start my-4">Meter Information</h6>


                                <div class="col-3">
                                    <label class="my-2">Meter Number</label>
                                    <input type="number" name="meterNo" class="form-control" required>
                                </div>


                                <div class="col-3">
                                    <label class="my-2">Meter Model</label>
                                    <select type="text" name="meterModel" class="form-control" required>
                                        <option value=" ">Select</option>
                                        <option value="prepaid">Prepaid</option>
                                        <option value="postpaid">Postpaid</option>
                                    </select>
                                </div>

                                <div class="col-3">
                                    <label class="my-2">Account No</label>
                                    <input type="number" name="AccountNo" class="form-control" required>
                                </div>

                                <div class="col-3">
                                    <label class="my-2">Estate</label>
                                    <select type="text" name="estate_id" class="form-control" required>
                                        <option value=" ">Select</option>
                                        @foreach($estate as $data)
                                            <option value="{{$data->id}}">{{$data->title}} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <hr class="my-4">


                                <div class="col-3">
                                    <label class="my-2">Transformer</label>
                                    <select type="text" name="TransformerID" class="form-control" required>
                                        <option value=" ">Select</option>
                                        @foreach($transformer as $data)
                                            <option value="{{$data->id}}">{{$data->Title}} </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-3 mt-4">
                                        <input  type="checkbox" id="isDualTariff" name="isDualTariff" class="form-check-input" style="border: 10px">
                                        <label class="form-check-label">Is Dual Tariff</label>

                                </div>


                                <div class="col-3"  id="newTariffDualContainer" style="display: none;">
                                    <label class="my-2">New Tariff Dual</label>
                                    <input type="text" name="NewTariffDual" class="form-control" required>
                                </div>


                                <div class="col-3" id="newSGCDualContainer" style="display: none;">
                                    <label class="my-2">New SGC Dual</label>
                                    <input type="text" name="NewSGCDual" class="form-control">
                                </div>


                                <script>
                                    document.getElementById('isDualTariff').addEventListener('change', function () {
                                        var isChecked = this.checked;
                                        document.getElementById('newTariffDualContainer').style.display = isChecked ? 'block' : 'none';
                                        document.getElementById('newSGCDualContainer').style.display = isChecked ? 'block' : 'none';
                                        document.getElementById('oldTariffDualContainer').style.display = isChecked ? 'block' : 'none';
                                        document.getElementById('oldSGCDualContainer').style.display = isChecked ? 'block' : 'none';
                                    });
                                </script>


                                <hr class="my-4">


                                <div class="col-3" id="oldSGCDualContainer" style="display: none;">
                                    <label class="my-2">Old SGC</label>
                                    <input type="text" name="OldSGC" class="form-control" required>
                                </div>

                                <div class="col-3" id="oldTariffDualContainer" style="display: none;">
                                    <label class="my-2">Old Tariff  Dual</label>
                                    <input type="text" name="OldTariffDual" class="form-control" required>
                                </div>

                                <div class="col-3">
                                    <label class="my-2">New Tariff</label>
                                    <select name="NewTariffID" class="form-control">
                                        <option value=" ">Select</option>
                                        @foreach($tariff as $data)
                                            <option value="{{$data->id}}">{{$data->title}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-3">
                                    <label class="my-2">Old Tariff</label>
                                    <select type="text" name="OldTariffID" class="form-control" required>
                                        <option value=" ">Select</option>
                                        @foreach($tariff as $data)
                                            <option value="{{$data->id}}">{{$data->title}} </option>
                                        @endforeach
                                    </select>
                                </div>




                                <hr class="my-4">



                                <div class="col-3">
                                    <label class="my-2">KRN1</label>
                                    <input type="text" value="STS" name="KRN1" class="form-control" required>
                                </div>

                                <div class="col-3">
                                    <label class="my-2">KRN2</label>
                                    <input type="text" value="STS6" name="KRN2" class="form-control" required>
                                </div>


                                <div class="col-3 mt-4">
                                    <input  type="checkbox" name="NeedKCT" class="form-check-input" style="border: 10px">
                                    <label class="form-check-label">Need KCT</label>

                                </div>


                                <div class="col-3">
                                    <label class="my-2">Credit Type</label>
                                    <select type="text" name="CreditTypeID" class="form-control" required>
                                        <option value=" ">Select</option>
                                        <option value="water">Water</option>
                                        <option value="gas">Gas</option>
                                        <option value="electricity">Electricity</option>
                                    </select>
                                </div>


                            </div>


                            <hr class="my-4">

                            <button type="submit" class="col-2 d-flex btn btn-primary">
                                Add Meter
                            </button>


                        </form>


                    </div>


                </div>


            </div>


        </div>


    </div> <!-- container-fluid -->

@endsection
