@extends('layouts.app')
@section('page_title', 'Sales Return')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <b>Sales Return / Credit Note</b>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                    <label for="exampleFormControlInput1" class="form-label" >Barcode</label>
                    <input type="text" name="" id="barcode" class="form-control form-control-sm" placeholder="barcode">
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
                                            <th scope="col">Customer name</th>
                                            <th scope="col">Product name</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Size</th>
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
                <input type="text" id="qty" name="qty" value="1" class="form-control form-control-sm qty" min="1" value="0"readonly>
            </td>
            <td>
                <input type="text"  name="size" class="form-control form-control-sm size" id="size" readonly>
                {{-- <input type="hidden" name="size_id[]" class="size_id"> --}}
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

        $(document).on('change','#barcode', function () {
                const barcode_code = $(this).val();
                // var object = $(this);
                $.ajax({
                    type: "get",
                    url: "sales-return-item/"+barcode_code,
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        $('#supplier_name').val(response.return_product.supplier_name);
                        $('#supplier_id').val(response.return_product.id);
                        $('#size').val(response.return_product.size);
                        $('#sub_category').val(response.return_product.sub_category);
                        $('#sub_category_id').val(response.return_product.sub_category_id);
                        $('#qty').val(response.return_product.qty);
                        $('#color').val(response.return_product.color);
                       
                    }
                });
                
            });

    </script>
@endsection
@endsection
