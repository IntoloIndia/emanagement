@extends('layouts.app')
@section('page_title', 'Dashboard')
@section('style')
  
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card mt-3">
            <div class="card-header"><h5><strong>Pending Payment</strong></h5></div>
            <div class="card-body">

                <form id="paymentReceivingForm">
                    @csrf
                    <div id="payment_receiving_err"></div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="moblie_no" class="form-label" >Bill no</label>
                        </div>  
                        <div class="col-md-8">
                            <label for="moblie_no" class="form-label" >Customer</label>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="against_bill_id" id="against_bill_id" class="form-control form-control-sm" placeholder="Enter Bill No">
                        </div>       

                        <div class="col-md-8">
                            <input type="text"  id="customer_name" class="form-control form-control-sm" placeholder="Customer Name" readonly>
                            <input type="hidden" name="customer_id" id="customer_id" class="form-control form-control-sm"  >
                        </div>  
                    </div> 
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="form-label" >Bill Amount</label>
                        </div>  
                        <div class="col-md-6">
                            <label class="form-label" >Balance Amount</label>
                        </div>  
                    </div>   
                    <div class="row">     
                        <div class="col-md-6">
                            <input type="text" id="total_amount" class="form-control form-control-sm"  value="0" readonly >
                        </div>           
                        <div class="col-md-6">
                            <input type="text" name="balance_amount" id="balance_amount" class="form-control form-control-sm" placeholder="Balance Amount" value="0" readonly > 
                        </div> 
                    </div>
                    <div class="row mt-3">
                    <div class="col-md-6"><h5>Payment :</h5></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input payment_mode" type="checkbox" name="payment_mode" id="online" >Online
                            </div>
                        </div>
                        {{-- <div class="col-md-2">
                            <input type="text" name="pay_online" id="online_payment" class="form-control form-control-sm hide" value="0" placeholder="amount">
                        </div> --}}
                    {{-- </div>
                    <div class="row"> --}}
                        <div class="col-md-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input payment_mode" type="checkbox" name="payment_mode" id="cash" >Cash
                            </div>
                        </div>
                        {{-- <div class="col-md-2">
                            <input type="text" name="pay_cash" id="cash_payment" class="form-control form-control-sm hide" value="0" placeholder="amount">
                        </div> --}}
                    {{-- </div>
                    <div class="row"> --}}
                        <div class="col-md-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input payment_mode" type="checkbox" name="payment_mode" id="card" >Card
                            </div>
                        </div>
                        {{-- <div class="col-md-2">
                            <input type="text" name="pay_card" id="card_payment" class="form-control form-control-sm hide"  value="0" placeholder="amount">
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                                <input type="text" name="pay_online" id="online_payment" class="form-control form-control-sm hide" value="0" >
                        </div>
                        <div class="col-md-3">
                                <input type="text" name="pay_cash" id="cash_payment" class="form-control form-control-sm hide" value="0" >
                        </div>
                        <div class="col-md-3">
                                <input type="text" name="pay_card" id="card_payment" class="form-control form-control-sm hide"  value="0">
                        </div>
                        <div class="col-md-3">
                            <div class="col-md-6"><button id="savePaymentReceivingBtn" class="btn btn-primary btn-sm mx-1 ">Payment</button></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- right card --}}
    <div class="col-md-8">
        <div class="card mt-3">
            <div class="card-header"><h5><strong>Payment Receivings</strong></h5></div>
            <div class="card-body">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th row>SN</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Bill No</th>
                            <th>Customer</th>
                            <th>Online</th>
                            <th>Cash</th>
                            <th>Card</th>
                            {{-- <th colspan="3">Payment By</th> --}}
                            <th>Total Amount</th>
                        </tr>
                        {{-- <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Online</th>
                            <th>Cash</th>
                            <th>Card</th>
                        </tr> --}}
                    </thead>
                    <tbody id="filter_table">
                        @php
                            $pay_online =0;
                            $pay_cash =0;
                            $pay_card =0;
                            $total_balance_amount =0;
                        @endphp
                        @foreach ($all_receiving_payment as $key=> $list)
                            <tr class="">
                                @php
                                    $balance_amount = ($list->pay_online + $list->pay_cash + $list->pay_card);
                                @endphp
                                <td>{{++$key}}</td>
                                <td>{{ date('d-m-Y', strtotime($list->against_payment_date))}}</td>
                                <td>{{ ($list->against_payment_time)}}</td>
                                <td>{{ ($list->against_bill_id)}}</td>
                                <td>{{ ucwords($list->customer_name)}}</td>
                                <td>{{ ($list->pay_online)}}</td>
                                <td>{{ ($list->pay_cash)}}</td>
                                <td>{{ ($list->pay_card)}}</td>
                                <td>{{$balance_amount}}</td>
                                @php
                                    $pay_online = ($pay_online) + $list->pay_online ;
                                    $pay_cash = ($pay_cash) + $list->pay_cash ;
                                    $pay_card = ($pay_card) + $list->pay_card ;
                                    $total_balance_amount = ($total_balance_amount) + $balance_amount ;
                                @endphp
                                {{-- <td>{{ ($list->against_bill_id)}}</td> --}}
                                <td>
                                    
                                   
                                    {{-- @if($list->active_role == MyApp::ACTIVE)
                                        <button type="button" class="btn  btn-sm activeRoleBtn ml-1" value="{{$list->id}}"><i class="fas fa-ban" style="font-size:24px;color:lightcoral"></i></button> 
                                        
                                    @else
                                        <button type="button" class="btn btn btn-sm activeRoleBtn ml-1" value="{{$list->id}}"><i class="far fa-check-circle" style="font-size:24px;color:rgb(5, 119, 5)"></i></button> 
                                    @endif --}}
                                </td>
                            </tr>
                        @endforeach 
                        <tr>
                            <td colspan="4"></td>
                            <td><b>Total : </b></td>
                            <td><b>{{$pay_online}}</td>
                            <td><b>{{$pay_cash}}</b></td>
                            <td><b>{{$pay_card}}</b></td>
                            <td><b>{{$total_balance_amount}}</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>




