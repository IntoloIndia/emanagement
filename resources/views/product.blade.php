@extends('layouts.app')
@section('page_title', 'Dashboard')
@section('style')
<style>
  #colorinput{
    border: none;
  }

  /* @media print {
  h2 { 
    page-break-before: always;
  } */

/* @media print {
    @page {
        size: 300in 200in ;
    }
} */

@media print {
  .page > span {
    font-size: 44px;
  }
  
}


  
</style>
@endsection

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
                                <select id="category_id" name="category_id" class="form-select form-select-sm" onchange="getSubCategoryByCategory(this.value);">
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
                            <div class="col-md-6">
                                <input type="text" name="product_name" id="product_name" class="form-control form-control-sm" placeholder="Product Name">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="qty" id="qty" class="form-control form-control-sm" placeholder="qty">
                            </div>
                            <div class="col-md-3">
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
                            <div class="col-md-2 mt-1">
                                {{-- <input type="text" id="color_name" disabled style="width:50px;background-color:{{$list->color}};" id="colorinput"> --}}
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


<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Delete User </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <h5>Are you sure?</h5>
                        <button type="button" id="yesDeleteProductBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                        <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                    <hr>
                </center>
            </div>
        </div>
    </div>
</div>



<div class="row mb-3 ">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
        <button type="button" id="addProduct" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-plus"></i> Add</button>
    </div>
</div>

