@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
                <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary btn-sm float-right" data-bs-toggle="modal" data-bs-target="#userModal">
        Add user
    </button>
  
  <!-- Modal -->
  <div class="modal fade" id="userModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="userForm">
              <div class="user_err"></div>
                <div class="mb-3">
                  <label for="user_name" class="form-label">Roll</label>
                    <select class="form-select" id="user_role" name="user_role" aria-label="Default select example">
                        <option selected>Other</option>
                        @foreach ($roles as $list)
                         <option value="{{$list->id}}">{{ucwords($list->role)}}</option>
                        @endforeach
                      </select>
                </div>

                <div class="mb-3">
                  <label for="user_name" class="form-label">User</label>
                  <input type="text" class="form-control" name="name" id="name"placeholder="user name">
                 </div>
                 <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="email">
                  </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" name="password" id="password" placeholder="password">
                </div>
                
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="userSavebtn">save</button>
        </div>
    </form>
      </div>
    </div>
  </div>
  </div>
</div>
<div class="row">
  <div class="col-6">
    <div class="card">
      <div class="card-header">
        <b>User Data</b>
      </div>
      <div class="card-body">
        userdata
      </div>
    </div>
  </div>
</div>

@endsection
@section('script')
  <script>

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


    $(document).ready(function(){
     $(document).on('click',"#userSavebtn",function(e){
      e.preventDefault();
      // alert("call")
      saveUser();
     })

     $(document).on('click','#userSavebtn', function (e) {
                e.preventDefault();
                $('#userModal').modal('show');
                $('#user_err').html('');
                $('#user_err').removeClass('alert alert-danger');
                $("#userForm").trigger( "reset"); 
                // $("#project_id").chosen({ width: '100%' });
                //  $('#saveSizeBtn').removeClass('hide');
                //  $('#updateSizeBtn').addClass('hide');
                
            });


    })
  </script>

@endsection