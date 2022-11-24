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
                            <div class="col-md-4">
                                <label for="company_name" class="form-label">Company</label>
                            </div>
                            <div class="col-md-8">
                               <input type="text" name="company_name" id="company_name" class="form-control form-control-sm" placeholder="company_name">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label for="business_name" class="form-label">Name</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="business_name" id="business_name" class="form-control form-control-sm" placeholder="business_name">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label for="email" class="form-label">Email</label>
                            </div>
                            <div class="col-md-8">
                                <input type="email" name="email" id="email" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label for="mobile_no" class="form-label">Mobile_no</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number"  min="0" name="mobile_no" id="mobile_no" class="form-control form-control-sm">
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

{{-- open modal button --}}
<div class="row mb-3">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
        <button type="button" id="addCompany" class="btn btn-primary btn-flat btn-sm mt-2"><i class="fas fa-plus"></i> Add</button>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Business Details</h3>

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
                            <th>Company</th>
                            <th>Business Name</th>
                            <th>Email</th>
                            <th>Mobile_No</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{$count = "";}}
                        @foreach ($businesiesDetails as $list)
                            <tr>
                                <td>{{++$count}}</td>
                                <td>{{ucwords($list->company_name)}}</td>
                                <td>{{ucwords($list->business_name)}}</td>
                                <td>{{$list->email}}</td>
                                <td>{{$list->mobile_no}}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm editCompanyBtn mr-1" value="{{$list->id}}"><i class="fas fa-edit"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm deleteCompanyBtn ml-1" value="{{$list->id}}"><i class="fas fa-trash"></i></button>
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
                        $('#company_name').val(response.company.company_name);
                        $('#business_name').val(response.company.business_name);
                        $('#email').val(response.company.email);
                        $('#mobile_no').val(response.company.mobile_no);

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