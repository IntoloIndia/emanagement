@extends('layouts.common_modal')
@extends('layouts.app')
@section('page_title', 'Purchase Entry')
@section('style')

<link rel="stylesheet" media="print" href="{{asset('public/assets/css/print.css')}}" />
<style>

.form-control, .form-select {
    margin-bottom: 2px;
    padding: 1px 5px;
}

.chosen-container{
    width: 100%;
}

  #colorinput{
    border: none;
    background-color": "yellow";
  }

.barcode{
    length:100%;
    width:100%;
}

.popover-content {
  height: 180px;  
  width: 200px;  
}

/* textarea.popover-textarea {
   border: 0px;   
   margin: 0px; 
   width: 100%;
   height: 100%;
   padding: 0px;  
   box-shadow: none;
}

.popover-footer {
  margin: 0;
  padding: 8px 14px;
  font-size: 14px;
  font-weight: 400;
  line-height: 18px;
  background-color: #F7F7F7;
  border-bottom: 1px solid #EBEBEB;
  border-radius: 5px 5px 0 0;
}

a {
    padding: 0px 20px 20px 20px;
    float: left;
    vertical-align: middle;
    width: 100px;
    margin: 5px;
}  */


 
</style>
@endsection

@include('purchase.modals')

@section('content-header')
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="m-0"><b>Purchase Invoice</b></h3>
            </div>
            <div class="col-sm-6">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                    <button type="button" id="purchaseExcelEntry" class="btn btn-info btn-flat btn-sm "><i class="fas fa-plus"></i> Purchase Excel Entry</button>
                    <button type="button" id="purchaseEntry" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-plus"></i> Purchase Entry</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">

        <div class="col-md-8">
            <div class="card">
    
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8 col-lg-8 col-xl-8">
                            <h3 class="card-title">Purchase</h3>
                        </div>
                        <div class=" col-md-4 col-lg-4 col-xl-4">
                            <select id="filter_supplier_id" name="filter_supplier_id" class="form-select form-select-sm select_chosen">
                                <option selected disabled value="0">Supplier</option>                                          
                                @foreach ($suppliers as $list)
                                <option value="{{$list->id}}" state-type="{{$list->state_type}}"> {{ucwords($list->supplier_name)}} </option>
                                @endforeach
                            </select>
                        </div>
                        
                    </div>
                </div>
    
                <div class="card-body table-responsive p-0" style="height: 450px;" >
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Bill Date</th>
                                <th>Bill No</th>
                                <th>Supplier</th>
                                <th>Pay Days</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($purchases->isEmpty())
                                <div class="alert alert-warning text-light my-2" role="alert">
                                    <span>State is not available to add new state click add button</span>
                                </div>
                            @else
                                {{$count = "";}}
                                @foreach ($purchases as $list)
                                    <tr>
                                        <td>{{++$count}}</td>
                                        <td>{{date('d-m-Y', strtotime($list->bill_date))}}</td>
                                        <td>{{strtoupper($list->bill_no)}}</td>
                                        <td>{{ucwords($list->supplier_name)}}</td>
                                        <td>{{$list->payment_days}}</td>
                                        <td>
                                            {{-- <button type="button" class="btn btn-info btn-sm " value="{{$list->id}}"><i class="fas fa-eye"></i></button> --}}
                                            <button type="button" class="btn btn-success btn-sm generatePurchaseInvoice" value="{{$list->id}}"><i class="fas fa-file-invoice"></i></button>
                                            {{-- <button type="button" class="btn btn-danger btn-sm deleteBtn" module-type="{{MyApp::STATE}}" value="{{$item->id}}"><i class="fas fa-trash"></i></button> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif 
                        </tbody>
                    </table>
                    {{-- <br>
                    <div class="row">
                        <div class="col-md-12 table-responsive" style="height: 200px;">
                            <table class="table table-striped table-head-fixed" id="customer_list" >
                                
                            </table>    
                        </div>
                    </div> --}}
            </div>
        </div>

    </div>
@endsection


@section('script')

    <script>
        $(document).ready(function () {

            $(".select_chosen_80").chosen({ width: '90%' });
            $(".select_chosen").chosen({ width: '100%' });

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
                $("#supplier_id").chosen({ width: '100%' });
            
                $('#savePurchaseEntryBtn').removeClass('hide');
                $('#updatePurchaseEntryBtn').addClass('hide');
            });


            $(document).on('click','#purchaseExcelEntry', function (e) {
                e.preventDefault();
                $('#purchaseExcelModel').modal('show');
                $('#purchase_entry_err').html('');
                $('#purchase_entry_err').removeClass('alert alert-danger');
                $("#purchaseEntryForm").trigger("reset"); 
            
                $('#savePurchaseEntryBtn').removeClass('hide');
                $('#updatePurchaseEntryBtn').addClass('hide');
            });
        
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

            $(document).on('click','#addItemBtn', function (e) {
                e.preventDefault();

                // var supplier_id = $('#supplier_id').find("option:selected").attr('state-type');;
                var supplier_id = $('#purchaseEntryModal').find('#purchaseEntryForm').find('#supplier_id').find("option:selected").val();
                var bill_no = $('#purchaseEntryModal').find('#purchaseEntryForm').find('#bill_no').val();
                var category_id = $('#purchaseEntryModal').find('#purchaseEntryForm').find('#category_id').find("option:selected").val();
                var sub_category_id = $('#purchaseEntryModal').find('#purchaseEntryForm').find('#sub_category_id').find("option:selected").val();
                var style_no = $('#purchaseEntryModal').find('#purchaseEntryForm').find('#style_no').find("option:selected").val();

                addItem();
                // $(".product_code").focus();
            });

            $(document).on("click",".delete_item", function(){

                // if($("#item_list tr").length == 1)
                // {
                //     alert("Order must have at least 1 item.");
                //     return false;
                // }
                $(this).parent().parent().remove();
            });

            $(document).on('keyup','.qty', function () {
                calculateQtyPrice();
            });

            $(document).on('keyup','.price', function () {
                calculateQtyPrice();
            });
            
            
            $(document).on('click','.captureLivePhotoBtn', function (e) {
                e.preventDefault();
                $('#captureLivePhotoModal').modal('show');
            });

            $(document).on("focusout","#bill_no", function(e){
                var supplier_id = $('#supplier_id').val();
                var bill_no = $('#bill_no').val();

                getPurchaseEntry(supplier_id, bill_no);
            });

            $(document).on('click','#savePurchaseEntryBtn', function (e) {
                e.preventDefault();
                // let productCode = Math.floor((Math.random() * 1000000) + 1);
                // alert(productCode);

                // savePurchaseEntry();
                validateForm();
            });

            $(document).on('change','#category_id', function (e) {
                e.preventDefault();
                const category_id = $(this).val();
                getSubCategoryByCategory(category_id);
                
            });

            $(document).on('change','.color_code', function (e) {
                e.preventDefault();
                const color_code = $(this).val();
                var object = $(this);
                $.ajax({
                    type: "get",
                    url: "get-color_code/"+ color_code,
                    dataType: "json",
                    success: function (response) {
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
        
            // $(document).on("focusin","[rel=popover]", function(e){
            //     var price = parseFloat($(this).val());
            //     calculateGst( $(this), price );
            //     $(this).parent().parent().parent().parent().parent().find('.mypopover-content').show();
            // });
            // $(document).on("focusout","[rel=popover]", function(e){
            //     $(this).parent().parent().parent().parent().parent().find('.mypopover-content').hide();

            // });

            // $(document).on('keyup','.xs_price', function () {
            //     var price = parseFloat($(this).val());
            //     calculateGst( $(this), price );
            // });

            // $(document).on('keyup','.s_price', function () {
            //     var price = parseFloat($(this).val());
            //     calculateGst( $(this), price );
            // });

            // $(document).on('keyup','.m_price', function () {
            //     var price = parseFloat($(this).val());
            //     calculateGst( $(this), price );
            // });
            // $(document).on('keyup','.l_price', function () {
            //     var price = parseFloat($(this).val());
            //     calculateGst( $(this), price );
            // });
            // $(document).on('keyup','.xl_price', function () {
            //     var price = parseFloat($(this).val());
            //     calculateGst( $(this), price );
            // });
            // $(document).on('keyup','.xxl_price', function () {
            //     var price = parseFloat($(this).val());
            //     calculateGst( $(this), price );
            // });

            $(document).on('click','#categoryBtn', function () {
                $('#categoryModal').modal('show');
            });
            // save category of purchase entry
            $(document).on('click','#saveCategoryBtn', function (e) {
                e.preventDefault();
                saveCategory();
            });
        
            $(document).on('click','#subCategoryBtn', function () {
                $('#subCategoryModal').modal('show');
            });
            // save sub category
            $(document).on('click','#savesubCategoryBtn', function (e) {
                e.preventDefault();
                saveSubCategory();
            });

            $(document).on('click','#styleNoBtn', function () {
                $('#styleNoModal').modal('show');
            });
            // save style no
            $(document).on('click','#saveStyleNoBtn', function (e) {
                e.preventDefault();
                manageStyleNo();
            });

            $(document).on('click','.generatePurchaseInvoice', function (e) {
                e.preventDefault();
                var purchase_id = $(this).val();
                generatePurchaseInvoice(purchase_id);
            });

            // $(document).on("click",".price", function(e){
                // e.preventDefault();

                // var content = document.getElementById('mypopover-content');
                // $('body').popover({
                //     selector: '[rel=popover]',
                //     trigger: 'click',
                //     content : content,
                //     placement: "bottom",
                //     html: true
                // })

            // });

            // $(document).on('keyup','#base_amount', function () {
            //     calculateGst($(this));
            // });
   

        });
    </script>

    <script src="{{asset('resources/views/purchase/index.js')}}"></script>
@endsection