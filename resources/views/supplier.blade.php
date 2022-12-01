@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')
   {{-- modal supplier  --}}

   <div class="modal fade" id="supplierModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="supplierForm">
                    @csrf
                    {{-- @method('put') --}}
                    {{-- <div class="modal-body"> --}}
                        <div id="supplier_err"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="supplier_name" id="supplier_name" class="form-control-sm form-control" placeholder="Name">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="mobile_no" id="mobile_no" class="form-control-sm form-control" placeholder="Mobile no">
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-12">
                                    <textarea class="form-control" name="address" id="address" placeholder="Address....."></textarea>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-6">
                                    <input type="text" name="gst_no" id="gst_no" class="form-control-sm form-control" placeholder="GST IN">
                                </div>
                                <div class="col-6">
                                   <input type="text" name="hsn_code" id="hsn_code" class="form-control form-control-sm" placeholder="HSN Code">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-4">
                                    <select name="country_id" id="country_id" class="form-select form-select-sm" onchange="getStateByCountry(this.value)" >
                                        <option selected>Country...</option>
                                        @foreach ($allcountries as $item)
                                        <option value="{{$item->id}}">{{$item->country}}</option>
                                        @endforeach
                                      </select>
                                      {{-- <select name="country_id" id="city_country_id" class="form-select form-select-sm" onchange="getStateByCountry(this.value);">
                                        <option selected disabled >Select...</option>
                                        @foreach ($allcountries as $list)
                                            @if ($list->id == MyApp::INDIA)
                                                <option selected value="{{$list->id}}">{{$list->country}}</option>
                                            @else
                                                <option  value="{{$list->id}}">{{$list->country}}</option>
                                            @endif
                                        @endforeach
                                    </select> --}}
                                </div>
                                <div class="col-4">
                                    <select name="state_id" id="state_id" class="form-select form-select-sm" onchange="getCityByState(this.value)">
                                        <option selected disabled>State..</option>
                                       {{-- @foreach ($allStates as $item)
                                        <option value="{{$item->id}}">{{$item->state}}</option>
                                           
                                       @endforeach --}}
                                      </select>
                                </div>
                                <div class="col-4">
                                    <select name="city_id" id="city_id" class="form-select form-select-sm">
                                        <option selected disabled>City</option>
                                       {{-- @foreach($allCity as $item)
                                           <option value="{{$item->id}}">{{$item->city}}</option>
                                       @endforeach --}}
                                      </select>
                                </div>
                            </div>

                    {{-- </div> --}}
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveSupplierBtn" class="btn btn-primary btn-sm ">Save </button>
                        <button type="button" id="updateSupplierBtn" class="btn btn-primary btn-sm hide">Update </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- delete user modal  --}}

<div class="modal fade" id="deleteSupplierModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Delete User </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <h5>Are you sure?</h5>
                        <button type="button" id="yesdeleteSupplierBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                        <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                    <hr>
                </center>
            </div>
        </div>
    </div>
