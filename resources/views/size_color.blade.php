@extends('layouts.app')
@section('page_title', 'Dashboard')
@section('style')
<style>
  #colorinput{
    border: none;
  }
</style>
@endsection;

@section('content')

<div class="modal fade" id="sizeModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Size</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="sizeForm">
                    @csrf
                    <div class="modal-body">
                        <div id="size_err"></div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="Size" class="form-label">Size</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="size" id="size" class="form-control form-control-sm" placeholder="Size">
                            </div>
                        </div>
                    </div>
                    {{-- <input type="hidden" name="admin_id" id="admin_id" value=""> --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveSizeBtn" class="btn btn-primary btn-sm ">Save</button>
                        <button type="button" id="updateSizeBtn" class="btn btn-primary btn-sm hide">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- size modal end  --}}

{{-- color modal start  --}}

<div class="modal fade" id="colorModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Color</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="colorForm">
                    @csrf
                    <div class="modal-body">
                        <div id="size_err"></div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="Color" class="form-label">Color</label>
                            </div>
                            <div class="col-md-8">
                                {{-- <input type="color" name="color" id="color" class="form-control form-control-sm" placeholder="Color"> --}}
                                <input type="text" name="color" id="color" class="form-control form-control-sm" placeholder="Color">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveColorBtn" class="btn btn-primary btn-sm ">Save</button>
                        <button type="button" id="updateColorBtn" class="btn btn-primary btn-sm hide">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- color modal end  --}}

{{-- delete  modal  --}}

<div class="modal fade" id="deleteSizeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"> Delete User </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <center>
                  <h5>Are you sure?</h5>
                      <button type="button" id="yesDeleteSizeBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                      <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                  <hr>
              </center>
          </div>
      </div>
  </div>
</div>
{{-- end delete modal  --}}

{{-- delete start  modal  --}}

<div class="modal fade" id="deleteColorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"> Delete User </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <center>
                  <h5>Are you sure?</h5>
                      <button type="button" id="yesDeleteColorBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                      <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                  <hr>
              </center>
          </div>
      </div>
  </div>
</div>
{{-- end delete modal  --}}


<div class="row">
<div class="col-lg-4 col-md-4 col-sm-12">
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-6">
          <b>Sizes</b>
        </div>
        <div class="col-6">
          <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
            <button type="button" id="addSize" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-plus"></i> Add</button>
          </div>
        </div>
      </div>
    </div>
        <div class="card-body">
          <div>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Sno</th>
                  <th scope="col">Size</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @php
                $count = 0;
                @endphp
              @foreach($sizes as $list)
                <tr>
                  <td>{{++$count}}</td>
                  <td>{{$list->size}}</td>
                  <td>
                    <button type="button" class="btn btn-info btn-sm editSizeBtn mr-1" value="{{$list->id}}"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-sm deleteSizeBtn ml-1" value="{{$list->id}}"><i class="fas fa-trash"></i></button>
                </td> 
                </tr>
                @endforeach
              </tbody> 
              
            </table>
          </div>
    </div>
  </div>
</div>
{{-- start color div  --}}
<div class="col-lg-4 col-md-4 col-sm-12">
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-6">
          <b>Colors</b>
        </div>
        <div class="col-6">
          <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
            <button type="button" id="addColor" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-plus"></i> Add</button>
          </div>
        </div>
      </div>
    </div>
        <div class="card-body">
          <div>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Sno</th>
                  <th scope="col">Color</th>
                  <th scope="col">Color</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                @php
                $count = 0;
                @endphp
              @foreach($colors as $list)
                <tr>
                  <td>{{++$count}}</td>
                  <td>{{ucwords($list->color)}}</td>
                  <td> <input type="text" disabled style="width:50px;background-color:{{$list->color}};" id="colorinput">
                  </td>
                  <td>
                    <button type="button" class="btn btn-info btn-sm editColorBtn mr-1" value="{{$list->id}}"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-sm deleteColorBtn ml-1" value="{{$list->id}}"><i class="fas fa-trash"></i></button>
                </td> 
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
    </div>
  </div>
  
</div>


</div>
@endsection

