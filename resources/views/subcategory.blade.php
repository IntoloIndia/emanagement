@extends('layouts.app')
@section('page_title', 'Dashboard')
@section('style')
  
@endsection

@section('content')
{{-- modal open subcategory modal  --}}

<div class="modal fade" id="subCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel"> sub-category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <form id="subcategoryForm">
              @csrf
              <div class="modal-body">
                  <div id="subcategory_err"></div>
                  {{-- <div class="row"> --}}
                    <div class="row mt-1">
                      <div class="col-md-4">
                          <label for="select_category" class="form-label">select category</label>
                      </div>
                      <div class="col-md-8">
                        <select class="form-select form-select-sm" aria-label="Default select example" name="category_id" id="category_id">
                          <option selected>Other</option>
                          @foreach ($allCategory as $list)
                          <option value="{{$list->id}}">{{ucwords($list->category)}}</option>
                          @endforeach
                        </select>
                      </div>
                  </div>

                  <div class="row mt-1">
                      <div class="col-md-4">
                          <label for="sub categoryName" class="form-label">sub Category</label>
                      </div>
                      <div class="col-md-8">
                          <input type="text" name="sub_category" id="sub_category" placeholder="subcategory" class="form-control form-control-sm">
                      </div>
                  </div>
                  <div class="row mt-1">
                    <div class="col-md-4">
                        <label for="image" class="form-label">image</label>
                    </div>
                    <div class="col-md-8">
                        <input type="file" name="sub_category_img" id="sub_category_img" class="form-control form-control-sm">
                    </div>
                    <div class="row mt-1"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <input type="text" name="sub_category_img_update" id="sub_category_img_update" class="hide form-control form-control-sm">
                        </div>
                </div>
              </div>
               {{-- <input type="hidden" name="admin_id" id="admin_id" value=""> --}} 
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                  <button type="button" id="savesubCategoryBtn" class="btn btn-primary btn-sm ">Save </button>
                  <button type="button" id="updatesubCategoryBtn" class="btn btn-primary btn-sm hide">Update </button>

              </div>
          </form>
      </div>
      </div>
    </div>
</div>

{{-- end modal sub category  --}}


  {{-- delete category modal  --}}

  <div class="modal fade" id="deletesubCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Delete User </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <h5>Are you sure?</h5>
                        <button type="button" id="yesdeletesubCategoryBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                        <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                    <hr>
                </center>
            </div>
        </div>
    </div>
</div>

{{-- end category modal  --}}
<div class="row ">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
        <button type="button" id="addSubCategory" class="btn btn-primary btn-flat btn-sm mt-2"><i class="fas fa-plus"></i> Add</button>
    </div>
</div>

<div class="row">
    <div class="col-lg-4 col-md-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-6">
            <b> Sub Category</b>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-6">
                <b>Category</b>
              </div>
              <div class="col-6">
                <button class="btn btn-primary btn-sm float-right"> <i class="fas fa-plus"></i> Add</button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive" style="max-height: 200px">
           <table class="table">
          <thead>
            <tr>
              <th scope="col">Sno</th>
              <th scope="col">Image</th>
              <th scope="col">Category</th>
              <th scope="col">Subcategory</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          @php
              $count =0;
          @endphp
          <tbody>
          @foreach ($allSubCategory as $list)
              <tr>
                <td>{{++$count}}</td>
                <td>
                    <a href="{{asset('/storage/app/public/'.$list->sub_category_img)}}" target="_blank">
                    <img src="{{asset('/storage/app/public/'.$list->sub_category_img)}}"  alt="image not found" srcset="" class="card-img-top img-thumbnail img-wh-40" style="cursor:pointer"></a></td>
                    <td>{{ucwords($list->category_id)}}</td>
                    <td>{{ucwords($list->sub_category)}}</td>
                  <td>
                    <button type="button" class="btn btn-info btn-sm editsubCategoryBtn mr-1" value="{{$list->id}}"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-sm deletesubCategoryBtn ml-1" value="{{$list->id}}"><i class="fas fa-trash"></i></button>
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
  </div>
    
</div>



@endsection

@section('script')
<script>
    $(document).ready(function () {
            $(document).on('click','#addSubCategory', function (e) {
                e.preventDefault();
                $('#subCategoryModal').modal('show');
                $('#subcategory_err').html('');
                $('#subcategory_err').removeClass('alert alert-danger');
                $("#subcategoryForm").trigger("reset"); 
                $('#savesubCategoryBtn').removeClass('hide');
                $('#updatesubCategoryBtn').addClass('hide');
                $('#sub_category_img_update').addClass('hide');
                
            });

            $(document).on('click','#savesubCategoryBtn', function (e) {
                e.preventDefault();
                // alert('dd')
                saveSubCategory();
            });

            $(document).on('click','.editsubCategoryBtn', function (e) {
                e.preventDefault();
                const sub_category_id = $(this).val();
                // alert(sub_category_id);
                editSubCategory(sub_category_id);
            });

            $(document).on('click','#updatesubCategoryBtn', function (e) {
                e.preventDefault();
                const sub_category_id = $(this).val();
                updateSubCategoey(sub_category_id);
                // alert(sub_category_id);
            });


            $(document).on('click','.deletesubCategoryBtn', function (e) {
                e.preventDefault();
                const sub_category_id = $(this).val();
                $('#deletesubCategoryModal').modal('show');
                $('#yesdeletesubCategoryBtn').val(sub_category_id);
            });

            $(document).on('click','#yesdeletesubCategoryBtn', function (e) {
                e.preventDefault();
                const sub_category_id = $(this).val();
                // alert(sub_category_id);
                deleteSubCategory(sub_category_id);
            });
    })

    function saveSubCategory() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#subcategoryForm")[0]);
            $.ajax({
                type: "post",
                url: "save-sub-category",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    // console.log(response);
                    if (response.status === 400) {
                        $('#subcategory_err').html('');
                        $('#subcategory_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) {
                            $('#subcategory_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                        });

                    } else {
                        $('#subcategory_err').html('');
                        $('#subCategoryModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

       
        function editSubCategory(sub_category_id){
            $.ajax({
                type: "get",
                url: "edit-sub-category/"+sub_category_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        $('#subCategoryModal').modal('show');
                        $('#subcategory_err').html('');
                        $('#subcategory_err').removeClass('alert alert-danger');
                        $("#subcategoryForm").trigger( "reset" ); 
                        $('#savesubCategoryBtn').addClass('hide');
                        $('#updatesubCategoryBtn').removeClass('hide');
                        $('#sub_category_img_update').removeClass('hide');

                        $('#category_id').val(response.sub_category.category_id);
                        $('#sub_category').val(response.sub_category.sub_category);
                        $('#sub_category_img_update').val(response.sub_category.sub_category_img);
                        $('#updatesubCategoryBtn').val(response.sub_category.id);
                    }
                }
            });
        }

        function updateSubCategoey(sub_category_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#subcategoryForm")[0]);
            $.ajax({
                type: "post",
                url: "update-sub-category/"+sub_category_id,
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    if(response.status === 400)
                    {
                        $('#subcategory_err').html('');
                        $('#subcategory_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) { 
                            $('#subcategory_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                        });

                    }else{
                        $('#subcategory_err').html('');
                        $('#subCategoryModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }


        function deleteSubCategory(sub_category_id){
            $.ajax({
                type: "get",
                url: "delete-sub-category/"+sub_category_id,
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