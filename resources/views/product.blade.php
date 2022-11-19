@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')

{{-- product modal --}}
<div class="modal fade" id="productModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productForm">
                    @csrf
                    <div class="modal-body">
                        <div id="product_err"></div>

                        <div class="row">
                            <div class="col-md-6">
                                <select id="category_id" name="category_id" class="form-select form-select-sm">
                                    <option selected disabled >Category</option>
                                    @foreach ($categories as $list)
                                        <option value="{{$list->id}}">{{ucwords($list->category)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select id="category_id" name="category_id" class="form-select form-select-sm">
                                    <option selected disabled >Sub Category</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-8">
                                <input type="text" name="product_name" id="product_name" class="form-control form-control-sm" placeholder="Product Name">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="price" id="price" class="form-control form-control-sm" placeholder="Price">
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-4">
                                <select id="size_id" name="size_id" class="form-select form-select-sm">
                                    <option selected disabled >Size</option>
                                    {{-- @foreach ($roles as $list)
                                        <option value="{{$list->id}}">{{ucwords($list->role)}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select id="color_id" name="color_id" class="form-select form-select-sm">
                                    <option selected disabled >Choose...</option>
                                    {{-- @foreach ($roles as $list)
                                        <option value="{{$list->id}}">{{ucwords($list->role)}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>

                    </div>
                    {{-- <input type="hidden" name="admin_id" id="admin_id" value=""> --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveProductBtn" class="btn btn-primary btn-sm ">Save </button>
                        <button type="button" id="updateProductBtn" class="btn btn-primary btn-sm hide">Update </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <!-- Button trigger modal -->
    
  
  <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="name" class="form-label">item name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter name">
                        {{-- <p id="dataname"></p> --}}
                    </div>
                    <div class="mb-2">
                        <label for="name" class="form-label">category</label>
                        <select class="form-select form-control" aria-label="Default select example" id="category" >
                            <option selected>category</option>
                            <option value="1">Man</option>
                            <option value="2">Women</option>
                            <option value="3">Kids</option>
                            </select>
                    </div>
                        <div class="mb-2">
                        <label for="name" class="form-label"> sub-category</label>
                        <select class="form-select form-control " aria-label="Default select example" id="sub-category">
                            <option selected>sub-category</option>
                            <option value="1">T-shart</option>
                            <option value="1">Jeens</option>
                            <option value="2">Sadhi</option>
                            <option value="2">kurthi</option>
                            <option value="3">Taf</option>
                            <option value="3">shoot</option>
                            </select>
                        </div>
                        <div class="mb-2">
                        <label for="name" class="form-label">size</label>
                        <select class="form-select form-control " aria-label="Default select example" id="size">
                            <option selected>size</option>
                            <option value="sm">sm</option>
                            <option value="md">md</option>
                            <option value="l">l</option>
                            <option value="xl">xl</option>
                            <option value="xll">xll</option>
                            </select>
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <input type="color" class="form-control" id="color">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <!-- {{-- <input type="text" class="form-control" id="colorname" value="dsfgdfg" disabled> --}} -->
                                <p id="colorname"></p>
                            </div>
                        </div>
                        </div>
                        </div>
                    <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary"onClick='saveData()'>Save</button>
            </form>
            </div>

            </div>
            </div>
        </div>
 </div>
</div>



<div class="row ">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
        <button type="button" id="addProduct" class="btn btn-primary btn-flat btn-sm mt-2"><i class="fas fa-plus"></i> Add</button>
    </div>
</div>

@endsection

@section('script')
    {{-- //   <script src="{{asset('public/sdpl-assets/user/js/slider.js')}}"></script> --}}
    <script>
        $(document).ready(function () {
            $(document).on('click','#addProduct', function (e) {
                e.preventDefault();
                $('#productModal').modal('show');
                $('#product_err').html('');
                $('#product_err').removeClass('alert alert-danger');
                $("#productForm").trigger("reset"); 
                $('#saveProductBtn').removeClass('hide');
                $('#updateProductBtn').addClass('hide');
            });

            $(document).on('click','#saveProductBtn', function (e) {
                e.preventDefault();
                saveProduct();
            });
            
            // $(document).on('click','.editAdminBtn', function (e) {
            //     e.preventDefault();
            //     const admin_id = $(this).val();
            //     editAdmin(admin_id);
            // });

            // $(document).on('click','#updateAdminBtn', function (e) {
            //     e.preventDefault();
            //     const admin_id = $(this).val();
            //     updateAdmin(admin_id);
            // });
            
            // $(document).on('click','.deleteAdminBtn', function (e) {
            //     e.preventDefault();
            //     const admin_id = $(this).val();
            //     $('#deleteAdminModal').modal('show');
            //     $('#yesDeleteAdminBtn').val(admin_id);
            // });

            // $(document).on('click','#yesDeleteAdminBtn', function (e) {
            //     e.preventDefault();
            //     const admin_id = $(this).val();
            //     deleteAdmin(admin_id);
            // });


        });

        
    </script>
@endsection