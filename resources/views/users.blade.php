@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')

    {{-- Create User Modal --}}

    <div class="modal fade" id="userModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        @csrf
                        <div class="modal-body">
                            <div id="user_err"></div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="adminRole" class="form-label">Role</label>
                                </div>
                                <div class="col-md-8">
                                    <select id="role_id" name="role_id" class="form-select form-select-sm">
                                        <option selected disabled >Choose...</option>
                                        @foreach ($roles as $list)
                                            @if ($list->id != MyApp::ADMINISTRATOR)
                                                @if ($list->id == MyApp::OTHER)
                                                    <option selected value="{{$list->id}}">{{ucwords($list->role)}}</option>
                                                @else
                                                    <option value="{{$list->id}}">{{ucwords($list->role)}}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-4">
                                    <label for="adminName" class="form-label">Name</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="text" name="name" id="name" class="form-control form-control-sm">

                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="code" id="code" class="form-control form-control-sm" placeholder="User code">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-4">
                                    <label for="adminEmail" class="form-label">Email</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="email" name="email" id="email" class="form-control form-control-sm">
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
                        {{-- <input type="hidden" name="admin_id" id="admin_id" value=""> --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="saveUserBtn" class="btn btn-primary btn-sm ">Save </button>
                            <button type="button" id="updateUserBtn" class="btn btn-primary btn-sm hide">Update </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- open modal button --}}
    <div class="row ">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
            <button type="button" id="addUser" class="btn btn-primary btn-flat btn-sm mt-2"><i class="fas fa-plus"></i> Add</button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Users</h3>

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
                                <th>Role</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{$count = "";}}
                            @foreach ($Users as $list)
                                <tr>
                                    <td>{{++$count}}</td>
                                    {{-- <td>{{($list->role == MyApp::ADMINISTRATOR) ? "Administrator" : "Mess" }}</td> --}}
                                    <td>{{ucwords($list->role)}}</td>
                                    <td>{{ucwords($list->name)}}</td>
                                    <td>{{ucwords($list->code)}}</td>
                                    <td>{{$list->email}}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm editUserBtn mr-1" value="{{$list->id}}"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm deleteUserBtn ml-1" value="{{$list->id}}"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>


    {{-- delete user modal  --}}

    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Delete User </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <center>
                        <h5>Are you sure?</h5>
                            <button type="button" id="yesDeleteUserBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                            <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                        <hr>
                    </center>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
  <script>
        $(document).ready(function () {
            $(document).on('click','#addUser', function (e) {
                e.preventDefault();
                $('#userModal').modal('show');
                $('#user_err').html('');
                $('#user_err').removeClass('alert alert-danger');
                $("#userForm").trigger("reset"); 
                $('#saveUserBtn').removeClass('hide');
                $('#updateUserBtn').addClass('hide');
            });

            $(document).on('click',"#saveUserBtn",function(e){
                e.preventDefault();
                saveUser();
            })

            $(document).on('click','.editUserBtn', function (e) {
                e.preventDefault();
                const user_id = $(this).val();
                // alert(user_id);
                editUser(user_id);
            });

            $(document).on('click','#updateUserBtn', function (e) {
                e.preventDefault();
                const user_id = $(this).val();
                updateUser(user_id);
                // alert(user_id);
            });

            $(document).on('click','.deleteUserBtn', function (e) {
                e.preventDefault();
                const user_id = $(this).val();
                $('#deleteUserModal').modal('show');
                $('#yesDeleteUserBtn').val(user_id);
            });

            $(document).on('click','#yesDeleteUserBtn', function (e) {
                e.preventDefault();
                const user_id = $(this).val();
                deleteUser(user_id);
            });


        });

        function saveUser() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#userForm")[0]);
            $.ajax({
                type: "post",
                url: "save-user",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    // console.log(response);
                    if (response.status === 400) {
                        $('#user_err').html('');
                        $('#user_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) {
                            $('#user_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                        });

                    } else {
                        $('#user_err').html('');
                        $('#userModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        function editUser(user_id){
            $.ajax({
                type: "get",
                url: "edit-user/"+user_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        $('#userModal').modal('show');
                        $('#user_err').html('');
                        $('#user_err').removeClass('alert alert-danger');
                        $("#userForm").trigger( "reset" ); 
                        $('#saveUserBtn').addClass('hide');
                        $('#updateUserBtn').removeClass('hide');
                        $('#role_id').val(response.user.role_id);
                        $('#name').val(response.user.name);
                        $('#code').val(response.user.code);
                        $('#email').val(response.user.email);
                        // $('#password').val(response.user.password);

                        $('#updateUserBtn').val(response.user.id);
                    }
                }
            });
        }

        function updateUser(user_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#userForm")[0]);
            $.ajax({
                type: "post",
                url: "update-user/"+user_id,
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    if(response.status === 400)
                    {
                        $('#user_err').html('');
                        $('#user_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) { 
                            $('#user_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                        });

                    }else{
                        $('#user_err').html('');
                        $('#userModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        function deleteUser(user_id){
            $.ajax({
                type: "get",
                url: "delete-user/"+user_id,
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