@extends('layouts.app')
@section('page_title','Style No')

@section('content-header')
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="m-0"><b>Style No</b></h3>
            </div>
            <div class="col-sm-6">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                    <button type="button" id="addStyleNo" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-plus"></i> Add</button>
                </div>
            </div>
        </div>
    </div>
@endsection
    
@section('content')

    <div class="modal fade" id="styleNoModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Style No</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="styleNoForm">
                        @csrf
                        <div class="modal-body">
                            <div id="style_no_err"></div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="Supplier" class="form-label">Supplier</label>
                                </div>
                                <div class="col-md-8">
                                    <select id="supplier_id" name="supplier_id" class="form-select form-select-sm">
                                        <option selected disabled >Select...</option>
                                        @foreach ($suppliers as $list)
                                            <option value="{{$list->id}}">{{ucwords($list->supplier_name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-4">
                                    <label for="styleNo" class="form-label">Style No</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="style_no" id="style_no" class="form-control form-control-sm">
                                </div>
                            </div>
                            
                        </div>
                        <input type="hidden" name="style_id" id="style_id" value="">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="saveStyleNoBtn" class="btn btn-primary btn-sm ">Save</button>
                            <button type="button" id="updateStyleNoBtn" class="btn btn-primary btn-sm hide">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteAdminModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Delete Admin </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <center>
                        <h5>Are you sure?</h5>
                            <button type="button" id="yesDeleteAdminBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                            <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                        <hr>
                    </center>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Styles</h3>

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

                <div class="card-body table-responsive p-0" style="height: 450px;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>SN</th>
                                {{-- <th>Role</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            {{$count = "";}}
                            {{-- @foreach ($admins as $list)
                                <tr>
                                    <td>{{++$count}}</td>
                                    <td>{{($list->role_id == MyApp::ADMINISTRATOR) ? "Administrator" : "Billing" }}</td>
                                    <td>{{ucwords($list->name)}}</td>
                                    <td>{{$list->email}}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm editAdminBtn mr-1" value="{{$list->id}}"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm deleteAdminBtn ml-1" value="{{$list->id}}"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach --}}
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
            $(document).on('click','#addStyleNo', function (e) {
                e.preventDefault();
                $('#styleNoModal').modal('show');
                $('#style_no_err').html('');
                $('#style_no_err').removeClass('alert alert-danger');
                $("#styleNoForm").trigger("reset"); 
                $('#saveStyleNoBtn').removeClass('hide');
                $('#updateStyleNoBtn').addClass('hide');
            });

            $(document).on('click','#saveStyleNoBtn', function (e) {
                e.preventDefault();
                manageStyleNo();
            });
            
            $(document).on('click','.editStyleNoBtn', function (e) {
                e.preventDefault();
                const style_id = $(this).val();
                editStyleNo(style_id);
            });

            $(document).on('click','#updateStyleNoBtn', function (e) {
                e.preventDefault();
                const style_id = $(this).val();
                manageStyleNo(style_id);
            });
            
            $(document).on('click','.deleteStyleNoBtn', function (e) {
                e.preventDefault();
                const style_id = $(this).val();
                $('#deleteStyleNoModal').modal('show');
                $('#yesDeleteStyleNoBtn').val(style_id);
            });

            $(document).on('click','#yesDeleteStyleNoBtn', function (e) {
                e.preventDefault();
                const style_id = $(this).val();
                deleteStyleNo(style_id);
            });


        });

        function manageStyleNo(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#styleNoForm")[0]);
            $.ajax({
                type: "post",
                url: "save-style-no",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    if(response.status === 400)
                    {
                        $('#style_no_err').html('');
                        $('#style_no_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) { 
                            $('#style_no_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                        });

                    }else{
                        $('#style_no_err').html('');
                        $('#styleNoModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        // function editAdmin(admin_id){
        //     $.ajax({
        //         type: "get",
        //         url: "edit-admin/"+admin_id,
        //         dataType: "json",
        //         success: function (response) {
        //             if(response.status == 200){
        //                 $('#adminModal').modal('show');
        //                 $('#admin_err').html('');
        //                 $('#admin_err').removeClass('alert alert-danger');
        //                 $("#adminForm").trigger( "reset" ); 
        //                 $('#saveAdminBtn').addClass('hide');
        //                 $('#updateAdminBtn').removeClass('hide');
        //                 $('#role_id').val(response.admin.role_id);
        //                 $('#name').val(response.admin.name);
        //                 $('#email').val(response.admin.email);

        //                 $('#updateAdminBtn').val(response.admin.id);
        //             }
        //         }
        //     });
        // }

        // function updateAdmin(admin_id){
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });

        //     var formData = new FormData($("#adminForm")[0]);
        //     $.ajax({
        //         type: "post",
        //         url: "update-admin/"+admin_id,
        //         data: formData,
        //         dataType: "json",
        //         cache: false,
        //         contentType: false, 
        //         processData: false, 
        //         success: function (response) {
        //             if(response.status === 400)
        //             {
        //                 $('#admin_err').html('');
        //                 $('#admin_err').addClass('alert alert-danger');
        //                 var count = 1;
        //                 $.each(response.errors, function (key, err_value) { 
        //                     $('#admin_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
        //                 });

        //             }else{
        //                 $('#admin_err').html('');
        //                 $('#adminModal').modal('hide');
        //                 window.location.reload();
        //             }
        //         }
        //     });
        // }

        // function deleteAdmin(admin_id){
        //     $.ajax({
        //         type: "get",
        //         url: "delete-admin/"+admin_id,
        //         dataType: "json",
        //         success: function (response) {
        //             if(response.status == 200){
        //                 window.location.reload();
        //             }
        //         }
        //     });
        // }




        
    </script>
@endsection