@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
                <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#userModal">
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
            <form>
                <div class="mb-3">
                  <label for="user_name" class="form-label">Roll</label>
                    <select class="form-select" id="roll_id" name="roll_id" aria-label="Default select example">
                        <option selected>Other</option>
                        <option value="1">Admin</option>
                        <option value="2">subadmin</option>
                        <option value="3">Employee</option>
                      </select>
                </div>

                <div class="mb-3">
                  <label for="user_name" class="form-label">User</label>
                  <input type="text" class="form-control" name="user_name" id="user_name"placeholder="user name">
                 </div>
                 <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" id="email" placeholder="email">
                  </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" placeholder="password">
                </div>
                
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">save</button>
        </div>
    </form>
      </div>
    </div>
  </div>
    </div>
</div>

@endsection