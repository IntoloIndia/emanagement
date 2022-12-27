@extends('layouts.app')
@section('page_title', 'Dashboard')
@section('style')
    <style>
        #btn{
            border-radius: 10px;
            width: 80px;
            height: 30px;
            
        }
        #btn:hover{
            background-color: rgb(91, 206, 97);
            border-style: none;
            color: black;
            /* font-size: 18px; */
        }
        #box{
            /* width: 100px;
            height: 200px; */
            border: 1px solid black;
            padding: 10px;
            margin-top: 10px;
        }
      
    </style>

@endsection
@section('content')
{{-- alter voucher modal --}}
    <section>
        <div class="modal fade" id="alterVoucherModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">Alter Item</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="alterVoucherForm">
                        @csrf
                      <div class='alterationvoucher_err'></div>
                       
                        <div id="show_alteration_items"></div>
                    </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary btn-sm saveAlterVoucherBtn">Save</button>
                </div>
              </div>
            </div>
          </div>
    </section>
    <section>
        <div class="modal fade" id="viewAlterVoucherModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="height: 550px;">
            <div class="modal-dialog modal-md modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Alter Voucher</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="print_alter_voucher">
                        <div class="row">
                            <div class="col-12 text-center">
                                <h6><b>Mangaldeep (Jabalpur)<br>
                                Samdariya Mall Jabalpur-482002</b></h6>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6"><h6>GSTNO : 1245GDFTE4587</h6></div>
                            <div class="col-6 text-end"><h6>Mobile No : 5487587458</h6></div>
                        </div>
                        <hr>
                        <div id='alter_item_list'></div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <p>Thankyou! Visit Again</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm float-end " id="printAlterReceiptBrn">Print</button>
                    </div>
                </div>
            </div>
        </div> 
    </section>
{{-- delivery modal --}}
    <div class="modal fade" id="deliveryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delivery Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <center>
                        <h5>Want to delivered Item?</h5>
                            <button type="button" id="yesDeliveredItemBtn" class="btn btn-primary btn-sm mx-1" value="" >Yes</button>
                            <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                        <hr>
                    </center>
                </div>
            </div>
        </div>
    </div>
   
<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customer bills</h3>
            </div>
            <div class="card-body table-responsive p-0" style="height: 300px;">
                <div class="col-md-12 mt-2">
                    <select class="form-select form-select-sm" name="customer_id" id="customer_id" >
                        <option selected="" disabled=""> Select name </option>
                        @foreach ($customers_billing as $item)
                            <option value="{{$item->id}}">{{$item->mobile_no}}</option> 
                        @endforeach
                    </select>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 table-responsive" style="height: 200px;">
                        <table class="table table-striped table-head-fixed " id="customer_bills" >
                        </table>    
                    </div>
                </div>
        </div>
    </div>
</div>
<div class="col-md-7">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6"> <b>Alter Voucher</b></div>
                <div class="offset-2 col-md-4">
                    <input type="text" id="filter_voucher" class="form-control form-control-sm" placeholder="Search voucher" >
                </div>
            </div>
        </div>
        <div class="card-body">

            <div class='accordion accordion-flush' id='accordionFlushExample'>
                <table class='table table-striped'>
                    <thead>
                        <tr style='position: sticky;z-index: 1;'>
                            <th>SNo</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Bill No</th>
                            <th>Customer</th>
                            <th colspan="2" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="filter_alter_voucher">
                            @foreach ($alteration_vouchers as $key => $vouchers)
                           
                                <tr class='accordion-button collapsed' data-bs-toggle='collapse' data-bs-target='#collapse_{{$key}}' aria-expanded='false' aria-controls='flush-collapseOne'>
                                    <td>{{++$key}}</td>
                                    <td>{{date('d-m-Y',strtotime($vouchers->alteration_date))}}</td>
                                    <td>{{$vouchers->alteration_time}}</td>
                                    <td>{{$vouchers->bill_id}}</td>
                                    <td>{{$vouchers->customer_name}}</td>
                                    <td>  <button type="button" class="btn btn-dark btn-sm deliveryStatusBtn" value="{{$vouchers->id}}">Delivery</button></td>
                                    <td>  <button type="button" class="btn btn-dark btn-sm viewAlterVoucherBtn" value="{{$vouchers->id}}"><i class="fas fa-file-invoice"></i></button></td>
                                </tr> 
                                {{-- @php
                                    $alteration_items = getAlterationItem($vouchers->id);// show voucher item
                                @endphp
                                <tr>
                                    <td colspan='3'>
                                        <div id='collapse_{{$key}}' class='accordion-collapse collapse' aria-labelledby='flush-headingOne' data-bs-parent='#accordionFlushExample'>
                                            <div class='accordion-body'>
                                                <table class="table table-striped table-hover table-info">
                                                    <thead>
                                                            <tr>
                                                                <th> SN</th>
                                                                <th> Item</th>
                                                                <th> Qty</th>
                                                            </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($alteration_items as $key => $items)
                                                            <tr>
                                                                <td>{{++$key}}</td>
                                                                <td>{{$items->sub_category}}</td>
                                                                <td>{{$items->item_qty}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr> --}}
                            @endforeach                                               
                        </tbody>
                </table>  
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6"> <b>Delivered Item</b></div>
                    <div class="offset-2 col-md-4">
                        <input type="text" id="filter_item" class="form-control form-control-sm" placeholder="Search voucher" >
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive p-0"  style="height: 300px;">
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <div class="table-responsive">
                        <table class='table table-striped'>
                            <thead>
                                <tr style='position: sticky;'>
                                    <th>SNo</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Bill</th>
                                    <th>Customer</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="filter_alter_item">
                                @foreach ($delivered_vouchers as $key => $list)
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{date('d-m-Y',strtotime($list->alteration_date))}}</td>
                                        <td>{{$list->alteration_time}}</td>
                                        <td>{{$list->bill_id}}</td>
                                        <td>{{$list->customer_name}}</td>
                                        <td> <button type="button" class="btn btn-dark btn-sm viewAlterVoucherBtn" value="{{$list->id}}"><i class="fas fa-file-invoice"></i></button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6"></div>
