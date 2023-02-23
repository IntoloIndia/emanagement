@extends('layouts.app')
@section('page_title', 'Company Supplier')

@section('content-header')
    <div class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="m-0"><b>Company Supplier</b></h3>
            </div>  
            <div class="col-sm-6">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                    <button type="button" id="addCompanySupplier" class="btn btn-primary btn-flat btn-sm mt-2"><i class="fas fa-plus"></i> Add</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    {{-- company supplier add modal --}}
    <div class="modal fade" id="companySupplierModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Company Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="companySupplierForm">
                        @csrf
                        <div id="company_supplier_err"></div>
                        <div class="row">
                            <div class="col-md-5">
                                <input type="text" name="supplier_name" id="supplier_name" class="form-control-sm form-control" placeholder="Name">
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="mobile_no" id="mobile_no" class="form-control-sm form-control" placeholder="Mobile no">
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="phone_no" id="phone_no" class="form-control-sm form-control" placeholder="Phone no">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <select name="country_id" id="country_id" class="form-select form-select-sm" onchange="getStateByCountry(this.value)" >
                                    <option selected>Country</option>
                                    @foreach ($countries as $list)
                                        @if ($list->id == MyApp::INDIA)
                                            <option selected value="{{$list->id}}">{{$list->country}}</option>
                                        @else
                                            <option  value="{{$list->id}}">{{$list->country}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <select name="state_id" id="state_id" class="form-select form-select-sm"></select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <select name="city_id" id="city_id" class="form-select form-select-sm select_chosen">
                                        <option selected disabled>City</option>
                                    </select>
                                    <span class="input-group-text" style=" padding: 3px 5px 3px 5px;">
                                        <i class="fas fa-plus cursor_pointer" id="cityBtn"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <textarea class="form-control" name="address" id="address" placeholder="Address....."></textarea>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-4">
                               <input type="text" name="supplier_code" id="supplier_code" class="form-control form-control-sm" placeholder="Supplier code" readonly>
                            </div>
                            <div class="col-5">
                                <input type="text" name="gst_no" id="gst_no" class="form-control-sm form-control" placeholder="GST NO">
                            </div>
                            <div class="col-3">
                                <input type="text" name="payment_days" id="payment_days" class="form-control-sm form-control" placeholder="Payment days">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="saveCompanySupplierBtn" class="btn btn-primary btn-sm ">Save </button>
                    <button type="button" id="updateCompanySupplierBtn" class="btn btn-primary btn-sm hide">Update </button>
                </div>
            </div>
        </div>
    </div>

    {{-- company supplier delete modal --}}
    <div class="modal fade" id="deleteCompanySupplierModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Delete Supplier</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>Are you sure want to delete?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" id="yesDeleteCompanySupplierBtn" class="btn btn-danger btn-sm mx-1 ">Yes</button>
                    <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    {{-- import common modal(city add) --}}
    @include('layouts.common_modal')

    {{-- company supplier data render --}}
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-xl-6">
                            <h3 class="card-title">Company Suppliers</h3>
                        </div>
                        {{-- <div class=" col-md-2 col-lg-2 col-xl-2">
                            <select id="filter_city_id" class="form-select form-select-sm select_chosen">
                                <option selected disabled>City</option>
                                @foreach ($cities as $key => $list)
                                    <option value="{{$list->id}}" >{{ucwords($list->city)}}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        {{-- <div class="col-md-3 col-lg-3 col-xl-3">
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 200px;">
                                    <input type="text" name="table_search" class="form-control float-right search" placeholder="Search">
        
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>

                <div class="card-body table-responsive p-0" style="height: 500px;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Mobile no</th>
                                <th>Phone no</th>
                                <th>GST No</th>
                                <th>Payment Days</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @php
                            $count = 0;
                        @endphp
                        <tbody>
                            @foreach ($suppliers as $list)
                            <tr class="row_filter search_data" city-id="{{$list->city_id}}">
                                <td>{{++$count}}</td>
                                <td >{{$list->supplier_code}}</td>
                                <td>{{ucwords($list->supplier_name)}}</td>
                                <td>{{$list->mobile_no}}</td>
                                <td>{{$list->phone_no}}</td>
                                <td>{{$list->gst_no}}</td>
                                <td class="text-center">{{$list->payment_days}}</td>
                                <td>{{ucwords($list->state)}}</td>
                                <td>{{ucwords($list->city)}}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm editCompanySupplierBtn mr-1" value="{{$list->id}}"><i class="fas fa-edit"></i></button>
                                    {{-- <button type="button" class="btn btn-danger btn-sm deleteCompanySupplierBtn ml-1" value="{{$list->id}}"><i class="fas fa-trash"></i></button> --}}
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

            $(".state_chosen").chosen({ width: '100%' });
            $(".select_chosen").chosen({ width: '80%' });

            $(document).on('click','#addCompanySupplier', function (e) {
                e.preventDefault();
                $('#companySupplierModal').modal('show');
                $('#company_supplier_err').html('');
                $('#company_supplier_err').removeClass('alert alert-danger');
                $("#companySupplierForm").trigger("reset"); 
                $('#saveCompanySupplierBtn').removeClass('hide');
                $('#updateCompanySupplierBtn').addClass('hide');

                const country_id = $('#country_id').val();
                getStateByCountry(country_id);
            });

            $(document).on('click','#cityBtn', function (e) {
            e.preventDefault();
            if ($.trim($("#state_id").val()) == "") {
                alert("Please Select state!");
            }
            else{
                $('#cityModal').modal('show');
                $('#city_err').html('');
                $('#city_err').removeClass('alert alert-danger');
                $("#cityForm").trigger( "reset"); 
                $('#saveCityBtn').removeClass('hide');
                $('#updateCityBtn').addClass('hide');

                var country = $("#country_id").val();
                $("#put_country_id").val(country);
                var state = $("#state_id").val();
                $("#city_state_id").val(state);
            }
            })
        });

        $(document).on('change','#state_id', function (e) {
                e.preventDefault();
                const state_id = $(this).val();
                getCityByState(state_id);
        });

        $(document).on('click','#saveCityBtn', function (e) {
            e.preventDefault();
            manageCity();
        });

        $(document).on('change','#city_id', function (e) {
            e.preventDefault();
            var supplier_id = $('#updateCompanySupplierBtn').val();
            var supplier_latest_id = '{{$supplier_code}}';

                
            if (supplier_id > 0) {
                supplier_latest_id = supplier_id;
            } 
            var city = $(this).find("option:selected").text();
            var first_char = city.slice(0, 1).toUpperCase();
            var last_char = city.slice(-1).toUpperCase();
            var supplier_code = first_char + '0' + supplier_latest_id + last_char;
            $('#supplier_code').val(supplier_code);
        });

        $(document).on('click',"#saveCompanySupplierBtn",function(e){
            e.preventDefault();
            saveCompanySupplier()
        });

        $(document).on('click','.editCompanySupplierBtn', function (e) {
            e.preventDefault();
            const supplier_id = $(this).val();
            editCompanySupplier(supplier_id);
        });

        $(document).on('click','#updateCompanySupplierBtn', function (e) {
            e.preventDefault();
            const supplier_id = $(this).val();
            updateCompanySupplier(supplier_id);
        });

        $(document).on('click','.deleteCompanySupplierBtn', function (e) {
            e.preventDefault();
            const supplier_id = $(this).val();
            $('#deleteCompanySupplierModal').modal('show');
            $('#yesDeleteCompanySupplierBtn').val(supplier_id);
        });

        $(document).on('click','#yesDeleteCompanySupplierBtn', function (e) {
            e.preventDefault();
            const supplier_id = $(this).val();
            deleteCompanySupplier(supplier_id);
        });

                    
        // crud functions

        function saveCompanySupplier() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#companySupplierForm")[0]);
            $.ajax({
                type: "post",
                url: "save-company-supplier",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status === 400) {
                        $('#company_supplier_err').html('');
                        $('#company_supplier_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) {
                            $('#company_supplier_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                        });

                    } else {
                        $('#company_supplier_err').html('');
                        $('#companySupplierModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        function editCompanySupplier(supplier_id){
            $.ajax({
                type: "get",
                url: "edit-company-supplier/"+supplier_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        $('#companySupplierModal').modal('show');
                        $('#company_supplier_err').html('');
                        $('#company_supplier_err').removeClass('alert alert-danger');
                        $("#companySupplierForm").trigger( "reset" ); 
                        $('#saveCompanySupplierBtn').addClass('hide');
                        $('#updateCompanySupplierBtn').removeClass('hide');
                        $('#supplier_name').val(response.supplier.supplier_name);
                        $('#mobile_no').val(response.supplier.mobile_no);
                        $('#phone_no').val(response.supplier.phone_no);
                        $('#country_id').val(response.supplier.country_id);

                        $('#state_id').html("");
                        $('#state_id').append(response.html);
                        $('#city_id').html("");
                        $('#city_id').append(response.htmlcity);
                        $('#city_id').trigger("chosen:updated");

                        // $('#state_id').val(response.supplier.state_id);
                        $('#city_id').val(response.supplier.city_id);
                        $('#address').val(response.supplier.address);
                        
                        $('#payment_days').val(response.supplier.payment_days);
                        $('#supplier_code').val(response.supplier.supplier_code);
                        $('#gst_no').val(response.supplier.gst_no);

                        $('#updateCompanySupplierBtn').val(response.supplier.id);
                    }
                }
            });
        }

        function updateCompanySupplier(supplier_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#companySupplierForm")[0]);
            $.ajax({
                type: "post",
                url: "update-company-supplier/"+supplier_id,
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    console.log(response);
                    if(response.status === 400)
                    {
                        $('#company_supplier_err').html('');
                        $('#company_supplier_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) { 
                            $('#company_supplier_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                        });

                    }else{
                        $('#company_supplier_err').html('');
                        $('#companySupplierModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        function deleteCompanySupplier(supplier_id){
            $.ajax({
                type: "get",
                url: "delete-company-supplier/"+supplier_id,
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
