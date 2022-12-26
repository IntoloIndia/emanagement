@extends('layouts.app')
@section('page_title', 'Sales Return')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <b>Sales Return / Credit Note</b>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3">
                    <label for="exampleFormControlInput1" class="form-label" >Bill no</label>
                    <input type="text" name="" id="customer_bill_no" class="form-control form-control-sm" placeholder="bill no">
                </div>
                <div class="col-md-3">
                    <label for="exampleFormControlInput1" class="form-label">Mobile no</label>
                    <input type="text" name="mobile_no" id="mobile_no" class="form-control form-control-sm" placeholder="mobile_no">
                </div>
                <div class="col-md-3">
                    <label for="exampleFormControlInput1" class="form-label">Customer name</label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control form-control-sm" placeholder="customer name">
                </div>
                <div class="col-md-3">
                    <label for="exampleFormControlInput1" class="form-label" >Date</label>
                    <input type="text" name="bill_date" id="bill_date" class="form-control form-control-sm" placeholder="date">
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-md-12">
                    <label for="exampleFormControlInput1" class="form-label" >Barcode</label>
                    <input type="text" name="barcode" id="barcode" class="form-control form-control-sm barcode" placeholder="barcode">
                </div>
              </div>
              <div class="card mt-3">
                <div class="card-header">
                    <b>Customer Details</b>
                    <button class="btn btn-primary btn-sm float-right">Add</button>
                </div>
                <div class="card-body">
                  <form action="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Product name</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Size</th>
                                            <th scope="col">Color</th>
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
                  </form>
                </div>
              </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <h1>12271144022</h1>
    </div>
</div>

<table class="hide">
    <tbody id="item_row">
        <tr>
            <td id="count_item"></td>

            <td>
                <input type="text" class="form-control form-control-sm" id="sub_category" readonly >
                <input type="hidden" name="sub_category_id"  id="sub_category_id">
            </td>
           
            <td style="width: 50px;">
                <input type="text" id="qty" name="qty" value="1" class="form-control form-control-sm qty" min="1" value="0">
            </td>
            <td style="width: 50px;">
                <input type="text"  name="size" class="form-control form-control-sm size" id="size" readonly>
                {{-- <input type="hidden" name="size_id[]" class="size_id"> --}}
            </td>
            <td style="width: 100px;">
                <input type="text"  name="color" class="form-control form-control-sm" id="color" readonly>
                {{-- <input type="hidden" name="size_id[]" class="size_id"> --}}
            </td>
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
                $(document).on('click','#barcode',function(){
                addItem();
            });
        })

         // function start 
         function addItem() {
            $('#item_list').append($('#item_row').html());
            // $("#item_list tr").find(".item").chosen();
        }


        $(document).on('click','#customer_bill_no', function () {
            const bill_no = $(this).val();
            $.ajax({
                type: "get",
                url: "get-customer-details/"+bill_no,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if(response.status==200){
                        $('#customer_name').val(response.customer_details.customer_name);
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

        $(document).on('click','.barcode', function () {

            var barcode = $(this);
            alert(barcode);
            
        });



        $(document).on('change','#barcode', function () {
                const barcode_code = $(this).val();

                // var object = $(this);
                $.ajax({
                    type: "get",
                    url: "sales-return-item/"+barcode_code,
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        // $('#customer_name').val(response.return_product.customer_name);
                        // $('#supplier_id').val(response.return_product.id);
                        // $('#size').val(response.return_product.size);
                        // $('#sub_category').val(response.return_product.sub_category);
                        // $('#sub_category_id').val(response.return_product.sub_category_id);
                        // $('#qty').val(response.return_product.qty);
                        // $('#color').val(response.return_product.color);
                        // $('#mrp').val(response.return_product.mrp);
                        // $('#amount').val(response.return_product.amount);
                       
                    }
                });



                
                
        });

    </script>
@endsection
@endsection
