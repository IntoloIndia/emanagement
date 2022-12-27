@extends('layouts.app')
@section('page_title', 'Sales Return')

@section('content')

{{-- delete modal start  --}}

{{-- <div class="modal fade" id="releaseStatusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Delete Brand </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <h5> Do you want to release sale return item?</h5>
                        <button type="button" id="yesReleaseStatusBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                        <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                    <hr>
                </center>
            </div>
        </div>
    </div>
  </div> --}}

{{-- delete modal end  --}}

<div class="row">
    <div class="col-md-8">
        <div class="card">
                <div class="card-header">
                    <b>Sales Return / Credit Note</b>
                </div>
             <div class="card-body">

               <form id="salesReturnItemsData">
                    @csrf
                    <div id="sales_return_error"></div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="exampleFormControlInput1" class="form-label" >Bill no</label>
                            <input type="text" name="bill_id" id="customer_bill_no" class="form-control form-control-sm" placeholder="bill no">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleFormControlInput1" class="form-label">Mobile no</label>
                            <input type="text" name="mobile_no" id="mobile_no" class="form-control form-control-sm" placeholder="mobile_no" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="exampleFormControlInput1" class="form-label">Customer name</label>
                            <input type="text" name="customer_name" id="customer_name" class="form-control form-control-sm" readonly placeholder="customer name">
                            <input type="hidden" name="customer_id" id="customer_id" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3">
                            <label for="exampleFormControlInput1" class="form-label" >Date</label>
                            <input type="text" name="bill_date" id="bill_date" class="form-control form-control-sm" readonly placeholder="date">
                        </div>
                   </div>
                    {{-- <div class="row mt-2">
                        <div class="col-md-12">
                            <label for="exampleFormControlInput1" class="form-label" >Barcode</label>
                            <input type="text" name="barcode" id="product_barcode" class="form-control form-control-sm"  placeholder="barcode" disabled>
                        </div>
                    </div> --}}
                        <div class="card mt-3">
                            <div class="card-header">
                                <b>Customer Details</b>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Barcode</th>
                                                        <th scope="col">Product name</th>
                                                        <th scope="col">Qty</th>
                                                        <th scope="col">Size</th>
                                                        {{-- <th scope="col">Color</th> --}}
                                                        <th scope="col">MRP</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="item_list">
                                                        
                                                    </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
                <button class="btn btn-primary btn-sm float-right saveSalesReturnbtn" id="saveSalesReturnbtn">save</button>
            </div>
         </div>
     </div>
     <div class="col-md-4">
        @foreach ($sales_return as $key1 => $list)
             <div class="card">
                 <div class="card-header">
                     <h3 class="card-title"> <b>{{ucwords($list->customer_id)}}</b></h3>
                 </div>
                 <div class="card-body">
                     <div class="table-responsive">
                         <table class="table">
                             <thead>
                               <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product name</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Size</th>
                                <th scope="col">MRP</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                               </tr>
                             </thead>
                              @php  
                                  $count =0
                              @endphp
                             <tbody>
                              @foreach ($sales_return_items[$key1] as $item)
                                  <tr>
                                     <td>{{++$count}}</td>
                                     <td>{{$item->sub_category}}</td>
                                     <td>{{$item->qty}}</td>
                                     <td>{{$item->size}}</td>
                                     <td>{{$item->mrp}}</td>
                                     <td>{{$item->amount}}</td>
                                     <td>{{date('d-m-Y',strtotime($item->create_date))}}</td>
                                     <td>{{$item->create_time}}</td>
                                  </tr>
                              @endforeach
                             </tbody>
                             
                           </table>
                     </div>
                 </div>
             </div>
         @endforeach
     </div>
</div>



