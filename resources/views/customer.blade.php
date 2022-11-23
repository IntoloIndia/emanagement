@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <b>card</b>
            </div>
            <div class="card-body">
                <form id="orderCustomer">
                    @csrf
                    <div class="row">
                        <div class="order_err"></div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="text" class="form-control" id="datepicker">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="moblie_no" class="form-label" >moblie no</label>
                                <input type="text" class="form-control" name="mobile_no" id="moblie_no" placeholder="Enter mobile number" min="1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text"  class="form-control" id="customer_name" name="customer_name" placeholder="Enter name">
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm float-right" id="saveOrderCustomerBtn">save</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
     $(document).ready(function () {
            $(document).on('click','#saveOrderCustomerBtn', function (e) {
                e.preventDefault();
                saveOrderCustomer();
            });

        })  
        
        function saveOrderCustomer() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#orderCustomer")[0]);
            $.ajax({
                type: "post",
                url: "save-order-customer",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
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

</script>

@endsection