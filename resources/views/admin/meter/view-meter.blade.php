@extends('layouts.main')
@section('content')

    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">{{$meter->meterNo}}</h4>
                </div>
            </div>


            <div class="row">

                <div class="card">

                    <div class="card-body">

                        <form action="update-meter-info" method="post">
                            @csrf

                            <div class="row">

                                <h6 class="d-flex justify-content-start my-4">Meter Information</h6>
                                <div class="col-3">
                                    <label class="my-2">Meter Number</label>
                                    <input type="number" disabled name="meterNo" value="{{$meter->meterNo}}"
                                           class="form-control"
                                           required>
                                    <input type="text" name="id" value="{{$meter->id}}"
                                           hidden >

                                </div>


                                <div class="col-3">
                                    <label class="my-2">Meter Model</label>
                                    <select type="text" name="meterModel" class="form-control" required>
                                        <option
                                            value="{{$meter->meterModel}}">{{strtoupper($meter->meterModel)}}</option>
                                        <option value="prepaid">Prepaid</option>
                                        <option value="postpaid">Postpaid</option>
                                    </select>
                                </div>

                                <div class="col-3">
                                    <label class="my-2">Account No</label>
                                    <input type="text" name="AccountNo" value="{{$meter->AccountNo}}"
                                           class="form-control" required>
                                </div>

                                <div class="col-3">
                                    <label class="my-2">Estate</label>
                                    <select type="text" name="estate_id" class="form-control" required>
                                        <option
                                            value="{{$meter->estate_id}}">{{strtoupper($meter->estate->title)}}</option>
                                        @foreach($estate as $data)
                                            <option value="{{$data->id}}">{{$data->title}} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <hr class="my-4">



                                <div class="col-3">
                                    <label class="my-2">Transformer</label>
                                    <select type="text" name="TransformerID" class="form-control" required>
                                        <option value="{{$meter->TransformerID}}">{{strtoupper($trans_title)}}</option>
                                        @foreach($transformer as $data)
                                            <option value="{{$data->id}}">{{$data->Title}} </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-3 mt-4">
                                    <input  type="checkbox" id="isDualTariff" name="isDualTariff" class="form-check-input" style="border: 10px">
                                    <label class="form-check-label">Is Dual Tariff</label>

                                </div>

                                <div class="col-3">
                                    <label class="my-2">Old SGC</label>
                                    <input type="text" value="{{$meter->OldSGC}}" name="OldSGC" class="form-control" required>
                                </div>

                                <div class="col-3">
                                    <label class="my-2">New SGC</label>
                                    <input type="text" value="{{$meter->NewSGC}}" name="NewSGC" class="form-control" required>
                                </div>




                                <script>
                                    document.getElementById('isDualTariff').addEventListener('change', function () {
                                        var isChecked = this.checked;
                                        document.getElementById('newtar').style.display = isChecked ? 'block' : 'none';
                                        document.getElementById('newTariffDualContainer').style.display = isChecked ? 'block' : 'none';
                                        document.getElementById('newSGCDualContainer').style.display = isChecked ? 'block' : 'none';
                                        document.getElementById('oldTariffDualContainer').style.display = isChecked ? 'block' : 'none';
                                        document.getElementById('oldSGCDualContainer').style.display = isChecked ? 'block' : 'none';


                                    });
                                </script>


                                <hr class="my-4">



                                <div class="col-2" id="oldTariffDualContainer" style="display: none;">
                                    <label class="my-2">Old Tariff Dual</label>
                                    <select name="OldTariffDual" class="form-control">
                                        <option value="{{$meter->OldTariffDual}}">{{strtoupper($meter->OldTariffDual)}}</option>
                                        @foreach($tariffdual as $data)
                                            <option value="{{$data->OldTariffDual}}">{{$data->title}}</option>
                                        @endforeach
                                    </select>


                                </div>


                                <div class="col-2" id="newtar" style="display: none;">
                                    <label class="my-2">New Tariff Dual</label>
                                    <select name="NewTariffDual" class="form-control">
                                        <option value="{{$meter->NewTariffDual}}">{{strtoupper($meter->NewTariffDual)}}</option>
                                        @foreach($tariffdual as $data)
                                            <option value="{{$data->NewTariffDual}}">{{$data->title}}</option>
                                        @endforeach
                                    </select>

                                </div>



                                <div class="col-2">
                                    <label class="my-2">New Tariff</label>
                                    <select name="NewTariffID" class="form-control">
                                        <option value="{{$meter->NewTariffID}}">{{strtoupper($NewTariffID)}}</option>
                                        @foreach($tariff as $data)
                                            <option value="{{$data->id}}">{{$data->title}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-2">
                                    <label class="my-2">Old Tariff</label>
                                    <select type="text" name="OldTariffID" class="form-control" required>
                                        <option value="{{$meter->OldTariffID}}">{{strtoupper($OldTariffID)}}</option>
                                        @foreach($tariff as $data)
                                            <option value="{{$data->id}}">{{$data->title}} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-2 "  id="newTariffDualContainer" style="display: none;">
                                    <label class="my-2">New SGC Dual</label>
                                    <input type="text" value="{{$meter->NewSGCDual}}" name="NewSGCDual" class="form-control" >
                                </div>


                                <div class="col-2 " id="newSGCDualContainer" style="display: none;">
                                    <label class="my-2">OLD SGC Dual</label>
                                    <input type="text"  value="{{$meter->OldSGCDual}}" name="OldSGCDual" class="form-control">
                                </div>




































                                @if($meter->isDualTariff == "on")





                                @else







                                @endif


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
                                    @if($meter->NeedKCT == "on")

                                        <input type="checkbox" name="NeedKCT" checked class="form-check-input"
                                               style="border: 10px">
                                        <label class="form-check-label">Need KCT</label>
                                    @else

                                        <input type="checkbox" name="NeedKCT" class="form-check-input"
                                               style="border: 10px">
                                        <label class="form-check-label">Need KCT</label>

                                    @endif


                                </div>


                                <div class="col-3">
                                    <label class="my-2">Credit Type</label>
                                    <select type="text" name="CreditTypeID" class="form-control" required>
                                        <option
                                            value="{{$meter->CreditTypeID}}">{{strtoupper($meter->CreditTypeID)}}</option>
                                        <option value="water">Water</option>
                                        <option value="gas">Gas</option>
                                        <option value="electricity">Electricity</option>
                                    </select>
                                </div>


                            </div>


                            <hr class="my-4">

                            <button type="submit" class="col-2 d-flex btn btn-primary">
                                Update Meter
                            </button>


                        </form>


                    </div>


                </div>


            </div>


        </div>


    </div> <!-- container-fluid -->

@endsection
