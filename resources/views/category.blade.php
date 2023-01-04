@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('style')

  <style>
    @media screen {
            #printSection {
                display: none;
            }
        }

        @media print {
            body * {
                visibility:hidden;
                
            }
            #printSection, #printSection * {
                visibility:visible;
                
                
            }
            #printSection {
                position:absolute;
                left:0;
                top:0;
                width: 100%;
                height: ;
            }
        }

        hr{
            color: black;
            opacity: initial;
            margin: 5px;
        }
        .table td{
          padding: 2px 5px;
        }
  </style>
    
@endsection

@section('content')

<!-- Button trigger modal -->
  
  <!-- Modal -->

  <div class="modal fade" id="categoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Category</h5>
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
                    <div class="row mt-1"></div>
                      <div class="col-md-4"></div>
                    <div class="col-md-8">
                      {{-- <img src="/storage/app/public/" alt="no image" class="hide" srcset="" id="category_img_update"> --}}
                      {{-- <input type="text" name="category_img" id="category_img_update" class="hide form-control form-control-sm"> --}}
                  </div>

                  <div class="row">

                    <div class="col-md-4">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="size_type" id="normal_size" value="{{MyApp::NORMAL_SIZE}}" checked> 
                        <label class="form-check-label">Normal Size</label>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="size_type" id="kids_size" value="{{MyApp::KIDS_SIZE}}"> 
                        <label class="form-check-label">Kids Size</label>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="size_type" id="without_size" value="{{MyApp::WITHOUT_SIZE}}"> 
                        <label class="form-check-label">Without Size</label>
                      </div>
                    </div>
                    
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

  {{-- delete category modal  --}}

  <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Delete User </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <h5>Are you sure?</h5>
                        <button type="button" id="yesdeleteCategoryBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                        <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                    <hr>
                </center>
            </div>
        </div>
    </div>
</div>

{{-- end category modal  --}}
<div class="row mb-2">
  <div class="col-12">
    <button type="button" id="addCategory" class="btn btn-primary float-right btn-flat btn-sm mt-2"><i class="fas fa-plus"></i> Add</button>
  </div>
</div>

<div class="row">
  <div class="col-lg-6 col-md-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        {{-- <div class="row">
          <div class="col-6"> --}}
            <b>Category</b>
          {{-- </div> --}}
          
        {{-- </div> --}}
      </div>
      <div class="card-body table-responsive p-0" style="height: 500px;">
        <table class="table table-head-fixed text-nowrap">
          <thead>
            <tr>
              <th scope="col">Sno</th>
              <th scope="col">Image</th>
              <th scope="col">Category</th>
              <th scope="col">Size Type</th>
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
                  <td>
                    @if ($list->category_img != null)
                      <a href="{{asset('/storage/app/public/'.$list->category_img)}}" target="_blank">
                      <img src="{{asset('/storage/app/public/'.$list->category_img)}}"  alt="image not found" srcset="" class="card-img-top img-thumbnail img-wh-40" style="cursor:pointer"></a></td>
                    @else
                      <img src="{{asset('public/assets/images/icons/jpg-file.png')}}"  alt="image not found" srcset="" class="card-img-top img-thumbnail img-wh-40" style="cursor:pointer"></a></td>
                    @endif
                  <td>{{$list->category}}</td>
                  <td>
                    @if ($list->size_type == MyApp::NORMAL_SIZE)
                        {{"Normal Size"}}
                    @elseif($list->size_type == MyApp::KIDS_SIZE)
                        {{"Kids Size"}}
                    @else
                        {{"Without Size"}}
                    @endif
                  </td>
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

  {{-- sub category div end  --}}
</div>


