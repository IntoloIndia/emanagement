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
                                    <option value="{{$list->id}}"> {{ucwords($list->category)}} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select id="sub_category_id" name="sub_category_id" class="form-select form-select-sm">
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
                                    @foreach ($sizes as $list)
                                        <option value="{{$list->id}}">{{ucwords($list->size)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select id="color_id" name="color_id" class="form-select form-select-sm">
                                    <option selected disabled >Choose...</option>
                                    @foreach ($colors as $list)
                                        <option value="{{$list->id}}">{{ucwords($list->color)}}</option>
                                    @endforeach
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

<div class="row ">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
        <button type="button" id="addProduct" class="btn btn-primary btn-flat btn-sm mt-2"><i class="fas fa-plus"></i> Add</button>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Products</h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0" style="height: 450px;">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Size</th>
                            <th>Color</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{$count = "";}}
                        {{-- @foreach ($admins as $list)
                            <tr>
                                <td>{{++$count}}</td>
                                <td>{{($list->role_id == MyApp::ADMINISTRATOR) ? "Administrator" : "Billing" }}</td>
                                <td>{{ucwords($list->name)}}</td>
                                <td>{{$list->email}}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm editAdminBtn mr-1" value="{{$list->id}}"><i class="fas fa-edit"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm deleteAdminBtn ml-1" value="{{$list->id}}"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>

        </div>
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
                // let productCode = Math.floor((Math.random() * 1000000) + 1);
                // alert(productCode);
                saveProduct();
            });

            $(document).on('change','#category_id', function (e) {
                e.preventDefault();
                const category_id = $(this).val();
                getSubCategoryByCategory(category_id);
                
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

        function saveProduct() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#productForm")[0]);
            $.ajax({
                type: "post",
                url: "save-product",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    // console.log(response);
                    if (response.status === 400) {
                        $('#producat_err').html('');
                        $('#producat_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) {
                            $('#producat_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                        });

                    } else {
                        $('#producat_err').html('');
                        $('#productModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        
    </script>
@endsection