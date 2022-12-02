@extends('layouts.app')
@section('page_title', 'Purchase Entry')
@section('style')

<link rel="stylesheet" media="print" href="{{asset('public/assets/css/print.css')}}" />
<style>

  #colorinput{
    border: none;
    background-color": "yellow";
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

.barcode{
    length:100%;
    width:100%;
}
 
</style>
@endsection

@section('content')

{{-- product modal --}}
<div class="modal fade" id="purchaseEntryModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Purchase Entry Voucher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="purchaseEntryForm">
                    @csrf
                    <div class="modal-body">
                        <div id="purchase_entry_err"></div>
                        <div class="row">

                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-4">
                                        <select id="supplier_id" name="supplier_id" class="form-select form-select-sm" onchange="supplierDetail(this.value);">
                                            <option selected disabled >Supplier</option>
                                            @foreach ($suppliers as $list)
                                                <option value="{{$list->id}}"> {{ucwords($list->supplier_name)}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text"  name="gst_no"  id="gst_no" class="form-control form-control-sm" placeholder="GSTIN" readonly disabled>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="hsn_code" id="hsn_code" class="form-control form-control-sm" placeholder="HSN code" readonly disabled>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="bill_no"  id="bill_no" class="form-control form-control-sm" placeholder="Bill no">
                                    </div>
                                </div>
        
                                <div class="row mt-3">
                                    
                                    <div class="col-md-3">
                                        <select id="category_id" name="category_id" class="form-select form-select-sm" onchange="getSubCategoryByCategory(this.value);">
                                            <option selected disabled >Category</option>
                                            @foreach ($categories as $list)
                                            <option value="{{$list->id}}"> {{ucwords($list->category)}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="sub_category_id" name="sub_category_id" class="form-select form-select-sm">
                                            <option selected disabled >Sub Category</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="product_name" id="product_name" class="form-control form-control-sm" placeholder="Product Name">
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" name="qty" id="qty" class="form-control form-control-sm" placeholder="Qty" min="1" value="1">
                                    </div>
                                </div>
                               
                                <div class="row mt-3">
                                    <div class="col-md-2">
                                        <select id="size_id" name="size_id" class="form-select form-select-sm">
                                            <option selected disabled >Size</option>
                                            @foreach ($sizes as $list)
                                                <option value="{{$list->id}}">{{ucwords($list->size)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="color_id" name="color_id" class="form-select form-select-sm color_code">
                                            <option selected disabled >Color..</option>
                                            @foreach ($colors as $list)
                                            <option value="{{$list->id}}">{{ucwords($list->color)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="purchase_price"  id="purchase_price" class="form-control form-control-sm" placeholder="Purchase price">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text"  name="sales_price" id="sales_price" class="form-control form-control-sm" placeholder="Sales price">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div id="take_photo">
                                    <img class="card-img-top img-thumbnail after_capture_frame" src="{{asset('public/assets/images/image.png')}}" />
                                </div>                                
                                <input type="hidden" name="product_image" id="product_image">
                                <div class="d-grid gap-2 mt-2">
                                    <button class="btn btn-primary btn-sm" id="captureLivePhotoBtn" type="button">Live Camera</button>
                                </div>
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



{{-- camera modal start --}}
<!--Modal-->

<div class="modal fade" id="captureLivePhotoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Take Live Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="my_camera" class="card pre_capture_frame" ></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm float-end" onClick="takePhoto()">Take</button>
            </div>
        </div>
    </div>
</div>

{{-- camera modal end --}}

<div class="row mb-3 ">
    <div class="col-12">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
            <button type="button" id="purchaseEntry" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-plus"></i> Purchase Entry</button>
        </div>
    </div>
</div>

<div class="row">
   
    <div class="col-lg-9 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <b>Purchase</b>
            </div>
            <div class="card-body">
                <div class="table-responsive p-0" style="height: 600px;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                          <tr>
                            <th scope="col">Sno</th>
                            <th scope="col">Code</th>
                            <th scope="col">Supplier</th>
                            <th scope="col">Category</th>
                            <th scope="col">Sub category</th>
                            <th scope="col">Product</th>
                            {{-- <th scope="col">Qty</th> --}}
                            <th scope="col">Purchaes Price</th>
                            <th scope="col">Sales Price</th>
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
                                <td>{{ucwords($list->supplier_name)}}</td>
                                <td>{{ucwords($list->category)}}</td>
                                <td>{{ucwords($list->sub_category)}}</td>
                                <td>{{ucwords($list->product)}}</td>
                                {{-- <td>{{$list->qty}}</td> --}}
                                <td>{{$list->purchase_price}} </td>
                                <td>{{$list->sales_price}} </td>
                                <td>{{$list->size}}</td>
                                <td><input type="text"  disabled style="width:15px; height:15px; background-color:{{$list->color}};" id="colorinput"></td> 
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
    
    <div class="col-md-3 ">
        <div class="card hide">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6"><b>Barcodes</b></div>
                    <div class="col-md-6">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                            <button type="button" id="openBtn" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-print"></i> Preview</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body page" id="barcode_body" >
                @foreach ($products as $list)
                    {{-- <div class="card text-center" style='page-break-after: always; '> --}}
                    <div class="card" >
                        <div class="card-body pt-5">

                            <div class="row mb-2">
                                <span class="tect-center business_title text-center"><b>MANGALDEEP CLOTHS LLP</b></span>
                            </div>
                            <div class="row" >
                                <div class="col-md-7">
                                    <span class="product_detail" >Prod : Jeans</span> <br/>
                                    <span class="product_detail" >Sec : Super Slim (DD) J</span> <br/>
                                    <span class="product_detail" >Sty : MFT-28457-P</span> <br/>
                                    <span class="product_detail" >Clr : 134-Blue Black</span> <br/>
                                    <span class="product_detail" >Size : 34</span> <br/>
                                    <span class="product_detail" >MRP : 1250</span> <br/>
                                </div>
                                <div class="col-md-5">
                                    <img src="{{$list->barcode}}" class="barcode_image barcode" ><br/>
                                    {{-- <img src="{{asset('public/assets/barcodes/barcode.gif')}}" class="img-thumbnail " > --}}
                                    <span class="product_detail"><b>{{$list->product_code}}</b></span> <br/>
                                </div>
                            </div>
                            <hr style="color:black">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="product_detail" ><b>Mktd By :</b> Abc Marketing Pvt Ltd</span> <br/>
                                    <span class="product_detail" ><b>Plot No :</b> 84 Central Road Shashtri Nagar Bhopal 482007</span> <br/>
                                </div>
                            </div>
                                
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
            <div class="modal-dialog modal-md modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Barcodes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="show_barcode_body" >
                        
                    </div>
                    <div class="modal-footer">
                        <img src="" class=" " ><br/>
                        <button type="button" id="printBtn" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection

@section('script')

<script>

   
	
	

	// function saveSnap(){
	//     var base64data = $("#product_image").val();
    //     alert(base64data);
    //     $.ajax({
    //         type: "POST",
    //         dataType: "json",
    //         url: "capture_image_upload.php",
    //         data: {image: base64data},
    //         success: function(data) { 
    //             alert(data);
    //         }
    //     });
    // }




    $(document).ready(function () {

            Webcam.set({
                width: 450,
                height: 287,
                image_format: 'jpeg',
                jpeg_quality: 90
            });	 
            Webcam.attach( '#my_camera' );

            $(document).on('click','#purchaseEntry', function (e) {
                e.preventDefault();
                $('#purchaseEntryModal').modal('show');
                $('#purchase_entry_err').html('');
                $('#purchase_entry_err').removeClass('alert alert-danger');
                $("#purchaseEntryForm").trigger("reset"); 
                $('#saveProductBtn').removeClass('hide');
                $('#updateProductBtn').addClass('hide');
            });

            
            $(document).on('click','#captureLivePhotoBtn', function (e) {
                e.preventDefault();
                $('#captureLivePhotoModal').modal('show');
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

            $(document).on('change','.color_code', function (e) {
                e.preventDefault();
                const color_code = $(this).val();
                // const color = $(this).val();
                // alert(color);
                var object = $(this);
                $.ajax({
                    type: "get",
                    url: "get-color_code/"+ color_code,
                    dataType: "json",
                    success: function (response) {
                        // console.log(response);
                        $(object).parent().parent().find(".color_name").val(response.color.color);
                        // $(object).parent().parent().find("#color_name").val(response.color.color).css("background-color".color.color);
            
                    }
                });
                
            });
            
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

            // $(document).on('click','#cameraButton', function (e) {
            //     e.preventDefault();
            //     alert("call");
            // });


            $(document).on('click','#printBtn', function (e) {
                e.preventDefault();
                // const product_id = $(this).val();

                // $(".business_title").css({"font-size":"60px"});
                // $(".product_detail").css({"font-size":"40px"});
                // $(".barcode_image").css({"height":"250px", "width":"400px"});

                const png_target = document.getElementById('show_barcode_body');

                html2canvas(png_target).then( (canvas)=>{
                    const base64image = canvas.toDataURL('image/png');

                    var anchor = document.createElement('a');
                    anchor.setAttribute("href", base64image);
                    anchor.setAttribute("download", "my-image.png");
                    alert(base64image);
                })

                // const canvas = document.getElementById('show_barcode_body');
                // const img    = canvas.toDataURL('image/png');
                // document.getElementById('existing-image-id').src = img

                // printBarcode();
            });

           

        });

        function takePhoto() {
            Webcam.snap( function(data_uri) {
                document.getElementById('take_photo').innerHTML = 
                '<img class="card-img-top img-thumbnail after_capture_frame" src="'+data_uri+'"/>';
                $("#product_image").val(data_uri);
            });	 
            $('#captureLivePhotoModal').modal('hide');
        }

        function supplierDetail(supplier_id) {
            $.ajax({
                type: "get",
                url: "supplier-detail/"+supplier_id,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response.status == 200) {
                       $('#gst_no').val(response.supplier.gst_no) ;
                       $('#hsn_code').val(response.supplier.hsn_code) ;
                    }
                }
            });
        }

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

            var formData = new FormData($("#purchaseEntryForm")[0]);
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
                        $('#purchaseEntryModal').modal('show');
                        $('#product_err').html('');
                        $('#product_err').removeClass('alert alert-danger');
                        $("#purchaseEntryForm").trigger( "reset" ); 
                        $('#saveProductBtn').addClass('hide');
                        $('#updateProductBtn').removeClass('hide');

                        $('#supplier_id').val(response.product.supplier_id);
                        $('#gst_no').val(response.product.gst_no);
                        $('#hsn_code').val(response.product.hsn_code);
                        $('#bill_no').val(response.product.bill_no);

                        $('#category_id').val(response.product.category_id);
                        $('#sub_category_id').html("");
                        $('#sub_category_id').append(response.html);
                        $('#product_name').val(response.product.product);


                        $('#qty').val(response.product.qty);//

                        $('#size_id').val(response.product.size_id);
                        $('#color_id').val(response.product.color_id);
                        $('#purchase_price').val(response.product.purchase_price);
                        $('#sales_price').val(response.product.sales_price);


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

            var formData = new FormData($("#purchaseEntryForm")[0]);
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
                        $('#purchaseEntryModal').modal('hide');
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