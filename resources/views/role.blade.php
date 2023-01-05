
@extends('layouts.app')
@section('page_title', 'Role')
@section('content')

<div class="modal fade" id="roleModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="roleForm">
                    @csrf
                    <div class="modal-body">
                        <div id="role_err"></div>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label  class="form-label">Role</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="role" id="role" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveRoleBtn" class="btn btn-primary btn-sm ">Save Role</button>
                        <button type="button" id="updateRoleBtn" class="btn btn-primary btn-sm hide">Update Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Delete Role </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <h5>Are you sure?</h5>
                        <button type="button" id="yesDeleteRoleBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                        <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                    <hr>
                </center>
            </div>
        </div>
    </div>
</div>

<div class="row ">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
        <button type="button" id="addRole" class="btn btn-primary btn-flat btn-sm mt-2"><i class="fas fa-plus"></i> Add</button>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Role</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" id="filter_role" class="form-control float-right" placeholder="Search">

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
                            <th>Role</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody id="filter_table">
                       {{$count = "";}}
                        @foreach ($roles as $list)
                            <tr class="">
                                <td>{{++$count}}</td>
                                <td>{{ ucwords($list->role)}}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm editRoleBtn mr-1" value="{{$list->id}}"><i class="fas fa-edit"></i></button>
                                    {{-- <button type="button" class="btn btn-danger btn-sm deleteRoleBtn ml-1" value="{{$list->id}}"><i class="fas fa-trash"></i></button> --}}
                                    @if($list->active_role == MyApp::ACTIVE)
                                        <button type="button" class="btn  btn-sm activeRoleBtn ml-1" value="{{$list->id}}"><i class="fas fa-ban" style="font-size:24px;color:lightcoral"></i></button> 
                                        
                                    @else
                                        <button type="button" class="btn btn btn-sm activeRoleBtn ml-1" value="{{$list->id}}"><i class="far fa-check-circle" style="font-size:24px;color:rgb(5, 119, 5)"></i></button> 
                                    @endif
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
        $(document).on('click','#addRole',function(e) {
            $('#roleModal').modal('show');
            $('#role_err').html('');
            $('#role_err').removeClass('alert alert-danger');
            $('#roleForm').trigger('reset');
            $('#saveRoleBtn').removeClass('hide');
            $('#updateRoleBtn').addClass('hide');
        });
        $(document).on('click','#saveRoleBtn',function(e) {
            saveRole();
        });
        $(document).on('click','.editRoleBtn',function(e) {
            var role_id = $(this).val();
            editRole(role_id);
        });
        $(document).on('click','#updateRoleBtn',function(e) {
            var role_id = $(this).val();
            updateRole(role_id);
        });
        $(document).on('click','.deleteRoleBtn',function(e) {
            $('#deleteRoleModal').modal('show');
            var role_id = $(this).val();
            $('#yesDeleteRoleBtn').val(role_id);
        });
        $(document).on('click','#yesDeleteRoleBtn',function(e) {
            var role_id = $(this).val();
            deleteRole(role_id);
        });
        $(document).on('click','.activeRoleBtn',function(e) {
            var role_id = $(this).val();
            activeDeactiveRole(role_id);
        });
        $(document).on('keyup','#filter_role',function(e){
            var value = $(this).val().toLowerCase();
            $("#filter_table tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

    });



    function saveRole(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formData = new FormData($("#roleForm")[0]);
        $.ajax({
            type: "post",
            url: "save-role",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false, 
            processData: false, 
            success: function (response) {
                if(response.status === 400)
                {
                    $('#role_err').html('');
                    $('#role_err').addClass('alert alert-danger');
                    var count = 1;
                    $.each(response.errors, function (key, err_value) { 
                        $('#role_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                    });

                }else{
                    $('#role_err').html('');
                    $('#roleModal').modal('hide');
                    window.location.reload();
                }
            }
        });
    }

    function editRole(role_id){
        $.ajax({
            type: "get",
            url: "edit-role/" + role_id,
            data: "formDate",
            dataType: "json",
            success: function (response) {
                console.log(response);
                if(response.status == 200){
                    $('#roleModal').modal('show');
                    $('#role_err').html('');
                    $('#role_err').removeClass('alert alert-danger');
                    $("#roleForm").trigger( "reset" ); 
                    $('#saveRoleBtn').addClass('hide');
                    $('#updateRoleBtn').removeClass('hide');
                    $('#role').val(response.role_id.role);
                    $('#updateRoleBtn').val(response.role_id.id);
                }
            }
        });
    }

    function updateRole(role_id){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData = new FormData($("#roleForm")[0]);
        $.ajax({
            type: "post",
            url: "update-role/"+role_id,
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false, 
            processData: false, 
            success: function (response) {
                console.log(response);
                if(response.status === 400)
                {
                    $('#role_err').html('');
                    $('#role_err').addClass('alert alert-danger');
                    var count = 1;
                    $.each(response.errors, function (key, err_value) { 
                        $('#role_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                    });

                }else{
                    $('#role_err').html('');
                    $('#roleModal').modal('hide');
                    window.location.reload();
                }
            }
        });
    }
    function deleteRole(role_id) {
        $.ajax({
            type: "get",
            url: "delete-role/" + role_id,
            data: "formData",
            dataType: "json",
            success: function (response) {
                if(response.status == 200)
                {
                    window.location.reload();
                }
            }
        });
    }
    function activeDeactiveRole(role_id) {
        $.ajax({
            type: "get",
            url: "active-deactive-role/" + role_id,
            data: "formData",
            dataType: "json",
            success: function (response) {
                if(response.status == 200)
                {
                    window.location.reload();
                }
            }
        });
    }

   

</script>
@endsection