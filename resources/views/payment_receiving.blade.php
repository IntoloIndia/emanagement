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
                            <input type="text" id="total_amount" class="form-control form-control-sm"  value="0" readonly>
                        </div>           
                        <div class="col-md-6">
                            <input type="text" name="balance_amount" id="balance_amount" class="form-control form-control-sm" placeholder="Balance Amount" value="0" readonly> 
                        </div> 
                    </div>
                    <div class="row mt-3">
                    <div class="col-md-6"><h5>Payment :</h5></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input payment_mode" type="checkbox" name="payment_mode" id="online" value="{{MyApp::ONLINE}}">Online
                            </div>
                        </div>
                        {{-- <div class="col-md-2">
                            <input type="text" name="pay_online" id="online_payment" class="form-control form-control-sm hide" value="0" placeholder="amount">
                        </div> --}}
                    {{-- </div>
                    <div class="row"> --}}
                        <div class="col-md-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input payment_mode" type="checkbox" name="payment_mode" id="cash" value="{{MyApp::CASH}}">Cash
                            </div>
                        </div>
                        {{-- <div class="col-md-2">
                            <input type="text" name="pay_cash" id="cash_payment" class="form-control form-control-sm hide" value="0" placeholder="amount">
                        </div> --}}
                    {{-- </div>
                    <div class="row"> --}}
                        <div class="col-md-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input payment_mode" type="checkbox" name="payment_mode" id="card" value="{{MyApp::CARD}}">Card
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