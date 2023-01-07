@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')

 {{-- delete modal start  --}}

 <div class="modal fade" id="releaseStatusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title" id="exampleModalLabel"> Delete Brand </h5> --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <h5> Do you want to release purchase return item?</h5>
                        <button type="button" id="yesReleaseStatusBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                        <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                    <hr>
                </center>
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
                  <div class="row">
                    <div class="col-md-12">
                        <label for="exampleFormControlInput1" class="form-label" >Barcode</label>
                        <input type="text" name="" id="barcode" class="form-control form-control-sm" placeholder="barcode" autocomplete="off">
                    </div>
                  </div>
                  <div class="card mt-2">
                      <div class="card-header">
                          <b>Product Details</b>
                          <button class="btn-primary btn-sm float-right" id="saveReturnItem">Add</button>
                       </div> 
                        <div class="card-body">
                            <form id="returnItemsData" >
                                @csrf
                                <div class="return_item_err"></div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Supplier </th>
                                                <th scope="col">Product </th>
                                                <th scope="col">Size</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Color</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="item_list">
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                      </div>
                  </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
           @foreach ($purchase_return as $key1 => $list)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> <b>{{ucwords($list->supplier_name)}}</b></h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Item name</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                    {{-- <th scope="col">Action</th> --}}
                                  </tr>
                                </thead>
                                 @php
                                //  $purchase_return_item_data = purchaseReturnItemsdata($purchase_returns->supplier_id);   
                                     $count =0
                                 @endphp
                                <tbody>
                                    {{-- @if (MyApp::RELEASE_STATUS){

                                    }
                                        
                                    @endif --}}
                                 @foreach ($purchase_return_items[$key1] as $item)
                                     <tr>
                                        <td>{{++$count}}</td>
                                        <td>{{$item->sub_category}}</td>
                                        <td>{{$item->qty}}</td>
                                        <td>{{$item->size}}</td>
                                        <td>{{$item->color}}</td>
                                        <td>{{date('d-m-Y',strtotime($item->date))}}</td>
                                        <td>{{$item->time}}</td>
                                     </tr>
                                 @endforeach
                                </tbody>
                                
                              </table>
                        </div>
                    </div>
                        {{-- <hr/> --}}
                         {{-- card footer  --}}
                        <div class="card-footer">
                            <button class="btn btn-warning btn-sm float-right releaseStatusBtn" id="release_date" value="{{$list->id}}">Relese</button>
                        </div>
                          {{-- card footer  --}}
                </div>
            @endforeach
        </div>
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
                                <td>{{$list->supplier_name}}</td>   
                                <td>{{date('d-m-Y',strtotime($list->release_date))}}</td>
                                <td>{{$list->release_time}}</td>
                                <td>
                                <button type="button" class="btn btn-success btn-flat btn-sm returnproductBtn" value="{{$list->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice"><i class="fas fa-file-invoice"></i></button>
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
                <td id="count_item"></td>
    
                <td>
                    <input type="text"   class="form-control form-control-sm supplier_name" id="supplier_name" readonly >
                    <input type="hidden" name="supplier_id" id="supplier_id">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" id="sub_category" readonly >
                    <input type="hidden" name="sub_category_id"  id="sub_category_id">
                </td>
                <td>
                    <input type="text"  name="size" class="form-control form-control-sm size" id="size" readonly>
                    {{-- <input type="hidden" name="size_id[]" class="size_id"> --}}
                </td>
                <td>
                    <input type="text" id="qty" name="qty" value="1" class="form-control form-control-sm qty" min="1" value="0">
                </td>
                <td>
                    <input type="text"  name="color" class="form-control form-control-sm" id="color" readonly>
                    {{-- <input type="hidden" name="size_id[]" class="size_id"> --}}
                </td>
                
                <td>
                    <button type="button" class="btn btn-danger btn-flat btn-sm delete_item"><i class="far fa-window-close"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
    
    <section>
        <div class="modal fade" id="viewAlterVoucherModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="height: 550px;">
            <div class="modal-dialog modal-md modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Supplier Details / Debit Note</h5>
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
                            {{-- <div class="col-6"><h6>GSTNO : 1245GDFTE4587</h6></div>
                            <div class="col-6 text-end"><h6>Mobile No : 5487587458</h6></div> --}}
                        </div>
                        <hr>
                        <div id='alter_item_list'></div>
                        {{-- <div class="row">
                            <div class="col-md-12 text-center">
                                <p>Thankyou! Visit Again</p>
                            </div>
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-sm float-end " id="printAlterReceiptBrn">Print</button>
                    </div>
                </div>
            </div>
        </div> 
    </section>
   

@section('script')
<script>
    $(document).ready(function(){
        $(document).on('change','#barcode',function(){
            addItem();
        });
        // save funcation 
        $(document).on('click','#saveReturnItem',function(){
            // alert("call");
            saveReturnProduct();
        });

        $(document).on('click','.returnproductBtn',function(){
          var purchase_return_id = $(this).val();
            $('#viewAlterVoucherModal').modal('show');
            purchaseReturnInvoice(purchase_return_id);
    
            
        });

        $(document).on('click','#printAlterReceiptBrn', function () {
                // $('#viewAlterVoucherModal').modal('show');
                printAlterReceipt();
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
                        // console.log(response);
                        if (response.status == 200) {
                            $('#supplier_id').val(response.return_product.supplier_id);
                            $('#supplier_name').val(response.return_product.supplier_name);
                            $('#sub_category').val(response.return_product.sub_category);
                            $('#sub_category_id').val(response.return_product.sub_category_id);
                            $('#size').val(response.return_product.size);
                            // $('#qty').val(response.return_product.qty);
                            $('#color').val(response.return_product.color);
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
                        window.location.reload();
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
                console.log(response);
                if(response.status == 200){
                    $('#alter_item_list').html("");
                    $('#alter_item_list').append(response.html);
                }
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
@endsection
