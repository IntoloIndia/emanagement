@extends('layouts.app')
@section('page_title', 'Dashboard')


@section('style')


@endsection

@section('content')

  <div class="row mb-2">
    <div class="col-12">
        <button type="button" id="addDiscount" class="btn btn-primary btn-sm float-right " data-bs-toggle="modal" >
          <i class="fas fa-plus"></i> Discount
          </button>
    </div>
   </div>

  <!-- Modal -->
  <div class="modal fade" id="discountModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Discount</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="discountForm">
              @csrf
              <div class="modal-body">
                  <div id="discount_err"></div>
                  {{-- <div class="row"> --}}
                  <div class="row mt-1">
                      <div class="col-md-4">
                          <label for="DiscountName" class="form-label">Discount</label>
                      </div>
                      <div class="col-md-8">
                          <input type="text" name="discount" id="discount" placeholder="Discount" class="form-control form-control-sm">
                      </div>
                  </div>
                 
              </div>
               {{-- <input type="hidden" name="admin_id" id="admin_id" value=""> --}} 
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                  <button type="button" id="saveDiscountBtn" class="btn btn-primary btn-sm ">Save </button>
                  <button type="button" id="updateDiscountBtn" class="btn btn-primary btn-sm hide">Update </button>
              </div>
          </form>
      </div>
      </div>
    </div>
</div>

    {{-- delete modal start  --}}

    <div class="modal fade" id="deleteDiscountModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel"> Delete User </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <center>
                      <h5>Are you sure?</h5>
                          <button type="button" id="yesdeleteDiscountBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                          <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                      <hr>
                  </center>
              </div>
          </div>
      </div>
    </div>
  
  {{-- delete modal end  --}}

{{-- body --}}

<div class="row">
  <div class="col-lg-4 col-md-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        
            <b>Discount</b>
          
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Sno</th>
              <th scope="col">Discount</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          @php
           $count = 0;   
          @endphp
          <tbody>
            @foreach ($discounts as $list)
                <tr>
                  <td>{{++$count}}</td>
                  <td>{{$list->discount}}%</td> 
                  <td> 
                    <button type="button" class="btn btn-info btn-sm editDiscountBtn mr-1" value="{{$list->id}}"><i class="fas fa-edit"></i></button>
                   <button type="button" class="btn btn-danger btn-sm deleteDiscountBtn ml-1" value="{{$list->id}}"><i class="fas fa-trash"></i></button> 
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
            $(document).on('click','#addDiscount', function (e) {
                e.preventDefault();
                $('#discountModal').modal('show');
                $('#discount_err').html('');
                $('#discount_err').removeClass('alert alert-danger');
                $("#discountForm").trigger("reset"); 
                $('#saveDiscountBtn').removeClass('hide');
                $('#updateDiscountBtn').addClass('hide');
               
               
                
            });

            $(document).on('click','#saveDiscountBtn', function (e) {
                e.preventDefault();
                // alert('dd')
                saveDiscount();
                
            });

            $(document).on('click','.editDiscountBtn', function (e) {
                e.preventDefault();
                const discount_id = $(this).val();
                // alert(category_id);
                editDiscount(discount_id);
            });

            $(document).on('click','#updateDiscountBtn', function (e) {
                e.preventDefault();
                const discount_id = $(this).val();
                updateDiscount(discount_id);
                // alert(category_id);
            });

            $(document).on('click','.deleteDiscountBtn', function (e) {
                e.preventDefault();
                const discount_id = $(this).val();
                $('#deleteDiscountModal').modal('show');
                $('#yesdeleteDiscountBtn').val(discount_id);
            });

            $(document).on('click','#yesdeleteDiscountBtn', function (e) {
                e.preventDefault();
                const discount_id = $(this).val();
                deleteDiscount(discount_id);
            });
        });

        function saveDiscount() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#discountForm")[0]);
            $.ajax({
                type: "post",
                url: "save-discount",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    // console.log(response);
                    if (response.status === 400) {
                        $('#discount_err').html('');
                        $('#discount_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) {
                            $('#discount_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                        });

                    } else {
                        $('#discount_err').html('');
                        $('#discountModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        function editDiscount(discount_id){
            $.ajax({
                type: "get",
                url: "edit-discount/"+discount_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        $('#discountModal').modal('show');
                        $('#discount_err').html('');
                        $('#discount_err').removeClass('alert alert-danger');
                        $("#discountForm").trigger( "reset" ); 
                        $('#saveDiscountBtn').addClass('hide');
                        $('#updateDiscountBtn').removeClass('hide');
                        // $('#category_img_update').removeClass('hide');

                        $('#discount').val(response.discount.discount);
                        $('#updateDiscountBtn').val(response.discount.id);
                    }
                }
            });
        }

        function updateDiscount(discount_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#discountForm")[0]);
            $.ajax({
                type: "post",
                url: "update-discount/"+discount_id,
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    if(response.status === 400)
                    {
                        $('#discount_err').html('');
                        $('#discount_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) { 
                            $('#discount_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                        });

                    }else{
                        $('#discount_err').html('');
                        $('#discountModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        function deleteDiscount(discount_id){
            $.ajax({
                type: "get",
                url: "delete-discount/"+discount_id,
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