</div>


    {{-- open modal button --}}
    <div class="row ">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
            <button type="button" id="addsuplier" class="btn btn-primary btn-flat btn-sm mt-2"><i class="fas fa-plus"></i> Add</button>
        </div>
    </div>

    {{-- end  --}}

    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Supplier</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0" style="height: 400px;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Mobile no</th>
                                <th>GST IN</th>
                                <th>HSN Code</th>
                                <th>Country</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @php
                            $count = 0;
                        @endphp
                        <tbody>
                            @foreach ($suppliers as $list)
                                <tr>
                                    <td>{{++$count}}</td>
                                    <td>{{ucwords($list->supplier_name)}}</td>
                                    <td>{{$list->mobile_no}}</td>
                                    <td>{{$list->gst_no}}</td>
                                    <td>{{$list->hsn_code}}</td>
                                    <td>{{ucwords($list->country)}}</td>
                                    <td>{{ucwords($list->state)}}</td>
                                    <td>{{ucwords($list->city)}}</td>
                                    <td>{{ucwords($list->address)}}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm editSupplierBtn mr-1" value="{{$list->id}}"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm deleteSupplierBtn ml-1" value="{{$list->id}}"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('script')
  <script>
        $(document).ready(function () {
            $(document).on('click','#addsuplier', function (e) {
                e.preventDefault();
                $('#supplierModal').modal('show');
                $('#supplier_err').html('');
                $('#supplier_err').removeClass('alert alert-danger');
                $("#supplierForm").trigger("reset"); 
                $('#saveSupplierBtn').removeClass('hide');
                $('#updateSupplierBtn').addClass('hide');
            });

            $(document).on('click',"#saveSupplierBtn",function(e){
                e.preventDefault();
                // alert("call")
                saveSupplier()
            });

            $(document).on('click','.editSupplierBtn', function (e) {
                e.preventDefault();
                const supplier_id = $(this).val();
                // alert(supplier_id);
                editSupplier(supplier_id);
            });


            $(document).on('click','#updateSupplierBtn', function (e) {
                e.preventDefault();
                const supplier_id = $(this).val();
                // alert(supplier_id);
                updateSupplier(supplier_id);
            });

            $(document).on('click','.deleteSupplierBtn', function (e) {
                e.preventDefault();
                const supplier_id = $(this).val();
                $('#deleteSupplierModal').modal('show');
                $('#yesdeleteSupplierBtn').val(supplier_id);
            });

            $(document).on('click','#yesdeleteSupplierBtn', function (e) {
                e.preventDefault();
                const supplier_id = $(this).val();
                deleteSupplier(supplier_id);
            });

            $(document).on('change','#country_id', function (e) {
                e.preventDefault();
                const country_id = $(this).val();
                // alert(country_id);
                getStateByCountry(country_id);
            });

            $(document).on('change','#state_id', function (e) {
                e.preventDefault();
                const state_id = $(this).val();
                // alert(state_id);
                getCityByState(state_id);
            });

        });

        function saveSupplier() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#supplierForm")[0]);
            $.ajax({
                type: "post",
                url: "save-supplier-order",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status === 400) {
                        $('#supplier_err').html('');
                        $('#supplier_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) {
                            $('#supplier_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                        });

                    } else {
                        $('#supplier_err').html('');
                        $('#supplierModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        function editSupplier(supplier_id){
            $.ajax({
                type: "get",
                url: "edit-supplier-order/"+supplier_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        $('#supplierModal').modal('show');
                        $('#supplier_err').html('');
                        $('#supplier_err').removeClass('alert alert-danger');
                        $("#supplierForm").trigger( "reset" ); 
                        $('#saveSupplierBtn').addClass('hide');
                        $('#updateSupplierBtn').removeClass('hide');
                        $('#supplier_name').val(response.supplier.supplier_name);
                        $('#mobile_no').val(response.supplier.mobile_no);
                        $('#address').val(response.supplier.address);
                        $('#gst_no').val(response.supplier.gst_no);
                        $('#hsn_code').val(response.supplier.hsn_code);
                        $('#country_id').val(response.supplier.country_id);

                        $('#state_id').html("");
                        $('#state_id').append(response.html);
                        $('#city_id').html("");
                        $('#city_id').append(response.htmlcity);

                        // $('#state_id').val(response.supplier.state_id);
                        $('#city_id').val(response.supplier.city_id);
                        

                        $('#updateSupplierBtn').val(response.supplier.id);
                    }
                }
            });
        }

        function updateSupplier(supplier_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#supplierForm")[0]);
            $.ajax({
                type: "post",
                url: "update-supplier-order/"+supplier_id,
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    console.log(response);
                    if(response.status === 400)
                    {
                        $('#supplier_err').html('');
                        $('#supplier_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) { 
                            $('#supplier_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                        });

                    }else{
                        $('#supplier_err').html('');
                        $('#supplierModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }



        function deleteSupplier(supplier_id){
            $.ajax({
                type: "get",
                url: "delete-supplier-order/"+supplier_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        window.location.reload();
                    }
                }
            });
        }

  </script>

  @endsection
