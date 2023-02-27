@extends('layouts.app')
@section('page_title', 'Customer')

@section('content')

<div class="modal fade" id="coustomerModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">CustomerDetail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="customerForm">
                    @csrf
                    <div id="customer_error"></div>
                    <div class="row">
                        <div class="col-md-4">
                            <label  class="form-label">Customer name</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="customer_name" id="customer_name" class="form-control form-control-sm" placeholder="name">
                            {{-- <span class="text-danger">
                                @error('customer_name')
                                    {{$message}}
                                @enderror
                            </span> --}}
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-4">
                            <label  class="form-label">Mobile no</label>
                        </div>
                        <div class="col-md-8">
                            <input type="number" name="mobile_no" id="mobile_no" class="form-control form-control-sm" placeholder="mobile no">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-4">
                            <label  class="form-label">City</label>
                        </div>
                        <div class="col-md-8">
                            <select name="city_id" id="city_id" class="form-select">
                                <option selected disabled>City</option>
                                @foreach ($cities as $item)
                                    <option value="{{ $item->id }}">{{ucwords($item->city) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-4">
                            <label  class="form-label"> Advance amount</label>
                        </div>
                        <div class="col-md-8">
                            <input type="number" name="advance_amount" id="advance_amount" class="form-control form-control-sm" placeholder="amount">
                        </div>
                    </div>
                    <div class="modal-footer mt-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveCustomerBtn" class="btn btn-primary btn-sm ">Save </button>
                        <button type="button" id="updateCustomerBtn" class="btn btn-primary btn-sm hide">Update </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- <div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-primary btn-sm float-right" id="addCustomer"  data-bs-target="#staticBackdrop">Add Advance Amount</button>
    </div>
</div> --}}

<div class="row mt-2">
    <div class="col-md-6">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Customers</h3>
            </div>
            <div class="card-body " >
                <div class="row">
                    <div class="col-md-12 table-responsive p-0" style="height: 550px;">
                        <table class="table table-striped table-head-fixed" id="customer_list">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Customer</th>
                                    <th>Mobile</th>
                                    <th>City</th>
                                    {{-- <th>Advance Amount</th> --}}
                                    <th>Member</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $key => $list)
                                @php
                                    $member = getMemberShip($list->id)
                                @endphp
                                    <tr >
                                        <td>{{++$key}}</td>
                                        <td>{{ucwords($list->customer_name)}}</td>
                                        <td>{{$list->mobile_no}}</td>
                                        <td>{{ucwords($list->city)}}</td>
                                        {{-- <td>{{$list->advance_amount}}</td> --}}
                                        @if($member == MyApp::SILVER)
                                            <td style='color:#454545';><b>{{MyApp::SILVER}}</b></td>
                                        @elseif($member == MyApp::GOLDEN)
                                            <td style='color:#D35400';><b>{{MyApp::GOLDEN}}</b></td>
                                        @else
                                            <td style='color:#5D6D7E';><b>{{MyApp::PLATINUM}}</b></td>
                                        @endif 
                                        <td id="customer_row_id" customer-id="{{$list->id}}"><i class="fas fa-lg fa-file" ></i></td>
                                    </tr>
                                @endforeach
                            </tbody> 
                        </table>    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customer Detail</h3>
            </div>
            <div class="card-body" style="height:550px;">
                <div class="col-md-12 mt-2">
                    <div id="customer_detail_list"></div>

                    
                </div>
            </div>
        </div>
    </div>
</div>

<section>
    <div id="newcontent">
        <div class="modal fade" id="generateInvoiceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                
        </div>
    </div>
</section>

@endsection

@section('script')
<script>
    $(document).ready(function(){

        $(document).ready(function () {
            $(document).on('click','#addCustomer', function (e) {
                e.preventDefault();
                $('#coustomerModal').modal('show');
                $('#customer_error').html('');
                $('#customer_error').removeClass('alert alert-danger');
                $("#customerForm").trigger("reset"); 
                $('#saveCustomerBtn').removeClass('hide');
                $('#updateCustomerBtn').addClass('hide');
            });
        })


        $(document).on('change','#customer_id', function(e){
            e.preventDefault();
            var customer_id = $(this).val();
            getProjects(customer_id);
        });

        // save customer datails
        // $(document).on('click','#saveCustomerBtn', function(e){
        //     e.preventDefault();
        //     // alert("call");
        //     saveCustomerAdvanceAmount();
        // });

        
        $(document).on('click','#customer_row_id', function(e){
            e.preventDefault();
            var customer_id = $(this).attr('customer-id');
            // alert(customer_id);
            CustomerDetail(customer_id);
        });
        $(document).on('click','#showGenerateInvoiceModal', function (e) {
                e.preventDefault();
                var bill_id = $(this).attr('bill-id');
                generateInvoice(bill_id);              
            });


        // $(document).on('click','#client_project_row', function(e){
        //     e.preventDefault();
        //     var customer_id = $(this).val();
        //     // alert(customer_id);
        //      getCustomerPoints(customer_id);
        // });


    });

    // function saveCustomerAdvanceAmount() {
    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });

    //         var formData = new FormData($("#customerForm")[0]);
    //         $.ajax({
    //             type: "POST",
    //             url: "save-customer-advance-amount",
    //             data: formData,
    //             dataType: "json",
    //             cache: false,
    //             contentType: false,
    //             processData: false,
    //             success: function (response) {
    //                 // console.log(response);
    //                 if (response.status === 400) {
    //                     $('#customer_error').html('');
    //                     $('#customer_error').addClass('alert alert-danger');
    //                     var count = 1;
    //                     $.each(response.errors, function (key, err_value) {
    //                         $('#customer_error').append('<span>' + count++ + '. ' + err_value + '</span></br>');
    //                     });

    //                 } else {
    //                     $('#customer_error').html('');
    //                     $('#coustomerModal').modal('hide');
    //                     window.location.reload();
    //                 }
    //             }
    //         });
    //     }

    function getProjects(customer_id) {
        $.ajax({
            type: "get",
            url: `get-customer/${customer_id}`,
            dataType: "json",
            success: function (response) {
               
                if(response.status == 200){
                    $('#customer_list').html("");
                    $('#customer_list').append(response.html);
                }
            }
        });
    } 

    function CustomerDetail(customer_id) {
        $.ajax({
            type: "get",
            url: `customer-detail/${customer_id}`,
            dataType: "json",
            success: function (response) {
               console.log(response);
                if(response.status == 200){
                    $('#customer_detail_list').html("");
                    $('#customer_detail_list').append(response.html);
                }
            }
        });
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