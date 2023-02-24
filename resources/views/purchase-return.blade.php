@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')

    <div class="modal fade" id="releaseStatusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                {{-- <div class="modal-header"> --}}
                {{-- <h5 class="modal-title" id="exampleModalLabel"> Delete Brand </h5> --}}
                {{-- </div> --}}
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation Modal</h5>
                </div>
                <div class="modal-body">
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                    <h6> Do you want to release purchase return item?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" id="yesReleaseStatusBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                    <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

{{-- delete modal end  --}}
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <b>Purchase Return / Debit Note</b>
                </div>
                <div class="card-body">
                    <form id="returnItemsData">
                        @csrf
                        <div class="return_item_err"></div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <b>Supplier Details</b>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <select id="supplier_id" name="supplier_id" class="form-select form-select-sm">
                                                    <option selected disabled value="0">Supplier</option>                                          
                                                    @foreach ($suppliers as $list)
                                                    <option value="{{$list->id}}" state-type="{{$list->state_type}}"> {{ucwords($list->supplier_name)}} </option>
                                                    @endforeach
                                                </select> 
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="supplier_code" id="supplier_code" class="form-control form-control-sm" placeholder="Supplier Code" readonly >
                                           </div>
                                            <div class="col-md-4">
                                                 <input type="text"  name="gst_no"  id="gst_no" class="form-control form-control-sm" placeholder="GSTIN" readonly >
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <textarea class="form-control" name="supplier_address" id="supplier_address" style="height: 40px;"  placeholder="Address"  readonly></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                {{-- <div class="row">
                                    <div class="col-md-12">
                                        <label for="exampleFormControlInput1" class="form-label" >Barcode</label>
                                        <input type="text" name="" id="barcode" class="form-control form-control-sm" placeholder="barcode" autocomplete="off">
                                    </div>
                                </div> --}}
                        <div class="card mt-1">
                            <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <b>Product Details</b>
                                            {{-- <b style="margin-left: 100px">017791071723</b> --}}
                                        </div>
                                        <div class="col-md-3">
                                            {{-- <b>017791071723</b> --}}
                                            {{-- <label for="exampleFormControlInput1" class="form-label" >Barcode</label> --}}
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="barcode" id="barcode" class="form-control form-control-sm" placeholder="barcode" autocomplete="off">
                                        </div>
                                    
                                    </div>
                            </div> 
                      
                            <div class="card-body" >
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small  ><b>Style no</b> </small>
                                            <input type="hidden" name="style_no_id" id="style_no_id">
                                            <input type="text" name="style_no" id="style_no"  class="form-control form-control-sm" placeholder="style no" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <small  ><b>Color</b> </small>
                                            <input type="text" name="color" id="color" class="form-control form-control-sm" placeholder="color" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <small  ><b>Size</b> </small>
                                            <input type="text" name="size" id="size" class="form-control form-control-sm" placeholder="size" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <small  ><b>Qty</b> </small>
                                            <input type="text" name="qty" id="qty" class="form-control form-control-sm" placeholder="qty" value="1">
                                        </div>
                                        <div class="col-md-2">
                                            <small  ><b>Price</b> </small>
                                            <input type="text" name="price" id="price" class="form-control form-control-sm" placeholder="price" readonly>
                                        </div>
                                    </div>

                                    {{-- <div class="row">
                                        <div class="col-md-2">
                                            <small  ><b>Discount</b> </small>
                                            <input type="text" name="discount" id="discount" class="form-control form-control-sm" placeholder="Discount" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <small  ><b>Taxable</b> </small>
                                            <input type="text" name="taxable" id="taxable" class="form-control form-control-sm" placeholder="taxable" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <small  ><b>SGST</b> </small>
                                            <input type="text" name="total_sgst" id="total_sgst" class="form-control form-control-sm sgst" placeholder="SGST"   readonly >
                                        </div>
                                        <div class="col-md-2">
                                            <small  ><b>CGST</b> </small>
                                            <input type="text" name="total_cgst" id="total_cgst" class="form-control form-control-sm cgst" placeholder="CGST"  readonly >
                                        </div>
                                        <div class="col-md-2">
                                            <small ><b>IGST</b> </small>
                                            <input type="text" name="total_igst" id="total_igst" class="form-control form-control-sm igst" placeholder="IGST"  readonly >
                                        </div>
                                        <div class="col-md-2">
                                            <small ><b>Amount</b> </small>
                                            <input type="text" name="total_amount" id="total_amount" class="form-control form-control-sm total_amount" placeholder="Amount" readonly >
                                        </div>
                                    </div> --}}
                                </div> 
                            </div>
                    </form>
                    <div class="col-md-12">
                       <button class="btn-primary btn-sm float-right" id="saveReturnItem">Add</button>
                   </div>
                </div>
            </div>
        </div>

        <div class="col-md-6" id="tableData">
            <div id="panding_release_purchese_note"></div>
        </div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <b>Supplier Details</b>
            </div>
           <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Supplier name</th>
                            <th scope="col">Relese date</th>
                            <th scope="col">Relese time</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        @php
                            $count = 0;
                        @endphp
                        <tbody>
                            @foreach ($purchase_return_data as $list)
                            <tr>
                                <td>{{++$count}}</td>
                                <td>{{ucwords($list->supplier_name)}}</td>   
                                <td>{{date('d-m-Y',strtotime($list->release_date))}}</td>
                                <td>{{$list->release_time}}</td>
                                <td>
                                <button type="button" class="btn btn-success btn-sm generatePurchaseReturnInvoice"  value="{{$list->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice"><i class="fas fa-file-invoice"></i></button>
                                {{-- <button type="button" class="btn btn-success btn-flat btn-sm returnproductBtn" value="{{$list->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice"><i class="fas fa-file-invoice"></i></button> --}}
                                {{-- <button type="button" class="btn btn-success btn-flat btn-sm generatePurchaseReturnInvoiceModal" value="{{$list->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice"><i class="fas fa-file-invoice"></i></button> --}}
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

    <table class="hide">
        <tbody id="item_row">
            <tr>
                {{-- <td id="count_item"></td> --}}
    
              
                <td>
                    <input type="text"   class="form-control form-control-sm style_no" id="style_no" readonly >
                    <input type="hidden" name="style_no_id" id="style_no_id">
                </td>
                <td>
                    <input type="text"  name="color" class="form-control form-control-sm" id="color" readonly>
                    {{-- <input type="hidden" name="size_id[]" class="size_id"> --}}
                </td>
               
                <td>
                    <input type="text"  name="size" class="form-control form-control-sm size" id="size" readonly>
                    {{-- <input type="hidden" name="size_id[]" class="size_id"> --}}
                </td>
                <td style="width: 50px;">
                    <input type="text" id="qty" name="qty" value="1" class="form-control form-control-sm qty" min="1" value="0">
                </td>
                <td >
                    <input type="text" name="price" id="price" class="form-control form-control-sm" readonly>
                </td>
                
                <td style="width: 50px;">
                    <input type="text" class="form-control form-control-sm discount" value="0">
                    <input type="hidden" name="discount_amount[]" class="form-control form-control-sm discount_amount" style="width: 100px;">
                </td>
                 
                 <td style="width: 70px;" class="sgst_show_hide">
                     <input type="text" name="sgst[]" class="form-control form-control-sm sgst " value="0" readonly>
                </td> 
                <td style="width: 70px;" class="cgst_show_hide">
                     <input type="text" name="cgst[]" class="form-control form-control-sm cgst " value="0" readonly>
                </td> 
                <td style="width: 70px;" class="igst_show_hide ">
                     <input type="text" name="igst[]" class="form-control form-control-sm igst " value="0" readonly>
                </td> 
                <td style="width: 150px;">
                    <input type="text" name="amount[]" class="form-control form-control-sm amount" readonly>
                    <input type="hidden" name="taxfree_amount[]" class="form-control form-control-sm taxable" style="width: 150px;">
               </td> 
                
                {{-- <td>
                    <button type="button" class="btn btn-danger btn-flat btn-sm delete_item"><i class="far fa-window-close"></i></button>
                </td> --}}
            </tr>
        </tbody>
    </table>
    
    
    <section>
        <div class="modal fade" id="generatePurchaseReturnInvoiceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Debit Note Invoice</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="show_purchase_return_invoice"> </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm float-end" onClick="printInvoice('print_invoice')" >Print</button>
                    </div>
                </div>
            </div>
        </div>  
        
    </section>

