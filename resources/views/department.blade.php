@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('style')

@endsection

@section('content')

    {{-- <h1>Department</h1> --}}
    <div class="modal fade" id="departmentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">department</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="departmentForm">
                  @csrf
                  <div class="modal-body">
                      <div id="department_err"></div>
                      {{-- <div class="row"> --}}
                      <div class="row mt-1">
                          <div class="col-md-4">
                              <label for="departmentName" class="form-label">Department</label>
                          </div>
                          <div class="col-md-8">
                              <input type="text" name="department" id="department" placeholder="department name" class="form-control form-control-sm">
                          </div>
                      </div>
                     
                  </div>
                   {{-- <input type="hidden" name="admin_id" id="admin_id" value=""> --}} 
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                      <button type="button" id="saveDepartmentBtn" class="btn btn-primary btn-sm ">Save </button>
                      <button type="button" id="updateDepartmentBtn" class="btn btn-primary btn-sm hide">Update </button>
                  </div>
              </form>
          </div>
          </div>
        </div>
    </div>
    
    {{-- delete modal start  --}}

    <div class="modal fade" id="deleteDepartmentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Delete User </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <center>
                        <h5>Are you sure?</h5>
                            <button type="button" id="yesdeletedepartmentBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                            <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                        <hr>
                    </center>
                </div>
            </div>
        </div>
      </div>
    
    {{-- delete modal end  --}}

 <div class="row mb-2">
  <div class="col-12">
    <button type="button" id="addDepartment" class="btn btn-primary float-right btn-flat btn-sm mt-2"><i class="fas fa-plus"></i> Add</button>
  </div>
 </div>

<div class="row">
    <div class="col-lg-4 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-header">
          {{-- <div class="row">
            <div class="col-6"> --}}
              <b>Department</b>
            {{-- </div> --}}
            
          {{-- </div> --}}
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Sno</th>
                <th scope="col">Department</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            @php
             $count = 0;   
            @endphp
            <tbody>
              @foreach ($departments as $list)
                  <tr>
                    <td>{{++$count}}</td>
                    <td>{{$list->department}}</td>
                    {{-- <td>
                      <a href="{{asset('/storage/app/public/'.$list->department_img)}}" target="_blank">
                       <img src="{{asset('/storage/app/public/'.$list->category_img)}}"  alt="image not found" srcset="" class="card-img-top img-thumbnail img-wh-40" style="cursor:pointer"></a></td> --}}
                     {{-- <td>{{$list->department}}</td>--}} 
                    <td> 
                      <button type="button" class="btn btn-info btn-sm editDepartmentBtn mr-1" value="{{$list->id}}"><i class="fas fa-edit"></i></button>
                     <button type="button" class="btn btn-danger btn-sm deleteDepartmentBtn ml-1" value="{{$list->id}}"><i class="fas fa-trash"></i></button> 
                  </td>
                  </tr>
              @endforeach 
            </tbody>
          </table>
        </div>
      </div>
    </div>

@endsection


@section('script')
<script>
    $(document).ready(function () {
            $(document).on('click','#addDepartment', function (e) {
                e.preventDefault();
                $('#departmentModal').modal('show');
                $('#department_err').html('');
                $('#department_err').removeClass('alert alert-danger');
                $("#departmentForm").trigger("reset"); 
                $('#saveDepartmentBtn').removeClass('hide');
                $('#updateDepartmentBtn').addClass('hide');
                // $('#department_img_update').addClass('hide');
                
            });

            $(document).on('click','#saveDepartmentBtn', function (e) {
                e.preventDefault();
                // alert('dd')
                saveDepartment();
                
            });

             $(document).on('click','.editDepartmentBtn', function (e) {
                e.preventDefault();
                const department_id = $(this).val();
                editDepartment(department_id);
            });

            $(document).on('click','#updateDepartmentBtn', function (e) {
                e.preventDefault();
                const department_id = $(this).val();
                updateDepartment(department_id);
            });

            $(document).on('click','.deleteDepartmentBtn', function (e) {
                e.preventDefault();
                const department_id = $(this).val();
                // alert(department_id)
                $('#deleteDepartmentModal').modal('show');
                $('#yesdeletedepartmentBtn').val(department_id);
            });

            $(document).on('click','#yesdeletedepartmentBtn', function (e) {
                e.preventDefault();
                const department_id = $(this).val();
                deleteDepartment(department_id);
            });

       }) 
    
    
    function saveDepartment() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#departmentForm")[0]);
            $.ajax({
                type: "post",
                url: "save-department",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    // console.log(response);
                    if (response.status === 400) {
                        $('#department_err').html('');
                        $('#department_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) {
                            $('#department_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                        });

                    } else {
                        $('#department_err').html('');
                        $('#departmentModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }


        function editDepartment(department_id){
            $.ajax({
                type: "get",
                url: "edit-department/"+department_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        $('#departmentModal').modal('show');
                        $('#department_err').html('');
                        $('#department_err').removeClass('alert alert-danger');
                        $("#departmentForm").trigger( "reset" ); 
                        $('#saveDepartmentBtn').addClass('hide');
                        $('#updateDepartmentBtn').removeClass('hide');

                        $('#department').val(response.department.department);
                        $('#updateDepartmentBtn').val(response.department.id);
                    }
                }
            });
        }

        function updateDepartment(department_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#departmentForm")[0]);
            $.ajax({
                type: "post",
                url: "update-department/"+department_id,
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    if(response.status === 400)
                    {
                        $('#department_err').html('');
                        $('#department_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) { 
                            $('#department_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                        });

                    }else{
                        $('#department_err').html('');
                        $('#departmentModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }



        // delete  department 
        function deleteDepartment(department_id){
            $.ajax({
                type: "get",
                url: "delete-department/"+department_id,
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