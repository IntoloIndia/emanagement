@extends('layouts.app')
@section('page_title','Admins')
    
@section('content')

    <div class="modal fade" id="adminModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="adminForm">
                        @csrf
                        <div class="modal-body">
                            <div id="admin_err"></div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="adminRole" class="form-label">Admin Role</label>
                                </div>
                                <div class="col-md-8">
                                    <select id="role" name="role" class="form-select form-select-sm">
                                        <option selected disabled >Choose...</option>
                                        @foreach ($roles as $list)
                                            <option value="{{$list->id}}">{{ucwords($list->role)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-4">
                                    <label for="adminName" class="form-label">Name</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="name" id="name" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-4">
                                    <label for="adminEmail" class="form-label">Email</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="email" id="email" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-4">
                                    <label for="adminEmail" class="form-label">Password</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="password" name="password" id="password" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="admin_id" id="admin_id" value="">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="saveAdminBtn" class="btn btn-primary btn-sm ">Save Admin</button>
                            <button type="button" id="updateAdminBtn" class="btn btn-primary btn-sm hide">Update Admin</button>
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

    <div class="row ">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
            <button type="button" id="addAdmin" class="btn btn-primary btn-flat btn-sm mt-2"><i class="fas fa-plus"></i> Add</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Admins</h3>

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

                <div class="card-body table-responsive p-0" style="height: 350px;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Role</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        {{-- <tbody>
                            {{$count = "";}}
                            @foreach ($admins as $list)
                                <tr>
                                    <td>{{++$count}}</td>
                                    <td>{{($list->role == MyApp::ADMINISTRATOR) ? "Administrator" : "Mess" }}</td>
                                    <td>{{$list->name}}</td>
                                    <td>{{$list->email}}</td>
                                    <td>
                                        <button type="button" class="btn btn-secondary btn-sm editAdminBtn" value="{{$list->id}}">Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm deleteAdminBtn" value="{{$list->id}}">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody> --}}
                    </table>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $(document).on('click','#addAdmin', function (e) {
                e.preventDefault();
                $('#adminModal').modal('show');
                $('#admin_err').html('');
                $('#admin_err').removeClass('alert alert-danger');
                $("#adminForm").trigger("reset"); 
                $('#saveAdminBtn').removeClass('hide');
                $('#updateAdminBtn').addClass('hide');
            });

            $(document).on('click','#saveAdminBtn', function (e) {
                e.preventDefault();
                saveAdmin();
            });
            
            $(document).on('click','.editAdminBtn', function (e) {
                e.preventDefault();
                const admin_id = $(this).val();
                editAdmin(admin_id);
            });

            $(document).on('click','#updateAdminBtn', function (e) {
                e.preventDefault();
                const admin_id = $(this).val();
                updateAdmin(admin_id);
            });
            
            $(document).on('click','.deleteAdminBtn', function (e) {
                e.preventDefault();
                const admin_id = $(this).val();
                $('#deleteAdminModal').modal('show');
                $('#yesDeleteAdminBtn').val(admin_id);
            });

            $(document).on('click','#yesDeleteAdminBtn', function (e) {
                e.preventDefault();
                const admin_id = $(this).val();
                deleteAdmin(admin_id);
            });


        });

        
    </script>
@endsection