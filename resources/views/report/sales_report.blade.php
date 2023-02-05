@extends('layouts.app')
@section('page_title', 'Sales Report')
@section('style')
    <style>
    </style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    {{-- @php
                        if($from_date == '')
                        {
                            $from_date = {{date('d-m-Y')}};                    

                        }
                    @endphp --}}

                    <div class="col-md-3"><b>Sales Report</b></div>
                    <div class="col-md-3">
                        <input type="date"  id="from_date" class="form-control form-control-sm" value='{{date('d-m-Y', strtotime('-3 months'))}}'>
                    </div>
                    <div class="col-md-3">
                        <input type="date"  id="to_date" class="form-control form-control-sm" value='{{date('d-m-Y')}}'>
                    </div>
                    <div class="col-md-3">
                        <input type="month"  id="month" class="form-control form-control-sm" value="{{date('Y-m-d')}}">
                    </div>
                </div>
               
            </div>
            <div class='card-body table-responsive' style='height: 500px;'>
                <div id="show_sales_report_detail"></div>
                
              {{-- <div class='accordion accordion-flush table-responsive' id='accordionFlushExample' style='max-height: 500px;'>
                    <table class='table table-striped table-head-fixed'>
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Customer name</th>
                                <th>Mobile</th>                                
                            </tr>
                        </thead>          
                        <tbody>
                            @foreach ($customers as $key => $list)                           
                                <tr class='accordion-button collapsed' data-bs-toggle='collapse' data-bs-target='#collapse_{{$list->id}}' aria-expanded='false' aria-controls='flush-collapseOne'>                               
                                    @php
                                        $sales_payments = getSalesPayment($list->id);                                        
                                    @endphp
                                    <td>{{++$key}}</td>                     
                                    <td>{{$list->date}}</td>
                                    <td>{{$list->time}}</td>
                                    <td>{{$list->customer_name}}</td>
                                    <td>{{$list->mobile_no}}</td>                                  
                                </tr>        
                                <tr>
                                    <td colspan='7'>
                                        <div id='collapse_{{$list->id}}' class='accordion-collapse collapse' aria-labelledby='flush-headingOne' data-bs-parent='#accordionFlushExample'>
                                            <div class='accordion-body'>
                                                <table class='table'>
                                                    <thead>
                                                        <tr>
                                                            <th>SNo</th>
                                                            <th>Product</th>
                                                            <th>Qty</th>
                                                            <th>Size</th>
                                                            <th>Price</th>
                                                            <th>Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>                                                   
                                                            @foreach ($sales_payments as $key => $list)  
                                                                <tr>  
                                                                    <td>{{++$key}}</td>
                                                                    <td>{{$list->sub_category}}</td>
                                                                    <td>{{$list->qty}}</td>
                                                                    <td>{{$list->size}}</td>
                                                                    <td>{{$list->price}}</td>
                                                                    <td>{{$list->taxfree_amount}}</td>
                                                                </tr>  
                                                            @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>                                   
                                    </td>
                                </tr>
                            @endforeach                                    
                        </tbody>
                    </table>
                </div>--}}

                
            </div> 
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><b>Sales Payment</b></div>
            <div class='card-body ' style='height: 500px;'>              
                <div class="row mt-2">                   
                    <div class="col-md-4">
                        <label>Total Qty</label>
                        <input type="text"  id="total_qty" class="form-control form-control-sm" disabled>  
                    </div>
                    <div class="col-md-4">
                        <label>Price</label>
                        <input type="text"  id="total_price" class="form-control form-control-sm" disabled>  
                    </div>
                    <div class="col-md-4">
                        <label>Discount</label>
                        <input type="text"  id="total_discount" class="form-control form-control-sm" disabled>  
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <label>Online</label>
                        <input type="text"  id="online" class="form-control form-control-sm" disabled>  
                    </div>
                    <div class="col-md-4">
                        <label>Cash</label>
                        <input type="text"  id="cash" class="form-control form-control-sm" disabled>  
                    </div>
                    <div class="col-md-4">
                        <label>Card</label>
                        <input type="text"  id="card" class="form-control form-control-sm" disabled>  
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <label>Received</label>
                        <input type="text"  id="received_amount" class="form-control form-control-sm" disabled>  
                    </div>
                    <div class="col-md-4">
                        <label>Balance</label>
                        <input type="text" id="balance_amount" class="form-control form-control-sm" disabled>  
                    </div>
                    <div class="col-md-4">
                        <label>Total Amount</label>
                        <input type="text"  id="total_amount" class="form-control form-control-sm" disabled>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>    
        $(document).ready(function () {
            
          
            salesReportDetail();
            // salesReportDetail(month ='');
            // $(document).on('change','#month', function (e) {
            //     var month = $(this).val();
            //     alert(month);
            //     salesReportDetail(month);
            // });
        });
        
    function salesReportDetail()
    // function salesReportDetail(month)
    {
        $.ajax({
            type: "get",
            dataType: "json",
            url: "sales-report-detail",
            success: function (response) {
                console.log(response);
                if(response.status == 200){
                    $('#show_sales_report_detail').html("");
                    $('#show_sales_report_detail').append(response.html);
                    $('#total_qty').val(response.total_qty);
                    $('#total_price').val(response.total_price);
                    $('#total_discount').val(response.total_discount);
                    $('#online').val(response.online);
                    $('#cash').val(response.cash);
                    $('#card').val(response.card);
                    $('#received_amount').val(response.received_amount);
                    $('#total_amount').val(response.amount);
                    $('#balance_amount').val(response.total_balance_amount);
                }
            }
        });
    }
    function getSalesPayment($customer_id = '')
    // function getSalesPayment($customer_id = '',month)
    {
        var month = $(this).val();
        // alert(month);
        $.ajax({
            type: "get/"+$customer_id,
            // type: "get/"+$customer_id+ "/"+ month,
            dataType: "json",
            url: "get-sales-payment",
            success: function (response) {
                console.log(response);
                if(response.status == 200){                  
                    $('#month').val($month);
                    getSalesPayment(customer_id = '');
                    // getSalesPayment(customer_id = '',month);
                }
            }
        });
    }


    </script>
@endsection