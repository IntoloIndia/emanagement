@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('style')

    
@endsection

@section('content')

<!-- Button trigger modal -->
  
  <!-- Modal -->

  <div class="modal fade" id="categoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="categoryForm">
              @csrf
              <div class="modal-body">
                  <div id="category_err"></div>
                  {{-- <div class="row"> --}}
                  <div class="row mt-1">
                      <div class="col-md-4">
                          <label for="categoryName" class="form-label">Category</label>
                      </div>
                      <div class="col-md-8">
                          <input type="text" name="category" id="category" placeholder="category name" class="form-control form-control-sm">
                      </div>
                  </div>
                  <div class="row mt-1">
                    <div class="col-md-4">
                        <label for="category_img" class="form-label">image</label>
                    </div>
                    <div class="col-md-8">
                        <input type="file" name="category_img" id="category_img" class="form-control form-control-sm">
                    </div>
                </div>
              </div>
               {{-- <input type="hidden" name="admin_id" id="admin_id" value=""> --}} 
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                  <button type="button" id="saveCategoryBtn" class="btn btn-primary btn-sm ">Save </button>
                  <button type="button" id="updateCategoryBtn" class="btn btn-primary btn-sm hide">Update </button>
              </div>
          </form>
      </div>
      </div>
    </div>
  </div>
  {{-- end category modal  --}}

  {{-- sub category modal  --}}

  <div class="modal fade" id="subCateoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                        <select class="form-select" aria-label="Default select example" id="category_id">
                          <option selected>Other</option>
                          <option value="1">Mans</option>
                          <option value="2">Womens</option>
                          <option value="3">Kids</option>
                        </select>
                      </div>
                  </div>

                  <div class="row mt-1">
                      <div class="col-md-4">
                          <label for="image" class="form-label">image</label>
                      </div>
                      <div class="col-md-8">
                          <input type="file" name="subcategory_img" id="subcategory_img" class="form-control form-control-sm">
                      </div>
                  </div>
                  <div class="row mt-1">
                      <div class="col-md-4">
                          <label for="categoryName" class="form-label">Category</label>
                      </div>
                      <div class="col-md-8">
                          <input type="text" name="category" id="category" class="form-control form-control-sm">
                      </div>
                  </div>
              </div>
               {{-- <input type="hidden" name="admin_id" id="admin_id" value=""> --}} 
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                  <button type="button" id="saveCategoryBtn" class="btn btn-primary btn-sm ">Save </button>
                  <button type="button" id="updateCategoryBtn" class="btn btn-primary btn-sm hide">Update </button>

              </div>
          </form>
      </div>
      </div>
    </div>
  </div>

  {{-- end sub category modal  --}}
<div class="row">
  <div class="col-lg-6 col-md-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-6">
            <b>Category</b>
          </div>
          <div class="col-6">
            <button type="button" class="btn btn-primary btn-sm float-right" data-bs-toggle="modal" data-bs-target="#categoryModal">
              <i class="fas fa-plus"></i> Add 
            </button>
          </div>
        </div>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Sno</th>
              <th scope="col">Image</th>
              <th scope="col">Category</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          @php
           $count = 0;   
          @endphp
          <tbody>
            @foreach ($allCategory as $list)
                <tr>
                  <td>{{++$count}}</td>
                  <td><img src="{{asset('/storage/app/public/'.$list->category_img)}}" alt="image not found" srcset="" width="35" height="35"></td>
                  <td>{{$list->category}}</td>
                  <td>
                    <button type="button" class="btn btn-info btn-sm editCategoryBtn mr-1" value="{{$list->id}}"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-sm deleteCategoryBtn ml-1" value="{{$list->id}}"><i class="fas fa-trash"></i></button>
                </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  {{-- sub category div start// --}}
  <div class="col-lg-6 col-md-12 col-sm-12">
    <div class="card" style="height: 85vh">
      <div class="card-header">
        <div class="row">
          <div class="col-6">
            <b> Sub Category</b>
          </div>
          <div class="col-6">
            <button type="button" class="btn btn-primary btn-sm float-right" data-bs-toggle="modal" data-bs-target="#subCateoryModal">
              <i class="fas fa-plus"></i> Add 
            </button>
            
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
              <th scope="col">Subcategory </th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
          <tr>
            <td>1</td>
            <td><img src="assets/img/avatars/1.png" class="img-fluid" alt="" srcset="" width="35"></td>
            <td>name</td>
            <td>
              <button class="btn btn-primary btn-sm">Edit</button>
              <button class="btn btn-primary btn-sm">Delete</button>
            </td>
          </tr>
          <tr>
            <td>1</td>
            <td><img src="assets/img/avatars/1.png" class="img-fluid" alt="" srcset="" width="35"></td>
            <td>name</td>
            <td>
              <button class="btn btn-primary btn-sm">Edit</button>
              <button class="btn btn-primary btn-sm">Delete</button>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td><img src="assets/img/avatars/7.png" class="img-fluid" alt="" srcset="" width="35"></td>
            <td>Mans</td>
            <td>
              {{-- <i class="fa-solid fa-pen-to-square"></i> --}}
              {{-- <i class="bi bi-pencil-square"></i> --}}
              {{-- <i class="bi bi-trash"></i> --}}
              <button class="btn btn-primary btn-sm">Edit</button>
              <button class="btn btn-primary btn-sm">Delete</button>
            </td>
          </tr>
          </tbody>
        </table>
        </div>
          </div>
        </div>
        
      </div>
    </div>
  </div>
  {{-- sub category div end  --}}
</div>
@endsection


@section('script')
{{-- <script src="{{asset('public/sdpl-assets/user/js/slider.js')}}"></script> --}}
<script>
    $(document).ready(function () {
            $(document).on('click','#addAdmin', function (e) {
                e.preventDefault();
                $('#categoryModal').modal('show');
                $('#category_err').html('');
                $('#category_err').removeClass('alert alert-danger');
                $("#categoryForm").trigger("reset"); 
                $('#saveCategoryBtn').removeClass('hide');
                $('#updateCategoryBtn').addClass('hide');
            });

            $(document).on('click','#saveCategoryBtn', function (e) {
                e.preventDefault();
                // alert('dd')
                saveCategory();
                
            });
    }) 
    
    function saveCategory() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#categoryForm")[0]);
            $.ajax({
                type: "post",
                url: "save-category",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    // console.log(response);
                    if (response.status === 400) {
                        $('#category_err').html('');
                        $('#category_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) {
                            $('#category_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                        });

                    } else {
                        $('#category_err').html('');
                        $('#categoryModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

    
</script>
@endsection