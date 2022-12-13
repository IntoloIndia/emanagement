@extends('layouts.app')
@section('page_title', 'Brand')

@section('content')
@include('layouts.common_modal')
<div class="row mb-2">
    <div class="col-12">
      <button type="button" id="addBrandBtn" class="btn btn-primary float-right btn-flat btn-sm mt-2"><i class="fas fa-plus"></i> Add</button>
    </div>
</div>


 {{-- delete modal start  --}}

 <div class="modal fade" id="deleteBrandModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Delete Brand </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <h5>Are you sure?</h5>
                        <button type="button" id="yesdeleteBrandBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                        <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                    <hr>
                </center>
            </div>
        </div>
    </div>
  </div>

{{-- delete modal end  --}}

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <b>Table</b>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Brand</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        @php
                          $count = 0;  
                        @endphp
                        <tbody>
                            @foreach ($brands as $list)
                            <tr>
                              <td>{{++$count}}</td>
                              <td>{{$list->brand_name}}</td> 
                              <td> 
                                <button type="button" class="btn btn-info btn-sm editBrandBtn mr-1" value="{{$list->id}}"><i class="fas fa-edit"></i></button>
                               <button type="button" class="btn btn-danger btn-sm deleteBrandBtn ml-1" value="{{$list->id}}"><i class="fas fa-trash"></i></button> 
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
        $(document).ready(function(){
            $(document).on('click','#addBrandBtn',function(e)
            {
                e.preventDefault();
                $('#brandModal').modal('show');
                $('#brand_err').html('');
                $('#brand_err').removeClass('alert alert-danger');
                $('#brandForm').trigger('reset');
                $('#saveBrandBtn').removeClass('hide');
                $('#updateBrandBtn').addClass('hide');
            });

            $(document).on('click','#saveBrandBtn', function (e) {
                e.preventDefault();
                // alert('dd')
                saveBrand();
                
            });

            $(document).on('click','.editBrandBtn', function (e) {
                e.preventDefault();
                const brand_id = $(this).val();
                editDepartment(brand_id);
            });

            $(document).on('click','#updateBrandBtn', function (e) {
                e.preventDefault();
                const brand_id = $(this).val();
                updateDepartment(brand_id);
            });

            $(document).on('click','.deleteBrandBtn', function (e) {
                e.preventDefault();
                const brand_id = $(this).val();
                // alert(brand_id)
                $('#deleteBrandModal').modal('show');
                $('#yesdeleteBrandBtn').val(brand_id);
            });

            $(document).on('click','#yesdeleteBrandBtn', function (e) {
                e.preventDefault();
                const brand_id = $(this).val();
                deleteBrand(brand_id);
            });
        });

        function saveBrand() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#brandForm")[0]);
            $.ajax({
                type: "post",
                url: "save-brand",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    // console.log(response);
                    if (response.status === 400) {
                        $('#brand_err').html('');
                        $('#brand_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) {
                            $('#brand_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                        });

                    } else {
                        $('#brand_err').html('');
                        $('#brandModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        function editDepartment(brand_id){
            $.ajax({
                type: "get",
                url: "edit-brand/"+brand_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        $('#brandModal').modal('show');
                        $('#brand_err').html('');
                        $('#brand_err').removeClass('alert alert-danger');
                        $("#brandForm").trigger( "reset" ); 
                        $('#saveBrandBtn').addClass('hide');
                        $('#updateBrandBtn').removeClass('hide');

                        $('#brand_name').val(response.brand.brand_name);
                        $('#updateBrandBtn').val(response.brand.id);
                    }
                }
            });
        }

        function updateDepartment(brand_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#brandForm")[0]);
            $.ajax({
                type: "post",
                url: "update-brand/"+brand_id,
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    if(response.status === 400)
                    {
                        $('#brand_err').html('');
                        $('#brand_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) { 
                            $('#brand_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                        });

                    }else{
                        $('#brand_err').html('');
                        $('#brandModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }


        function deleteBrand(brand_id){
            $.ajax({
                type: "get",
                url: "delete-brand/"+brand_id,
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