@section('script')
    <script>

        $(document).ready(function () {
            $(document).on('click','#addSize', function (e) {
                e.preventDefault();
                $('#sizeModal').modal('show');
                $('#size_err').html('');
                $('#size_err').removeClass('alert alert-danger');
                $("#sizeForm").trigger("reset"); 
                $('#saveSizeBtn').removeClass('hide');
                $('#updateSizeBtn').addClass('hide');
            });

            $(document).on('click','#saveSizeBtn', function (e) {
                e.preventDefault();
                saveSize();
            });
            
            $(document).on('click','.editSizeBtn', function (e) {
                e.preventDefault();
                const size_id = $(this).val();
                // alert(size_id);
                editSize(size_id);
            });

            $(document).on('click','#updateSizeBtn', function (e) {
                e.preventDefault();
                const size_id = $(this).val();
                // alert(size_id);
                updateSize(size_id);
            });
            
            $(document).on('click','.deleteSizeBtn', function (e) {
                e.preventDefault();
                const size_id = $(this).val();
                $('#deleteSizeModal').modal('show');
                $('#yesDeleteSizeBtn').val(size_id);
            });


            $(document).on('click','#yesDeleteSizeBtn', function (e) {
                e.preventDefault();
                const size_id = $(this).val();
                // alert(size_id)
                deleteSize(size_id);
            });

            //color
            $(document).on('click','#addColor', function (e) {
                e.preventDefault();
                $('#colorModal').modal('show');
                $('#color_err').html('');
                $('#color_err').removeClass('alert alert-danger');
                $("#colorForm").trigger("reset"); 
                $('#saveColorBtn').removeClass('hide');
                $('#updateColorBtn').addClass('hide');
            });

            $(document).on('click','#saveColorBtn', function (e) {
                e.preventDefault();
                saveColor();
            });

            $(document).on('click','.editColorBtn', function (e) {
                e.preventDefault();
                const color_id = $(this).val();
                editColor(color_id);
            });

            $(document).on('click','#updateColorBtn', function (e) {
                e.preventDefault();
                const color_id = $(this).val();
                updateColor(color_id);
            });

            $(document).on('click','.deleteColorBtn', function (e) {
                e.preventDefault();
                const color_id = $(this).val();
                $('#deleteColorModal').modal('show');
                $('#yesDeleteColorBtn').val(color_id);
            });

            $(document).on('click','#yesDeleteColorBtn', function (e) {
                e.preventDefault();
                const color_id = $(this).val();
                // alert(size_id)
                deleteColor(color_id);
            });



        });
  
        function saveSize() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#sizeForm")[0]);
            $.ajax({
                type: "post",
                url: "save-size",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    // console.log(response);
                    if (response.status === 400) {
                        $('#size_err').html('');
                        $('#size_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) {
                            $('#size_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                        });

                    } else {
                        $('#size_err').html('');
                        $('#sizeModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        function editSize(size_id){
            $.ajax({
                type: "get",
                url: "edit-size/"+size_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        $('#sizeModal').modal('show');
                        $('#size_err').html('');
                        $('#size_err').removeClass('alert alert-danger');
                        $("#sizeForm").trigger( "reset" ); 
                        $('#saveSizeBtn').addClass('hide');
                        $('#updateSizeBtn').removeClass('hide');
                        $('#size').val(response.size.size);
                        // $('#password').val(response.user.password);

                        $('#updateSizeBtn').val(response.size.id);
                    }
                }
            });
        }

        function updateSize(size_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#sizeForm")[0]);
            $.ajax({
                type: "post",
                url: "update-size/"+size_id,
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    if(response.status === 400)
                    {
                        $('#size_err').html('');
                        $('#size_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) { 
                            $('#size_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                        });

                    }else{
                        $('#size_err').html('');
                        $('#sizeModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }
        
        function deleteSize(size_id){
            $.ajax({
                type: "get",
                url: "delete-size/"+size_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        window.location.reload();
                    }
                }
            });
        }

        // save color code start
        function saveColor() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#colorForm")[0]);
            $.ajax({
                type: "post",
                url: "save-color",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    // console.log(response);
                    if (response.status === 400) {
                        $('#color_err').html('');
                        $('#color_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) {
                            $('#color_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                        });

                    } else {
                        $('#color_err').html('');
                        $('#colorModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        function editColor(color_id){
            $.ajax({
                type: "get",
                url: "edit-color/"+color_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        $('#colorModal').modal('show');
                        $('#color_err').html('');
                        $('#color_err').removeClass('alert alert-danger');
                        $("#colorForm").trigger( "reset" ); 
                        $('#saveColorBtn').addClass('hide');
                        $('#updateColorBtn').removeClass('hide');
                        $('#color').val(response.color.color);

                        $('#updateColorBtn').val(response.color.id);
                    }
                }
            });
        }

        function updateColor(color_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#colorForm")[0]);
            $.ajax({
                type: "post",
                url: "update-color/"+color_id,
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    if(response.status === 400)
                    {
                        $('#color_err').html('');
                        $('#color_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) { 
                            $('#color_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                        });

                    }else{
                        $('#color_err').html('');
                        $('#colorModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }


        function deleteColor(color_id){
            $.ajax({
                type: "get",
                url: "delete-color/"+color_id,
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