<div class="row">
   
    <div class="col-lg-9 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <b>Products</b>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Sno</th>
                            <th scope="col">Code</th>
                            <th scope="col">Product</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Category</th>
                            <th scope="col">Sub category</th>
                            <th scope="col">Price</th>
                            <th scope="col">Size</th>
                            <th scope="col">Color</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        @php
                            $count=0;
                        @endphp
                        <tbody>
                          @foreach ($products as $list)
                              <tr>
                                <td>{{++$count}}</td>
                                <td>{{$list->product_code}}</td>
                                <td>{{ucwords($list->product)}}</td>
                                <td>{{$list->qty}}</td>
                                <td>{{ucwords($list->category)}}</td>
                                <td>{{ucwords($list->sub_category)}}</td>
                                <td>{{$list->price}} </td>
                                <td>{{$list->size}}</td>
                                 <td>
                                 <input type="text" id="color_name" disabled style="width:20px; height:20px; background-color:{{$list->color}};" id="colorinput">

                                </td> 
                                {{-- <td>{{$list->color}}</td> --}}
                                <td>
                                    <button type="button" class="btn btn-info btn-sm editProductBtn mr-1" value="{{$list->id}}"><i class="fas fa-edit"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm deleteProductBtn ml-1" value="{{$list->id}}"><i class="fas fa-trash"></i></button>
                                </td>
                              </tr>
                          @endforeach
                          
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6"><b>Barcodes</b></div>
                    <div class="col-md-6">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                            {{-- <button type="button" id="openBtn" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-print"></i> Preview</button> --}}
                            <button type="button" id="openBtn" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-print"></i> Preview</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body page" id="barcode_body" >
                    @foreach ($products as $list)
                        {{-- <div class="card text-center" style='page-break-after: always; '> --}}
                        <div class="card " >
                            <div class="card-body"style="margin-bottom: 80px; margin-top:80px; ">

                                <div class="row" >
                                    <h1 class="tect-center" style="font-size: 70px; ">MANGALDEEP CLOTHS LLP</h1>
                                </div>
                                <div class="row" >
                                    <div class="col-md-6">
                                        <h1 style="font-size: 70px; ">Prod : {{$list->product_code}}</h1> <br/>
                                        <h1 style="font-size: 70px; ">Sec : {{$list->product_code}}</h1> <br/>
                                        <h1 style="font-size: 70px; ">Sec : {{$list->product_code}}</h1> <br/>
                                        <h1 style="font-size: 70px; ">Sec : {{$list->product_code}}</h1> <br/>
                                    </div>
                                    <div class="col-md-6" >
                                        {{-- <img src="{{$list->barcode}}" ><br/> --}}
                                        <img src="{{asset('public/assets/barcodes/barcode.gif')}}" style="width: 100%; height:100%;">
                                    </div>
                                </div>

                                    {{-- <img src="{{$list->barcode}}" ><br/>
                                    <span><b>{{$list->product_code}}</b></span> <br/>
                                    <span> {{strtoupper($list->size)}} / {{$list->price}}</span>  --}}
                            </div>
                        </div>
                        {{-- </div> --}}
                    @endforeach
            </div>
            {{-- <div class="col-md-12 mb-1">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                    <button type="button" id="printBtn" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-print"></i> Print</button>
                </div>
            </div> --}}
        </div>
    </div>


</div>


{{-- <div class="row">
    <div class="col-12">
        <div class="card-box">
            <div class="header-title"> <a href="#" class="btn btn-info btn-sm" onclick="printDiv('printableArea')" >
                <i class="fa fa-print"></i>
                Print
            </a>
        </div>
        <div class="panel-body" id="printableArea">
            @foreach($products as $product)
            <div class="col-md-2" style="padding: 10px; border: 1px solid #adadad; " align="center">
                <p>{{$product->name}}</p>
                <?php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($product->code, "c128A",1,33,array(1,1,1), true) . '"   />'; ?>
                <br>
                <small style="font-size: 8px !important;"><b>{{$product->code}}</b></small>
                <p style="line-height: 12px !important; font-size: 8px !important;">
                    <b>Price: {{$product->sale_price}} </b>
                </p>
            </div>
            @endforeach     
        </div>
    </div>
</div> --}}

<section>
    <div id="newcontent">
        <div class="modal fade" id="generateBarcodeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Barcodes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="show_barcode_body" style=''>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="printBtn" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
            // $(document).on('change','#color_name', function (e) {
            //     e.preventDefault();
            //     const category_id = $(this).val();
            //     getSubCategoryByCategory(category_id);
                
            // });
            
            $(document).on('click','.editProductBtn', function (e) {
                e.preventDefault();
                const product_id = $(this).val();
                // alert(product_id);
                editProduct(product_id);
            });

            $(document).on('click','#updateProductBtn', function (e) {
                e.preventDefault();
                const product_id = $(this).val();
                // alert(product_id);
                updateProduct(product_id);
            });
            
            $(document).on('click','.deleteProductBtn', function (e) {
                e.preventDefault();
                const product_id = $(this).val();
                // alert(product_id);
                $('#deleteProductModal').modal('show');
                $('#yesDeleteProductBtn').val(product_id);
            });

            $(document).on('click','#yesDeleteProductBtn', function (e) {
                e.preventDefault();
                const product_id = $(this).val();
                // alert(product_id)
                deleteProduct(product_id);
            });


            $(document).on('click','#openBtn', function (e) {
                e.preventDefault();

                var modal_data = $('#barcode_body').html();
                $('#show_barcode_body').html('');
                $('#show_barcode_body').append(modal_data);
                $('#generateBarcodeModal').modal('show');
                
                // getBarcode();
            });



            $(document).on('click','#printBtn', function (e) {
                e.preventDefault();
                // const product_id = $(this).val();
                printBarcode();
            });


        });

        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }

        function getBarcode() {
            $.ajax({
                type: "get",
                url: "barcode",
                dataType: "json",
                success: function (response) {
                    //console.log(response);
                    if (response.status == 200) {
                        $('#generateBarcodeModal').html(response.html);
                        $('#generateBarcodeModal').modal('show');
                    }
                }
            });
        }

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
        function editProduct(product_id){
            $.ajax({
                type: "get",
                url: "edit-product/"+product_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        $('#productModal').modal('show');
                        $('#product_err').html('');
                        $('#product_err').removeClass('alert alert-danger');
                        $("#productForm").trigger( "reset" ); 
                        $('#saveProductBtn').addClass('hide');
                        $('#updateProductBtn').removeClass('hide');
                        $('#category_id').val(response.product.category_id);

                        $('#sub_category_id').html("");
                        $('#sub_category_id').append(response.html);

                        // $('#sub_category_id').val(response.product.sub_category_id);
                        $('#product_name').val(response.product.product);
                        $('#qty').val(response.product.qty);
                        $('#price').val(response.product.price);
                        $('#size_id').val(response.product.size_id);
                        $('#color_id').val(response.product.color_id);
                        // $('#password').val(response.user.password);

                        $('#updateProductBtn').val(response.product.id);
                    }
                }
            });
        }

        function updateProduct(product_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#productForm")[0]);
            $.ajax({
                type: "post",
                url: "update-product/"+product_id,
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    if(response.status === 400)
                    {
                        $('#product_err').html('');
                        $('#product_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) { 
                            $('#product_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                        });

                    }else{
                        $('#product_err').html('');
                        $('#productModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        function deleteProduct(product_id){
            $.ajax({
                type: "get",
                url: "delete-product/"+product_id,
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    if(response.status == 200){
                        window.location.reload();
                    }
                }
            });
        }

        function printBarcode(){
            var backup = document.body.innerHTML;
            var div_content = document.getElementById("show_barcode_body").innerHTML;
            document.body.innerHTML = div_content;
            window.print();
            document.body.innerHTML = backup;

            

            // const section = $("section");
            // // const modalBody = $("#show_barcode_body").detach();
            // const modalBody = document.getElementById("barcode_body").innerHTML;

            // section.empty();
            // section.append(modalBody);
            // window.print();
            // window.location.reload();


            // var print_div = document.getElementById("show_barcode_body");
            // // var print_div = document.getElementById("barcode_body");
            // var print_area = window.open();
            // print_area.document.write(print_div.innerHTML);
            // print_area.document.close();
            // print_area.focus();
            // print_area.print();
          
            window.location.reload();
        }
        
    </script>
@endsection