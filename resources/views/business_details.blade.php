@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')

<div class="modal fade" id="companyModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Business</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="companyForm">
                    @csrf
                    {{-- <div class="modal-body"> --}}
                        <div id="company_err"></div>

                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="business_name" id="business_name" class="form-control form-control-sm" placeholder="Business Name">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="owner_name" id="owner_name" class="form-control form-control-sm" placeholder="Owner Name">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <input type="text" name="mobile_no" id="mobile_no" class="form-control form-control-sm" placeholder="Mobile">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="ladline_no" id="ladline_no" class="form-control form-control-sm" placeholder="Ladline No">

                            </div>
                            <div class="col-md-4">
                                <input type="text"   name="gst" id="gst" class="form-control form-control-sm" placeholder="GST">
                            </div>                            
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
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
                                <select name="state_id" id="state_id" class="form-select form-select-sm">
                                        
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="city_id" id="city_id" class="form-select form-select-sm select_chosen">
                                    <option selected disabled>City</option>
                                </select>
                                <span class="input-group-text" style=" padding: 3px 5px 3px 5px;">
                                    <i class="fas fa-plus cursor_pointer" id="cityBtn"></i>
                                </span>
                            </div>
                        </div>
                           
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <textarea class="form-control" name="company_address" id="company_address" placeholder="Address....."></textarea>
                            </div>                         
                        </div>
                          <div class="row mt-2">
                            <div class="col-md-8">
                                <input type="email" name="email" id="email" class="form-control form-control-sm" placeholder="Email">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="pincode" id="pincode" class="form-control form-control-sm" placeholder="Pincode">
                            </div>
                        </div>                        
                    {{-- </div> --}}
                    {{-- <input type="hidden" name="admin_id" id="admin_id" value=""> --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveCompanyBtn" class="btn btn-primary btn-sm ">Save </button>
                        <button type="button" id="updateCompanyBtn" class="btn btn-primary btn-sm hide">Update </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('layouts.common_modal')

{{-- open modal button --}}
<div class="row mb-3">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end ">

        @if ($business_detail->count() == 0)            
            <button type="button" id="addCompany" class="btn btn-primary btn-flat btn-sm mt-2"><i class="fas fa-plus"></i> Add</button>
        @endif

    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Business Details</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0" style="height: 180px;">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Business </th>
                            <th>Owner</th>
                            <th>Mobile</th>
                            <th>Ladline</th>
                            <th>Email</th>
                            <th>GST</th>
                            <th>Country</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Address</th>
                            <th>Pincode</th>                            
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{$count = "";}}
                        @foreach ($business_detail as $list)
                            <tr>
                                <td>{{++$count}}</td>
                                <td>{{ucwords($list->business_name)}}</td>
                                <td>{{ucwords($list->owner_name)}}</td>
                                <td>{{$list->mobile_no}}</td>
                                <td>{{ucwords($list->ladline_no)}}</td>
                                <td>{{$list->email}}</td>
                                <td>{{ucwords($list->gst)}}</td>
                                <td>{{ucwords($list->country)}}</td>
                                <td>{{ucwords($list->state)}}</td>
                                <td>{{ucwords($list->city)}}</td>
                                <td><textarea class="form-control" name="company_address" id="company_address" style="width: 280px;height:100px;" disabled>{{ucwords($list->company_address)}}</textarea></td>
                                {{-- <td>{{ucwords($list->company_address)}}</td> --}}
                                <td>{{$list->pincode}}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm editCompanyBtn mr-1" value="{{$list->id}}"><i class="fas fa-edit"></i></button>
                                    {{-- <button type="button" class="btn btn-danger btn-sm deleteCompanyBtn ml-1" value="{{$list->id}}"><i class="fas fa-trash"></i></button> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{{-- delete modal  --}}


<div class="modal fade" id="deletecompanyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Delete Business Details  </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <h5>Are you sure?</h5>
                        <button type="button" id="yesDeleteCompanyBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                        <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                    <hr>
                </center>
            </div>
        </div>
    </div>
</div>

{{-- end delete modal  --}}

@endsection

@section('script')
  <script>
        $(document).ready(function () {
            $(document).on('click','#addCompany', function (e) {
                e.preventDefault();
                $('#companyModal').modal('show');
                $('#company_err').html('');
                $('#company_err').removeClass('alert alert-danger');
                $("#companyForm").trigger("reset"); 
                $('#saveCompanyBtn').removeClass('hide');
                $('#updateCompanyBtn').addClass('hide');
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
            });



            $(document).on('click',"#saveCompanyBtn",function(e){
                e.preventDefault();
                saveCompanyDetail();
            })

            $(document).on('click','.editCompanyBtn', function (e) {
                e.preventDefault();
                const company_id = $(this).val();
                // alert(company_id);
                editCompanyDetails(company_id);
            });

            $(document).on('click','#updateCompanyBtn', function (e) {
                e.preventDefault();
                const company_id = $(this).val();
                updateCompanyDetails(company_id);
                // alert(company_id);
            });

            $(document).on('click','.deleteCompanyBtn', function (e) {
                e.preventDefault();
                const company_id = $(this).val();
                // alert(company_id);
                $('#deletecompanyModal').modal('show');
                $('#yesDeleteCompanyBtn').val(company_id);
            });

            $(document).on('click','#yesDeleteCompanyBtn', function (e) {
                e.preventDefault();
                const company_id = $(this).val();
                // alert(company_id);
                deleteCompanyDetail(company_id);
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

            


        });

        function saveCompanyDetail() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#companyForm")[0]);
            $.ajax({
                type: "post",
                url: "save-company-details",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                    if (response.status === 400) {
                        $('#company_err').html('');
                        $('#company_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) {
                            $('#company_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                        });

                    } else {
                        $('#company_err').html('');
                        $('#companyModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        function editCompanyDetails(company_id){
            $.ajax({
                type: "get",
                url: "edit-company-details/"+company_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        $('#companyModal').modal('show');
                        $('#company_err').html('');
                        $('#company_err').removeClass('alert alert-danger');
                        $("#companyForm").trigger( "reset" ); 
                        $('#saveCompanyBtn').addClass('hide');
                        $('#updateCompanyBtn').removeClass('hide');
                        $('#business_name').val(response.company.business_name);
                        $('#owner_name').val(response.company.owner_name);
                        $('#mobile_no').val(response.company.mobile_no);
                        $('#ladline_no').val(response.company.ladline_no);
                        $('#gst').val(response.company.gst);
                        $('#country_id').val(response.company.country_id);
                        // $('#state_id').val(response.company.state_id);
                        // $('#city_id').val(response.company.city_id);
                        $('#company_address').val(response.company.company_address);
                        $('#email').val(response.company.email);
                        $('#pincode').val(response.company.pincode);

                        $('#state_id').html("");
                        $('#state_id').append(response.html);
                        $('#city_id').html("");
                        $('#city_id').append(response.htmlcity);
                        $('#updateCompanyBtn').val(response.company.id);
                    }
                }
            });
        }

        function updateCompanyDetails(company_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#companyForm")[0]);
            $.ajax({
                type: "post",
                url: "update-company-details/"+company_id,
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    if(response.status === 400)
                    {
                        $('#company_err').html('');
                        $('#company_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) { 
                            $('#company_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                        });

                    }else{
                        $('#company_err').html('');
                        $('#companyModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        function deleteCompanyDetail(company_id){
            $.ajax({
                type: "get",
                url: "delete-company-details/"+company_id,
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