</div>
@endsection

@section('script')
    <script>

       $(document).ready(function () {
            $(document).on('change','#against_bill_id',function (e) {
                var bill_id = $(this).val();              
                paymentReceiving(bill_id);
            });

            $('#online').change(function(){
                if($(this).is(":checked")) {
                    $('#online_payment').removeClass("hide");
                } else {
                    $('#online_payment').addClass("hide");
                }
            });
            $('#cash').change(function(){
                if($(this).is(":checked")) {
                    $('#cash_payment').removeClass("hide");
                } else {
                    $('#cash_payment').addClass("hide");
                }
            });
            $('#card').change(function(){
                if($(this).is(":checked")) {
                    $('#card_payment').removeClass("hide");
                } else {
                    $('#card_payment').addClass("hide");
                }
            });
            $(document).on('click','#savePaymentReceivingBtn',function (e) {
                // alert("dsf");
                e.preventDefault();
                savePaymentReceiving();
            });

            
                 
        });
        function paymentReceiving(bill_id)
        {
            $.ajax({
                type: "get",
                url: "get-payment-receiving/" + bill_id,
                data: "formData",
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        // console.log(response);
                        $('#customer_name').val(response.payment_receiving.customer_name);
                        $('#customer_id').val(response.payment_receiving.customer_id);
                        $('#total_amount').val(response.payment_receiving.total_amount);
                        $('#balance_amount').val(response.payment_receiving.balance_amount);
                     
                    }
                }
            });
        }

        function savePaymentReceiving()
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = new FormData($("#paymentReceivingForm")[0]);
            $.ajax({
                type: "post",
                url: "save-payment-receiving",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    console.log(response);
                    if(response.status === 400)
                    {
                        $('#payment_receiving_err').html('');
                        $('#payment_receiving_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) { 
                            $('#payment_receiving_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                    });
                    }else{
                        $('#payment_receiving_err').html('');
                        window.location.reload();
                    }
                }
            });
        }
    </script>
@endsection