<table class="hide">
    <tbody id="item_row">
        <tr>
            <td id="count_item"></td>
            <td>
                <input type="text" name="barcode[]" id="product_barcode" class="form-control form-control-sm barcode"  placeholder="barcode">

            </td>
            <td>
                <input type="text" class="form-control form-control-sm sub_category" id="sub_category" readonly >
                <input type="hidden" name="sub_category_id[]"  id="sub_category_id"class="form-control form-control-sm sub_category_id">
            </td>
           
            <td style="width: 50px;">
                <input type="text" id="qty" name="qty[]" value="1" class="form-control form-control-sm qty" min="1" value="0">
            </td>
            <td style="width: 50px;">
                <input type="text"  name="size[]" class="form-control form-control-sm size" id="size" readonly>
                {{-- <input type="hidden" name="size_id[]" class="size_id"> --}}
            </td>
            {{-- <td style="width: 100px;">
                <input type="text"  name="color" class="form-control form-control-sm" id="color" readonly>
                {{-- <input type="hidden" name="size_id[]" class="size_id"> --}}
            {{-- </td> --}} 
            <td style="width: 100px;">
                <input type="text" name="mrp[]" class="form-control form-control-sm mrp" id="mrp"  readonly>
            </td>
            <td style="width: 150px;">
                <input type="text" name="amount[]" class="form-control form-control-sm amount" id="amount" readonly>
           </td> 
            
            <td>
                <button type="button" class="btn btn-danger btn-flat btn-sm delete_item"><i class="far fa-window-close"></i></button>
            </td>
        </tr>
    </tbody>
</table>
@section('script')
    <script>
        $(document).ready(function(){
            addItem();
                // $(document).on('change','#product_barcode',function(){
                //     addItem();
                // });

                $(document).on('click','#saveSalesReturnbtn',function(){
                    // alert("call")
                        saveSalesReturnProduct();
                });

                    $(document).on('click','.releaseStatusBtn', function (e) {
                    e.preventDefault();
                    const sales_return_id = $(this).val();
                    alert(sales_return_id);
                    $('#releaseStatusModal').modal('show');
                    $('#yesReleaseStatusBtn').val(sales_return_id);
                    });

                    $(document).on('click','#yesReleaseStatusBtn', function (e) {
                        e.preventDefault();
                        const sales_return_id = $(this).val();
                        updateSalesReleaseStatus(sales_return_id);
                    });

                    $(document).on("click",".delete_item", function(){
                            if($("#item_list tr").length == 0)
                            {
                                // alert("Order must have at least 1 item.");
                                return false;
                            }
                            $(this).parent().parent().remove();
                    });
        })


         // function start 
         function addItem() {
            $('#item_list').append($('#item_row').html());
            // $("#item_list tr").find(".item").chosen();
        }


        $(document).on('change','#customer_bill_no', function () {
                const bill_no = $(this).val();
                $.ajax({
                    type: "get",
                    url: "get-customer-details/"+bill_no,
                    dataType: "json",
                    success: function (response) {
                        
                        console.log(response);
                        if(response.status==200){
                            $('#customer_name').val(response.customer_details.customer_name);
                            $('#customer_id').val(response.customer_details.customer_id);
                            $('#bill_date').val(response.customer_details.bill_date);
                            $('#mobile_no').val(response.customer_details.mobile_no);
                           
                        }else{
                            $('#customer_name').val('')
                            $('#bill_date').val('')
                            $('#mobile_no').val('')
                          
                        }
                    }
                });
                
            });


        $(document).on('change','#product_barcode', function () {
            const bill_no = $('#customer_bill_no').val();
            const barcode_code = $(this).val();
            // const barcode_code = $(object).val();
             var object = $(this);
            //    alert(bill_no);
                $.ajax({
                    type: "get",
                    url: "sales-return-item/"+bill_no+"/"+barcode_code,
                    dataType: "json",
                    success: function (response) {
                        addItem();
                        console.log(response);
                        $(object).parent().parent().find('.size').val(response.customer_return_product.size);
                        $(object).parent().parent().find('.sub_category').val(response.customer_return_product.sub_category);
                        $(object).parent().parent().find('.sub_category_id').val(response.customer_return_product.product_id);
                        $(object).parent().parent().find('.qty').val(response.customer_return_product.qty);
                        $(object).parent().parent().find('.mrp').val(response.customer_return_product.price);
                        $(object).parent().parent().find('.amount').val(response.customer_return_product.amount);
                       
                        // $('#color').val(response.customer_return_product.color);
                    }
                });
                
            });

            function saveSalesReturnProduct() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#salesReturnItemsData")[0]);
            $.ajax({
                type: "post",
                url: "save-sales-return-item",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                    // if (response.status === 400) {
                    //     $('#sales_return_error').html('');
                    //     $('#sales_return_error').addClass('alert alert-danger');
                    //     var count = 1;
                    //     $.each(response.errors, function (key, err_value) {
                    //         $('#sales_return_error').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                    //     });

                    // } else {
                    //     $('#sales_return_error').html('');
                    //     // window.location.reload();
                    // }
               }
            });
        }


        function updateSalesReleaseStatus(sales_return_id) {
        $.ajax({
            type: "get",
            url: `update-release-status/${sales_return_id}`,
            dataType: "json",
            success: function (response) {
                console.log(response);
                if(response.status == 200){
                }
                // window.location.reload();
            }
        });
    } 

    </script>
@endsection
@endsection