@endsection

@section('script')
<script>
    $(document).ready(function(){
        purchaseReturnShowData();
        addItem();

        // save funcation 
        $(document).on('click','#saveReturnItem',function(){
            // alert("call");
            saveReturnProduct();
        });

        $(document).on('click','.generatePurchaseReturnInvoice',function(){
          var purchase_return_id = $(this).val();
            $('#generatePurchaseReturnInvoiceModal').modal('show');
            purchaseReturnInvoice(purchase_return_id);
            
        });

        // supplier details 

        $(document).on('change','#supplier_id', function (e) {
            e.preventDefault();
            var supplier_id = $('#supplier_id').val();

            supplierDetail(supplier_id);
        });

        $(document).on('click','.releaseStatusBtn', function (e) {
            e.preventDefault();
            const supplier_id = $(this).val();
            $('#releaseStatusModal').modal('show');
            $('#yesReleaseStatusBtn').val(supplier_id);
        });

        $(document).on('click','#yesReleaseStatusBtn', function (e) {
            e.preventDefault();
            const supplier_id = $(this).val();
            updateReleaseStatus(supplier_id);
        });
          
    });
    

    // function start 
        function addItem() {
            $('#item_list').append($('#item_row').html());
            // $("#item_list tr").find(".item").chosen();
        }

        $(document).on('change','#barcode', function () {
            const barcode_code = $(this).val();
            $.ajax({
                type: "get",
                url: "get-return-product-item/"+barcode_code,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response.status == 200) {
                        $('#style_no').val(response.return_product.style_no);
                        $('#style_no_id').val(response.return_product.style_no_id);
                        $('#size').val(response.return_product.size);
                        // $('#qty').val(response.return_product.qty);
                        $('#color').val(response.return_product.color);
                        $('#price').val(response.return_product.price);
                        $('#taxable').val(response.return_product.taxable);
                        $('#discount').val(response.return_product.discount);
                        $('#total_sgst').val(response.return_product.sgst);
                        $('#total_cgst').val(response.return_product.cgst);
                        $('#total_igst').val(response.return_product.igst);
                        $('#total_amount').val(response.return_product.amount);
                    }else{
                        $('#style_no').val("");
                        $('#style_no_id').val("");
                        $('#size').val("");
                        $('#color').val("");
                        $('#price').val("");
                        $('#discount').val("");
                        $('#taxable').val("");
                        $('#total_igst').val("");
                        $('#total_sgst').val("");
                        $('#total_cgst').val("");
                        $('#total_amount').val("");
                        $('#barcode').val("");
                    }
                        
                }
            });
            
        });

           
            function saveReturnProduct() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var formData = new FormData($("#returnItemsData")[0]);
                $.ajax({
                type: "post",
                url: "save-return-item",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    // console.log(response);
                    if (response.status === 400) {
                        $('#return_item_err').html('');
                        $('#return_item_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) {
                            $('#return_item_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                        });

                    } else {
                        $('#return_item_err').html('');
                        // $('#brandModal').modal('hide');
                        // window.location.reload();
                            $('#style_no').val("");
                            $('#style_no_id').val("");
                            $('#size').val("");
                            $('#color').val("");
                            // $('#qty').val("");
                            $('#price').val("");
                            $('#discount').val("");
                            $('#taxable').val("");
                            $('#total_igst').val("");
                            $('#total_sgst').val("");
                            $('#total_cgst').val("");
                            $('#total_amount').val("");
                            $('#barcode').val("");
                            purchaseReturnShowData();
                        }
                        
                    }
                });
            }
        

        function updateReleaseStatus(supplier_id) {
            $.ajax({
                type: "get",
                url: `update-release-status/${supplier_id}`,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if(response.status == 200){
                    }
                    window.location.reload();
                }
            });
        } 


    
    function purchaseReturnInvoice(purchase_return_id) {
        $.ajax({
            type: "get",
            url: `purchase-return-invoice/${purchase_return_id}`,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if(response.status == 200){
                    $('#show_purchase_return_invoice').html("");
                    $('#show_purchase_return_invoice').append(response.html);
                }
            }
        });
    } 

    // function printAlterReceipt(){
    //     var backup = document.body.innerHTML;
    //     var div_content = document.getElementById("generatePurchaseReturnInvoiceModal").innerHTML;
    //     document.body.innerHTML = div_content;
    //     window.print();
    //     document.body.innerHTML = backup;
    //     window.location.reload();
    // }

    function supplierDetail(supplier_id) {
        $.ajax({
            type: "get",
            url: "supplier-detail/"+supplier_id,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if (response.status == 200) {
                   $('#gst_no').val(response.supplier.gst_no) ;
                   $('#supplier_code').val(response.supplier.supplier_code) ;
                   $('#supplier_address').val(response.supplier.address) ;
                   $('#payment_days').val(response.supplier.payment_days) ;
                //    $('#state_type').val(response.supplier.state_type) ;

                //    supplierStyleNo(response.supplier.id);
                }
            }
        });
    }

        function purchaseReturnShowData(){
            $.ajax({
            type: "get",
            url: `purchase-return-show-data`,
            dataType: "json",
            success: function (response) {
                if(response.status == 200){
                    // console.log(response);
                    $('#panding_release_purchese_note').html("");
                    $('#panding_release_purchese_note').append(response.html);
                    }
                }
            });
        }


</script>
@endsection