{{-- <div class="modal fade" id="generatePurchaseInvoiceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Purchase Invoice</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div id="show_purchase_invoice"> </div>


              <div class='row'>
                  <div class='col-sm-12 text-center'>
                      <h5 class='modal-title'><b>Shree Navkar Private Limited </b></h5>
                  </div>

                  <div class='col-sm-12 text-center'>
                    <small class='modal-title'>
                      <b>95A Techno Park, First Floor </b><br>
                      <b>Jabalpur - 482003 </b><br>
                    </small>
                  </div>
                  <div class='col-sm-6 '>
                    <small class='modal-title'>
                      <b>GSTNO -  </b> 1245GDFTE4587<br>
                      <b>PAN -  </b> AVT12547GH<br>
                    </small>
                  </div>
                  <div class='col-sm-6 text-right'>
                    <small class='modal-title'>
                      <b>Mobile -  </b> 1236589547<br>
                      <b>Email -  </b> abc@gmail.com<br>
                    </small>
                  </div>

              </div>
              
              <div class='row'>
                
                <div class='card text-dark bg-light mt-2' >
                  <div class='card-header text-center'><b>TAX INVOICE</b></div>
                  <div class='card-body'>
                      <div class='row'>
                        <div class='col-md-6'>
                          <small class='modal-title'>
                            <b>Mangaldeep (Jabalpur) </b> <br>
                            Samdariya Mall Jabalpur-482002<br>
                            <b>GSTNO -  </b> 1245GDFTE4587<br>
                            
                          </small>
                        </div>
                        <div class='col-md-6'>
                          <small class='modal-title'>
                            <b>Invoice No -  </b> 1245GDFTE4587<br>
                            <b>Invoice Date -  </b> 17-12-22<br>
                            
                          </small>
                        </div>
                      </div>
                  </div>
                </div>
                
              </div>

              <div class='row'>
                  <table class='table table-bordered border-dark'>
                      <thead>
                          <tr>
                              <th>SN</th>
                              <th>Description</th>
                              <th>Style No</th>
                              <th>Size</th>
                              <th>Qty</th>
                              <th>Price</th>
                              <th>SGST</th>
                              <th>CGST</th>
                              <th>IGST</th>
                              <th>Amount</th>
                          </tr>
                      </thead>
    
                      <tbody>
                          <tr>
                              <td>1</td>
                              <td>Jeans</td>
                              <td>A-125-AK</td>
                              <td>S</td>
                              <td>4</td>
                              <td>799</td>
                              <td>0</td>
                              <td>0</td>
                              <td>0</td>
                              <td>3196</td>
                          </tr>
                          <tr>
                              <td>2</td>
                              <td>Jeans</td>
                              <td>A-125-AK</td>
                              <td>M</td>
                              <td>4</td>
                              <td>899</td>
                              <td>0</td>
                              <td>0</td>
                              <td>0</td>
                              <td>3596</td>
                          </tr>
                          
                        </tbody>
    
                      <tfoot>
                          <tr>
                              <td colspan='8' rowspan='6'  class='align-top'> Amount in Words : 
                                  <textarea class='form-control' name='amount_in_words' id='amount_in_words'></textarea>
                              </td>  
                              <td  class='col-sm-2'>Subtotal :</td>
                              <td  class='col-sm-2'><input type='text' name='sub_total' id='sub_total' class='form-control form-control-sm' placeholder='' readonly></td></td>
                          </tr> 
                          <tr>
                              <td>SGST :</td>
                              <td  class='col-sm-2'><input class='form-control form-control-sm' name='sgst_amount' id='sgst_amount' type='text' placeholder='' readonly></td>
                          </tr>
                          <tr> 
                              <td>CGST : </td>
                              <td  class='col-sm-2'><input class='form-control form-control-sm' name='cgst_amount' id='cgst_amount' type='text' placeholder='' readonly></td>
                          </tr>
                          <tr>
                              <td>IGST :</td>
                              <td  class='col-sm-2'><input class='form-control form-control-sm' name='sgst_amount' id='sgst_amount' type='text' placeholder='' readonly></td>
                          </tr>
                          <tr>
                              <td>Grand Total :</td>
                              <td  class='col-sm-2'><input class='form-control form-control-sm' name='grand_total' id='grand_total' type='text' readonly ></td>
                          </tr>
                          
                      </tfoot>
    
                  </table>
              </div>


          </div>


          <div class="modal-footer">
              <button type="button" class="btn btn-primary btn-sm float-end" onClick="printPurchaseInvoice()">Print</button>
          </div>
      </div>
  </div>
</div>   --}}



@endsection


@section('script')
{{-- <script src="{{asset('public/sdpl-assets/user/js/slider.js')}}"></script> --}}
<script>
    $(document).ready(function () {
            $(document).on('click','#addCategory', function (e) {
                e.preventDefault();
                $('#categoryModal').modal('show');
                // $('#generatePurchaseInvoiceModal').modal('show');
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

             $(document).on('click','.editCategoryBtn', function (e) {
                e.preventDefault();
                const category_id = $(this).val();
                // alert(category_id);
                editCategory(category_id);
            });

            $(document).on('click','#updateCategoryBtn', function (e) {
                e.preventDefault();
                const category_id = $(this).val();
                updateCategoey(category_id);
                // alert(category_id);
            });

            $(document).on('click','.deleteCategoryBtn', function (e) {
                e.preventDefault();
                const category_id = $(this).val();
                $('#deleteCategoryModal').modal('show');
                $('#yesdeleteCategoryBtn').val(category_id);
            });

            $(document).on('click','#yesdeleteCategoryBtn', function (e) {
                e.preventDefault();
                const category_id = $(this).val();
                deleteCategory(category_id);
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


        function editCategory(category_id){
            $.ajax({
                type: "get",
                url: "edit-category/"+category_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        $('#categoryModal').modal('show');
                        $('#category_err').html('');
                        $('#category_err').removeClass('alert alert-danger');
                        $("#categoryForm").trigger( "reset" ); 
                        $('#saveCategoryBtn').addClass('hide');
                        $('#updateCategoryBtn').removeClass('hide');
                        // $('#category_img_update').removeClass('hide');

                        $('#category').val(response.category.category);
                        // $('#category_img_update').val(response.category.category_img);
                        $('#updateCategoryBtn').val(response.category.id);
                    }
                }
            });
        }

        function updateCategoey(category_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#categoryForm")[0]);
            $.ajax({
                type: "post",
                url: "update-category/"+category_id,
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    if(response.status === 400)
                    {
                        $('#category_err').html('');
                        $('#category_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) { 
                            $('#category_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                        });

                    }else{
                        $('#category_err').html('');
                        $('#categoryModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }



        // delete  category 
        function deleteCategory(category_id){
            $.ajax({
                type: "get",
                url: "delete-category/"+category_id,
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