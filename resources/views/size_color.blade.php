@extends('layouts.app')
@section('page_title', 'Dashboard')

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
                                <input type="color" name="color" id="color" class="form-control form-control-sm" placeholder="Color">
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
                  <td><Button class="btn btn-info btn-sm" id="updateSize">edit</Button>
                    <Button class="btn btn-danger btn-sm">Delete</Button>
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
                  <td>{{$list->color}}</td>
                  <td>
                    <i class="fas fa-pen" style="width:30px;color:blue" id="updateBtn"></i>
                    <i class=" fa fa-trash" style="width:30px;color:red"></i>
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
            
            // $(document).on('click','.editSizeBtn', function (e) {
            //     e.preventDefault();
            //     const size_id = $(this).val();
            //     editSize(size_id);
            // });

            // $(document).on('click','#updateSizeBtn', function (e) {
            //     e.preventDefault();
            //     const size_id = $(this).val();
            //     updateSize(size_id);
            // });
            
            // $(document).on('click','.deleteSizeBtn', function (e) {
            //     e.preventDefault();
            //     const size_id = $(this).val();
            //     $('#deleteSizeModal').modal('show');
            //     $('#yesDeleteSizeBtn').val(size_id);
            // });

            // $(document).on('click','#yesDeleteSizeBtn', function (e) {
            //     e.preventDefault();
            //     const size_id = $(this).val();
            //     deleteSize(size_id);
            // });

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


</script>
@endsection