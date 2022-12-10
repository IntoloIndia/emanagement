@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-9 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <b>Billing</b>
            </div>
        <div class="card-body">
            <form id="orderForm">
                    @csrf
                <div class="order_err"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="moblie_no" class="form-label" >Moblie no</label>
                            <input type="number"  class="form-control form-control-sm" name="mobile_no" required id="moblie_no" placeholder="Enter mobile number">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text"  class="form-control form-control-sm" id="customer_name" required name="customer_name" placeholder="Enter name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-6">
                                <label for="moblie_no" class="form-label" >Birth Date</label>
                                <input type="number"  class="form-control form-control-sm" name="birthday_date" id="birthday_date" required id="days" min="1">
                            </div>
                            <div class="col-6">
                                <label for="moblie_no" class="form-label" >Months</label>
                                <select class="form-select form-select-sm" name="month_id" id="month_id">
                                    <option selected>Select...</option>
                                    @foreach ($months as $item)
                                        <option value="{{$item->id}}">{{$item->month}}</option>
                                    @endforeach
                                  </select>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="row mb-2">
                        <div class="col-md-3">
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="states" value="{{MyApp::WITH_IN_STATE}}" id="with_in_state" checked>
                                <label class="form-check-label" for="flexRadioDefault1">With in State</label>
                            </div>
                        </div>  
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="states" value="{{MyApp::INTER_STATE}}"  id="inter_state" >
                                <label class="form-check-label" for="flexRadioDefault2">
                                  Inter State
                                </label>
                              </div>
                        </div>
                       
                        <div class="col-md-3">
                            <select name="city_id" id="city_id" class="form-select form-select-sm hide" >
                                <option selected disabled>City</option>
                               @foreach($cities as $item)
                                   <option value="{{$item->id}}">{{$item->city}}</option>
                               @endforeach
                              </select>
                        </div>
                        <div class="col-md-3">
                            {{-- <label for="gst_no" class="form-label" >GST IN</label> --}}
                            <input type="text" name="gst_no" id="gst_no" placeholder="GST IN" class="form-control form-control-sm hide">
                        </div>
                    </div>
                   
                {{-- </div> --}}
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <b>Items</b>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                {{-- <input type="text" id="addItemBtn"> --}}
                                <button class="btn btn-primary btn-sm "  id="addItemBtn"> Add item</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body"style="max-height:400px;">
                       <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="table-responsive" style="max-height: 250px">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Sno</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">category</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Size</th>
                                        <th scope="col">MRP</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">SGST%</th>
                                        <th scope="col">CGST%</th>
                                        <th scope="col">Delete</th>

                                    </tr>
                                </thead>
                                <tbody id="item_list">
                                </tbody>
                            </table>  
                            </div>
                        </div>
                       </div>
                    </div>
                    <div class="card-footer ">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3 text-end">
                                {{-- <b>Total Amt :</b><br/> --}}
                                <b>GROSS AMOUNT :</b><br/>
                                <b>LESS DISCOUNT :</b><br/>
                                <b>ADD SGST :</b><br/>
                                <b>ADD CGST :</b><br/>
                                <b> OTHER ADJ  :</b><br/>
                                <b>R/OFF AMT :</b><br/>
                                <b>G.TOTAL  :</b><br/>
                            </div>
                            <div class="col-md-2 text-center">
                                <span id="item_gross_amount"></span><br/>
                                <span id="item_less_amount"></span><br/>
                                <span id="item_add_sgst"></span><br/>
                                <span id="item_add_cgst"></span><br/>
                                <span id="item_other_adj"></span><br/>
                                <span id="item_Roff_amt"></span><br/>
                                <span id="item_total_amount"></span><br/>
                            </div>
                        </div>
                        <div class="row mt-1 hide" id="given_return_amount" >
                            <div class="col-md-4"></div>
                            <div class="col-md-4"></div>
                            <div class="col-md-2 text-end">
                                <div><b>Given Amt :</b></div>
                                <div class="mt-2" ><b >Return Amt :</b></div>
                            </div>
                            <div class="col-md-2 text-center">
                                <input type="text" name="" id="given_amount" class="form-control form-control-sm">
                                <input type="text" name="" id="return_amount" class="form-control form-control-sm mt-1" readonly>
                            </div>
                        </div>

                    </div>
                </div>
                {{-- <button class="btn btn-primary btn-sm float-right" id="saveOrderBtn">save</button> --}}
                <input type="hidden" name="total_amount" id="total_amount" class="form-control form-control-sm " >
                <hr>
                <div class="row">
                    <div class="col-md-2">
                        <span>Payment :</span>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input payment_mode" type="radio" name="payment_mode" id="online" value="{{MyApp::ONLINE}}">Online
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input payment_mode" type="radio" name="payment_mode" id="cash" value="{{MyApp::CASH}}">Cash
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input payment_mode" type="radio" name="payment_mode" id="card" value="{{MyApp::CARD}}">Card
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input payment_mode" type="radio" name="payment_mode" id="credit" value="{{MyApp::CREDIT}}">Credit
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-3 d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveOrderBtn" class="btn btn-primary btn-sm" disabled>Save Order</button>
                        <button type="button" id="updateOrderBtn" class="btn btn-primary btn-sm hide">Update Order</button>
                    </div>

                </div>
             
            </div> 
        </form>
        </div>
    </div>
    <div class="col-lg-3 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <b>Invoice</b>
                    </div>
                    <div class="col-md-6">
                        {{-- <b class="float-right">Date</b><br/>
                        <b class="float-right">time</b> --}}
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="max-height: 250px">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sno</th>
                            <th scope="col">Name</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Print</th>
                            </tr>
                    </thead>
                    <tbody id="item_list">
                        @php
                            $count = 0;
                        @endphp
                         @foreach ($customers_billing as $item)
                        <tr>
                            <td>{{++$count}}</td>
                            <td>{{ucwords($item->customer_name)}}</td>
                            <td>{{$item->mobile_no}}</td>
                            <td>{{$item->total_amount}}</td>

                            <td> 
                                {{-- <button type="button" class="btn btn-secondary btn-flat btn-sm editOrderBtn" value="{{$list->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Order"><i class="far fa-edit"></i></button> --}}
                                {{-- <button type="button" class="btn btn-info btn-flat btn-sm orderDetailBtn" value="{{$item->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="View Order"><i class="far fa-eye"></i></button> --}}
                                <button type="button" class="btn btn-success btn-flat btn-sm orderInvoiceBtn" value="{{$item->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice"><i class="fas fa-file-invoice"></i></button>
                                {{-- <button type="button" class="btn btn-danger btn-flat btn-sm" value="{{$item->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancel Order"><i class="fas fa-ban"></i></button> --}}
                                
                             </td>
                            
                        </tr>
                        @endforeach 
                    </tbody>
                    <tfoot>
                        
                    </tfoot>
                </table>  
                </div>
                {{-- <button class="orderInvoiceBtn" >print</button> --}}
            </div>
            
        </div>


        <div class="card hide">
            <div class="card-body page" id="barcode_body" >
                @foreach ($products as $list)
                    <div class="card" >
                        <div class="card-body pt-5">
                            <div class="row mb-2">
                                <span class="tect-center business_title text-center"><b>MANGALDEEP CLOTHS LLP</b></span>
                            </div>
                            <div class="row" >
                               
                                <div class="col-md-5">
                                    <img src="{{$list->barcode}}" class="barcode_image barcode" ><br/>
                                    {{-- <img src="{{asset('public/assets/barcodes/barcode.gif')}}" class="img-thumbnail " > --}}
                                    <span class="product_detail"><b>{{$list->product_code}}</b></span> <br/>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
        </div>

    </div>

    

   </div>

   <table class="hide">
    <tbody id="item_row">
        <tr>
            <td id="count_item"></td>
            
            <td style="width: 200px;">
                <input type="text" name="product_code[]" id="product_code" class="form-control form-control-sm product_code">
            </td>

            <td style="width: 200px;">
                {{-- <select name="product_id[]"  id="product_id" class=" form-select form-select-sm product_id">
                    <option selected>Choose..</option>
                    @foreach ($products as $item)
                        <option value="{{$item->id}}">{{ucwords($item->product)}}</option>
                    @endforeach
                </select> --}}
                <input type="text" readonly name="product[]" class="form-control form-control-sm product" >
                <input type="hidden" name="product_id[]" class="product_id">
            </td>
           
            <td style="width: 100px;">
                <input type="text" name="qty[]" value="1" class="form-control form-control-sm qty" min="1" value="0">
            </td>
            <td style="width: 100px;">
                <input type="text" readonly name="size[]" class="form-control form-control-sm size">
                <input type="hidden" name="size_id[]" class="size_id">
                {{-- <input type="text"  value="{{ucwords($item->size)}}" name="size_id[]" id="size_id" readonly  class=" form-control form-control-sm size_id"> --}}
                {{-- <select name="size_id[]" class=" form-select form-select-sm size_id">
                    <option selected disabled></option>
                    @foreach ($sizes as $item)
                        <option  value="{{$item->id}}">{{ucwords($item->size)}}</option>
                    @endforeach
                </select> --}}
            </td>
            <td style="width: 100px;">
                <input type="text" name="price[]" class="form-control form-control-sm price" readonly>
            </td>
             <td style="width: 150px;">
                 <input type="text" name="amount[]" class="form-control form-control-sm amount"readonly >
            </td> 
             <td style="width: 150px;">
                 <input type="text" name="sgst[]" class="form-control form-control-sm sgst" >
            </td> 
             <td style="width: 150px;">
                 <input type="text" name="cgst[]" class="form-control form-control-sm cgst" >
            </td> 
            <td>
                <button type="button" class="btn btn-danger btn-flat btn-sm delete_item"><i class="far fa-window-close"></i></button>
            </td>
        </tr>
    </tbody>
</table> 

<section>
    <div id="newcontent">
        <div class="modal fade" id="generateInvoiceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                
        </div>
    </div>
</section>


    @endsection


@section('script')

<script>
    
    $(document).ready(function () {
        
        $(document).on('click','#addItemBtn', function (e) {
            e.preventDefault();
            addItem();
            // $(".product_code").focus();
            });

            $(document).on('click','#saveOrderBtn', function (e) {
                e.preventDefault();
                // alert("call");
                saveOrder();
            });

            

            $(document).on("keypress",".qty, #given_amount",function(e){
                if(!(e.which>=48 && e.which<=57 ))
                {
                    if(!((e.which == 0) || (e.which==8)))
                    e.preventDefault();    
                }
            }); 

            $(document).on("change",".payment_mode",function(e){
                const payment_mode = $('input[name="payment_mode"]:checked').val();
                if(payment_mode == '{{MyApp::CASH}}'){
                    $('#given_return_amount').removeClass('hide');
                }else{
                    $('#given_return_amount').addClass('hide');
                }
                $('#saveOrderBtn').prop("disabled", false);
            }); 



            $(document).on("click",".delete_item", function(){
                if($("#item_list tr").length == 1)
                {
                    alert("Order must have at least 1 item.");
                    return false;
                }
                $(this).parent().parent().remove();
                calculateTotalAmount();
            });

            
            $(document).on('change','.product_code', function () {
                const product_code = $(this).val();
                // alert("call")
                var object = $(this);
                $.ajax({
                    type: "get",
                    url: "get-item-price/"+product_code,
                    dataType: "json",
                    success: function (response) {
                        // console.log(response);
                        $(object).parent().parent().find(".price").val(response.product.sales_price);
                        $(object).parent().parent().find(".product").val(response.product.product);
                        $(object).parent().parent().find(".product_id").val(response.product.id);
                        $(object).parent().parent().find(".size").val(response.product.size);
                        $(object).parent().parent().find(".size_id").val(response.product.size.id);
                        calculateAmount(object)
                    }
                });
                
                
            });

            $(document).on('click','#with_in_state', function (e) {
                $('#gst_no').addClass('hide');
                $('#city_id').addClass('hide');
                
            });

            $(document).on('click','#inter_state', function (e) {
                $('#gst_no').removeClass('hide');
                $('#city_id').removeClass('hide');
                
            });

            // $(document).keypress('#mobile_no', function () {
            //     const customer_id = $(this).val();
            //     // alert(customer_id);
            //     var object = $(this);
            //     $.ajax({
            //         type: "get",
            //         url: "get-customer-data/"+customer_id,
            //         dataType: "json",
            //         success: function (response) {
            //             console.log(response);
            //             // $(object).parent().parent().find(".price").val(response.product.sales_price);
            //             // $(object).parent().parent().find(".product").val(response.product.product);
            //             // $(object).parent().parent().find(".product_id").val(response.product.id);
            //             // $(object).parent().parent().find(".size").val(response.product.size);
            //             // $(object).parent().parent().find(".size_id").val(response.product.size.id);
            //         }
            //      });
                
                
            // });
            
            
            $(document).on('keyup','.qty', function () {
                calculateAmount($(this));
            });

            // $(document).on('click','#product_id', function () {
            //     var pro_id = $(this).val();
            //     alert(pro_id);
            // });
            $(document).on('keyup','#given_amount', function () {
                returnAmount();
            });

            $(document).on('click','#saveOrderBtn', function (e) {
                e.preventDefault();
                validateForm();
            });

            // $(document).on('click','.orderDetailBtn', function () {
            //     const order_id = $(this).val();
            //     orderDetail(order_id);
            // });
            
            // $(document).on('click','.editOrderBtn', function (e) {
            //     e.preventDefault();
            //     const order_id = $(this).val();
            //     editOrder(order_id);
            // });

            // $(document).on('click','#updateOrderBtn', function (e) {
            //     e.preventDefault();
            //     const order_id = $(this).val();
            //     updateOrder(order_id);
            // });

            $(document).on('click','.orderInvoiceBtn', function (e) {
                e.preventDefault();
                const customer_id = $(this).val();
                // alert(billing_id);
                generateInvoice(customer_id);
            });

            $(document).on('click','#printBtn', function () {
                printInvoice();
            });


            // $(document).on('click','.deleteItemBtn', function (e) {
            //     e.preventDefault();
            //     const item_id = $(this).val();
            //     $('#deleteItemModal').modal('show');
            //     $('#yesDeleteItemBtn').val(item_id);
            // });

            // $(document).on('click','#yesDeleteItemBtn', function (e) {
            //     e.preventDefault();
            //     const item_id = $(this).val();
            //     deleteItem(item_id);
            // });

        });

        function addItem() {
            $(".product_code").focus();
            $('#item_list').append($('#item_row').html());
            $("#item_list tr").find(".item").chosen();
            
        }

        function calculateAmount(object){
            var total_amount = 0;
            var sgst = 0;
            var cgst = 0;
            var price = parseFloat($(object).parent().parent().find(".price").val());
            var qty = parseFloat($(object).parent().parent().find(".qty").val());
            var cgst = parseFloat($(object).parent().parent().find(".cgst").val());
            var cgst = parseFloat($(object).parent().parent().find(".cgst").val());

            if(qty == "" || isNaN(qty))
            {
                qty = 0;   
            }

            // var amount = parseFloat(price * qty);
            var amount = parseFloat(price * qty);
            // if(amount>1000){
            //    console.log((amount*2.50/100)+amount);
            // }
            $(object).parent().parent().find(".amount").val(amount);
            calculateTotalAmount();
        }

        function calculateTotalAmount(){
            var item_total_amount = 0;

            $(".amount").each(function(){
                total_amount = parseFloat($(this).val());
                if (!isNaN(total_amount))
                {
                    item_total_amount +=  total_amount;
                }  
            });
            $("#item_total_amount").text(item_total_amount);
            $("#total_amount").val(item_total_amount);
            returnAmount();
        }

        function returnAmount(){
            const given_amount = parseFloat($('#given_amount').val());
            const total_amount = parseFloat($("#total_amount").val());

            const return_amount = parseFloat(given_amount - total_amount) ; 
            $("#return_amount").val(return_amount);
        }

        function validateForm() {
            var msg = "";
            // if($("#invoice_no").val() == "")
            // {
            //     msg = "Please enter customer name";
            //     validateModal(msg);
            //     return false;
            // }

            if($("#item_list tr").length == 0)
            {
                msg = "Please add at least 1 item";
                validateModal(msg);
                return false;
            }

            // $(".item").each(function (){
            //     msg = "Please select item";
            //     validateModal(msg);
            //     return false;
                
                
            // });

            // saveOrder();
        }

        function saveOrder() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#orderForm")[0]);
            $.ajax({
                type: "post",
                url: "save-order",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status === 400) {
                        $('#order_err').html('');
                        $('#order_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) {
                            $('#order_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                        });

                    } else {
                        $('#order_err').html('');
                        // $('#productModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }


        function printInvoice(){
            //var order_id = $('#printBtn').attr('order-id'); 
            const section = $("section");
            const modalBody = $("#invoiceModalPrint").detach();

            section.empty();
            section.append(modalBody);
            window.print();
            
            window.location.reload();
               
        }

        function generateInvoice(customer_id) {
         $.ajax({
        type: "get",
        url: "generate-invoice/"+customer_id,
        dataType: "json",
        success: function (response) {
            //console.log(response);
            if (response.status == 200) {
                $('#generateInvoiceModal').html(response.html);
                $('#generateInvoiceModal').modal('show');
                
            }
        }
    });
}



           
    </script>

@endsection

                                {{-- $html .="<span class='float-end'>GROSS AMOUNT:</span><br>";
                                $html .="<span class='float-end'>LESS DISCOUNT:</span><br>";
                                $html .="<span class='float-end'>ADD CGST :</span> <br>";
                                $html .="<span class='float-end'>ADD SGST : </span><br>";
                                $html .="<span class='float-end'>OTHER ADJ :</span> <br>";
                                $html .="<span class='float-end'>R/OFF AMT :</span> <br>";
                                $html .="<span class='float-end'>G.TOTAL : </span><br>"; --}}