</div>


@endsection
@section('script')
<script>
    $(document).ready(function(){
        $("#customer_id").chosen({ width: '100%' });
        $(document).on('change','#customer_id', function(e){
            e.preventDefault();
            var customer_id = $(this).val();
            getCustomerBills(customer_id);
        });
        $(document).on('click','.product_id', function (e) {
            $(".product_id").each(function () {
                var check_prod= $(this).is(':checked');
                if ($(this).is(':checked')) {
                    var product_id = $(this).val();
                    $('#item_qty_'+ product_id).prop("disabled", false);
                }
                else{
                    if(!check_prod){
                        var product_id = $(this).val();
                        $('#item_qty_'+ product_id).prop("disabled", true);
                    }
                }
            });
        });
        // final alter function
            $(document).on('click','.alterBillsBtn',function(e){
                e.preventDefault();
                var bill_id = $(this).val();
                alterVoucher(bill_id);
            });

            $(document).on('click','.saveAlterVoucherBtn',function(e){
                e.preventDefault();
                saveAlterationVoucher();
            });
            $(document).on('click','.viewAlterVoucherBtn',function(e){
                e.preventDefault();
                var alteration_voucher_id = $(this).val();
              $('#viewAlterVoucherModal').modal('show');
              getAlterItem(alteration_voucher_id);

            });
            $(document).on('click','.deliveryStatusBtn',function(e){
                e.preventDefault();
                var alteration_voucher_id = $(this).val();
                $('#deliveryModal').modal('show');
                $('#yesDeliveredItemBtn').val(alteration_voucher_id);
                // updateDeliveryStatus(alteration_voucher_id);
            });
            $(document).on('click','#yesDeliveredItemBtn',function(e){
                e.preventDefault();
                var alteration_voucher_id = $(this).val();
                updateDeliveryStatus(alteration_voucher_id);
            });
            
          
            $(document).on('keyup','#filter_voucher',function(e){
                var value = $(this).val().toLowerCase();
                $("#filter_alter_voucher tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $(document).on('keyup','#filter_item',function(e){
                var value = $(this).val().toLowerCase();
                $("#filter_alter_item tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            $(document).on('click','#printAlterReceiptBrn', function () {
                // var modal_data = $('#barcode_body').html();
                // $('#print_alter_voucher').html('');
                // $('#print_alter_voucher').append(modal_data);
                $('#viewAlterVoucherModal').modal('show');
                printAlterReceipt();
            });
           
            // $(document).on('click','.item_qty',function(e){
            //     var item_qty = $(this).val();
            //     // alert($item_qty)
            //     $('.item_qty').keyup(function(event) {
            //         var qty = $(this).val();
            //         // alert(qty);
            //         if(qty>item_qty)
            //         {
            //             alert("np");
            //         }
            //     });
            // });
               
    });

// get customer bills
    function getCustomerBills(customer_id) {
        $.ajax({
            type: "get",
            url: `get-customers-bills/${customer_id}`,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if(response.status == 200){
                    $('#customer_bills').html("");
                    $('#customer_bills').append(response.html);
                }
            }
        });
    } 
  
    function alterVoucher(bill_id) {
        $.ajax({
            type: "get",
            url: "alter-voucher/"+bill_id,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if(response.status == 200){
                    $('#alterVoucherModal').modal('show');
                    $('#show_alteration_items').html("");
                    $('#show_alteration_items').append(response.html);
                }
            }
        });
    }

    function saveAlterationVoucher() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var formData = new FormData($("#alterVoucherForm")[0]);
        $.ajax({
            type: "post",
            url: "save-alteration-voucher",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false, 
            processData: false, 
            success: function (response) {
                console.log(response);
                if(response.status === 400)
                {
                    $('#alterationvoucher_err').html('');
                    $('#alterationvoucher_err').addClass('alert alert-danger');
                    var count = 1;
                    $.each(response.errors, function (key, err_value) { 
                        $('#alterationvoucher_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                    });

                }else{
                    $('#alterationvoucher_err').html('');
                    $('#alterVoucherModal').modal('hide');
                
                    window.location.reload();
                }
            }
        });
    }
    
    function getAlterItem(alteration_voucher_id) {
        $.ajax({
            type: "get",
            url: `get-alter-item/${alteration_voucher_id}`,
            dataType: "json",
            success: function (response) {
                console.log(response);
                if(response.status == 200){
                    $('#alter_item_list').html("");
                    $('#alter_item_list').append(response.html);
                }
            }
        });
    } 
    function updateDeliveryStatus(alteration_voucher_id) {
        $.ajax({
            type: "get",
            url: `update-delivery-status/${alteration_voucher_id}`,
            dataType: "json",
            success: function (response) {
                console.log(response);
                if(response.status == 200){
                }
                window.location.reload();
            }
        });
    } 
    function printAlterReceipt(){
        var backup = document.body.innerHTML;
        var div_content = document.getElementById("print_alter_voucher").innerHTML;
        document.body.innerHTML = div_content;
        window.print();
        document.body.innerHTML = backup;
        window.location.reload();
    }
   
</script>

@endsection


