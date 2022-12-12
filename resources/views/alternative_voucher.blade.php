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
{{-- <div class="row">
    <h1>Alternative voucher</h1>
    <div class="col-md-3">
        <input type="text" name="bill_no" id="bill_no" class="form-control form-control-sm" placeholder="bill no" >
       </div>
    <div class="col-md-3">
        <button class="btn btn-primary btn-sm orderInvoiceBtn" id="btn">show</button>
        @foreach ($customers_billing as $item)
        <input type="text" name="bill_no" id="bill_no" class="form-control form-control-sm orderInvoiceBtn"  value="{{$item->id}}" >
        {{-- <button type="button" class="btn btn-success btn-flat btn-sm orderInvoiceBtn" value="{{$item->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice"><i class="fas fa-file-invoice"></i></button> --}}
        {{-- @endforeach

       </div>
    </div> --}} 
    {{-- <h2>Bill</h2> --}}
{{-- <div id="box">
    <div class="row">
            <div class='col-md-3'>
                <span>GST NO: <small>4125666</small></span><br>
            </div>
            <div class='col-md-6 text-center'>
                <span>SALES INVOICE</span><br>
                <span>ERENOWN CLOTHING CO </span><br>
                <span>Shop no.8-9,Ground Floor Samdariya Mall </span><br>
                <span>Jabalpur -482002 </span><br>
            </div>
            <div class='col-md-3' >
                <span>Phone no: 0761-4047699</span><br>
                <span></span><br>
                <span>Mobile no : 09826683399<small></small></span><br>
                <span></span><br>
            </div>
        </div>
        <div class='row' style="padding: 10px;">
            <div class='col-md-6' style='border:1px solid black'>
            <span>Customer name: <small></small></span><br>
            <span>Location : <small>Jabalpur</small></span><br/>
            <span>State code  : <small>0761</small></span><br>
        </div>
        <div class='col-md-2' style='border:1px solid black'>
            <span class=''>CASH :<br/> <small><b>10000</b></small></span>
        </div>
            <div class='col-md-4' style='border:1px solid black'>
                <span>Invoicen No : <small class='float-end'></small></span><br>
                <span class=''>Date : <small class='float-end'></small></span><br>
                <span class=''>Attent By : <small class='float-end'></small></span>
            </div>
         </div>
         <div class='row mt-2'>
            <div class='table-responsive'>
                <table class='table table-bordered'>
                <thead>
                <tr>
                <th>#</th>
                <th></th>
                <th>Item Name</th>
                <th>Qty</th>
                <th>Size</th>
                <th>Color</th>
                <th>MRP</th>
                <th>Rate</th>
                <th>Disc</th>
                <th>Total</th>
                <th>Taxable</th>
                <th>CGST%</th>
                <th>SGST%</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($order_items as $key => $list) 
                        <tr>
                            <td>{{++$key}}</td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    </label>
                                  </div>
                            </td>
                            <td>{{$list->product}}</td>
                            <td>{{$list->qty}}</td>
                            <td>{{$list->size}}</td>
                            <td>{{$list->red}}</td>
                            <td>{{$list->price}}</td>
                            <td>{{$list->price}}</td>
                            <td>{{$list->price}}</td>
                            <td>{{$list->amount}}</td>
                            <td>{{$list->amount}}</td>
                            <td>{{$list->amount}}</td>
                            <td>{{$list->amount}}</td>
                           
                        </tr>
                    @endforeach
                </tbody> 
                 <tfoot>
                    <tr>
                        <td colspan='3'></td>
                         <td>{{$key}}</td>
                        <td colspan='5'></td>
                        <td><b>Total :</b></td>
                        <td>{{$list->amount}}</td>
                        <td>{{$list->amount}}</td>
                        <td>{{$list->amount}}</td>
                    </tr>
                 </tfoot>
                </table>
            </div>
         </div>
         <div class='row'>
            <div class='col-md-8'>
            <span class='float-start'>Amount of Tax Subject to Recvers Change :</span><br>
            </div>
            <div class='col-md-2'>
                <span class='float-end'>GROSS AMOUNT:</span><br>
                <span class='float-end'>LESS DISCOUNT:</span><br>
                <span class='float-end'>ADD CGST :</span> <br>
                <span class='float-end'>ADD SGST : </span><br>
                <span class='float-end'>OTHER ADJ :</span> <br>
                <span class='float-end'>R/OFF AMT :</span> <br>
                <span class='float-end'>G.TOTAL : </span><br>
                </div>
                <div class='col-md-2'>
                    <small class='text-center'>{{$list->total_amount}}</small><br>
                    <small class='text-center'>{{$list->total_amount}}</small><br>
                    <small class='text-center'>{{$list->total_amount}}</small><br>
                    <small class='text-center'>{{$list->total_amount}}</small><br>
                    <small class='text-center'>{{$list->total_amount}}</small><br>
                    <small class='text-center'>{{$list->total_amount}}</small><br>
                    <small class='text-center'>{{$list->total_amount}}</small><br>
                </div>
            </div>
            <hr>
                <div class='row text-center'>
                <h6><b>Thank  Have a Nice Day </b></h6>
                <small>Visit Again !</small>
                </div>
                           
               <div class='modal-footer'>
                <button type='button' class='btn btn-secondary btn-sm' data-bs-dismiss='modal'>Close</button> 
                <button type='button' id='printBtn' class='btn btn-primary btn-sm' order-id='".$order->id."'>Print</button> 
               </div>
                
        
            </div>
               <div class="row mb-3">
                    <div class="col-3">
                         <button class="btn btn-primary btn-sm">save</button>
                    </div>
               </div>
</div> --}}

    <section>
        <div id="newcontent">
            <div class="modal fade" id="generateInvoiceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    
            </div>
        </div>
    </section>
    
   
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customer bills</h3>
            </div>
            <div class="card-body table-responsive p-0" style="height: 350px;">
                <div class="col-md-12 mt-2">
                    <select class="form-select form-select-sm" name="customer_id" id="customer_id" >
                        <option selected="" disabled=""> Select name </option>
                        @foreach ($customers_billing as $item)
                            <option value="{{$item->id}}">{{$item->mobile_no}}-{{$item->customer_name}}</option> 
                        @endforeach
                    </select>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 table-responsive" style="height: 200px;">
                        <table class="table table-striped table-head-fixed " id="customer_list" >
                            
                        </table>    
                    </div>
                </div>
        </div>
    </div>
 </div>
 <div class="col-md-8">
    <div class="card">
        <div class="card-header">
            <b>Invoice</b>
        </div>
        {{-- <div class="card-body">
            <div id="box">
                <div class="row">
                    <div class='col-md-3'>
                        <span>GST NO: <small>4125666</small></span><br>
                    </div>
                    <div class='col-md-6 text-center'>
                        <span>SALES INVOICE</span><br>
                        <span>ERENOWN CLOTHING CO </span><br>
                        <span>Shop no.8-9,Ground Floor Samdariya Mall </span><br>
                        <span>Jabalpur -482002 </span><br>
                    </div>
                    <div class='col-md-3' >
                        <span>Phone no: 0761-4047699</span><br>
                        <span></span><br>
                        <span>Mobile no : 09826683399<small></small></span><br>
                        <span></span><br>
                    </div>
                </div>
                <div class='row' style="padding: 10px;">
                    <div class='col-md-6' style='border:1px solid black'>
                        <span>Customer name: <small></small></span><br>
                        <span>Location : <small>Jabalpur</small></span><br/>
                        <span>State code  : <small>0761</small></span><br>
                    </div>
                     <div class='col-md-2' style='border:1px solid black'>
                        <span class=''>CASH :<br/> <small><b>10000</b></small></span>
                    </div>
                    <div class='col-md-4' style='border:1px solid black'>
                        <span>Invoicen No : <small class='float-end'></small></span><br>
                        <span class=''>Date : <small class='float-end'></small></span><br>
                        <span class=''>Attent By : <small class='float-end'></small></span>
                    </div>
                </div>
                <div class='row mt-2'>
                    <div class='table-responsive'>
                        <table class='table table-bordered'>
                            <thead>
                                    <tr>
                                    <th>#</th>
                                    <th></th>
                                    <th>Item Name</th>
                                    <th>Qty</th>
                                    <th>Size</th>
                                    <th>Color</th>
                                    <th>MRP</th>
                                    <th>Rate</th>
                                    <th>Disc</th>
                                    <th>Total</th>
                                    <th>Taxable</th>
                                    <th>CGST%</th>
                                    <th>SGST%</th>
                                    </tr>
                                </thead>
                                <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
 </div>
</div>

@endsection
@section('script')
<script>
    $(document).ready(function(){
        $(document).on('click','#customer_id', function(e){
            e.preventDefault();
            var customer_id = $(this).val();
            // alert(customer_id);/
            // $('#project_invoice').html("");
            getCustomerBillData(customer_id);
           
        });

        // save alterration bill 
        $(document).on('click','#saveAltertion',function(e){
                e.preventDefault();
                 saveAlterationvoucher();
            });

        $(document).on('click','.orderInvoiceBtn',function(e){
                e.preventDefault();
                // $('#generateInvoiceModal').modal('show');
                const customer_id = $(this).val();
                generateInvoicebill(customer_id);
            });

            $(document).on('click','#checked',function(e){
                e.preventDefault(); 
                const customer_id = $(this).val();

            });    

    });

    function getCustomerBillData(customer_id) {
        $.ajax({
            type: "get",
            url: `get-customers-bills/${customer_id}`,
            dataType: "json",
            success: function (response) {
                if(response.status == 200){
                    $('#customer_list').html("");
                    $('#customer_list').append(response.html);
                }
            }
        });
    } 

    function generateInvoicebill(customer_id) {
         $.ajax({
        type: "get",
        url: "generate-invoice-voucher/"+customer_id,
        dataType: "json",
        success: function (response) {
            //console.log(response);
            if (response.status == 200) {
                $('#generateInvoiceModal').html(response.html);
                $('#generateInvoiceModal').modal('show');
                // $('#box').html(response.html);
               
                
            }
        }
    });
}


function saveAlterationvoucher() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var formData = new FormData($("#alterationVoucherForm")[0]);
    $.ajax({
        type: "post",
        url: "save-alteration-voucher-order",
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status === 400) {
                $('#alternativevoucher_err').html('');
                $('#alternativevoucher_err').addClass('alert alert-danger');
                var count = 1;
                $.each(response.errors, function (key, err_value) {
                    $('#alternativevoucher_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                });

            } else {
                    $('#alternativevoucher_err').html('');
                // $('#supplierModal').modal('hide');
                window.location.reload();
            }
        }
    });
}

</script>

@endsection


