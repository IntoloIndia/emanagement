@extends('layouts.app')
@section('page_title', 'Company Purchase')

@section('content')
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <b>Company Purchase</b>
                </div>
                <div class="card-body">
                    <form id="purchaseCompanyItemsData">
                        @csrf
                        <div class="return_item_err"></div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <b>Supplier Details</b>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <select id="company_supplier_id" name="company_supplier_id" class="form-select form-select-sm">
                                                    <option selected disabled value="0">Supplier</option>                                          
                                                    @foreach ($companySuppliers as $list)
                                                    <option value="{{$list->id}}" state-type="{{$list->state_type}}"> {{ucwords($list->supplier_name)}} </option>
                                                    @endforeach
                                                </select> 
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="supplier_code" id="supplier_code" class="form-control form-control-sm" placeholder="Supplier Code" readonly >
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text"  name="gst_no"  id="gst_no" class="form-control form-control-sm" placeholder="GSTIN" readonly >
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <textarea class="form-control" name="supplier_address" id="supplier_address" style="height: 40px;"  placeholder="Address"  readonly></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                           
                        <div class="card mt-1">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-3">
                                        <b>Product Details</b>
                                    </div>
                                    {{-- <div class="col-md-3">
                                        <b>017791071723</b>
                                    </div> --}}
                                    <div class="col-md-4">
                                        <input type="text" name="barcode" id="barcode" class="form-control form-control-sm" placeholder="barcode" autocomplete="off">
                                    </div>
                                </div>
                            </div> 
                  
                            <div class="card-body" >
                                <div class="row">
                                    <div class="col-md-4">
                                        <small  ><b>Style no</b> </small>
                                        <input type="hidden" name="style_no_id" id="style_no_id">
                                        <input type="text" name="style_no" id="style_no"  class="form-control form-control-sm" placeholder="style no" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <small  ><b>Color</b> </small>
                                        <input type="text" name="color" id="color" class="form-control form-control-sm" placeholder="color" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <small  ><b>Size</b> </small>
                                        <input type="text" name="size" id="size" class="form-control form-control-sm" placeholder="size" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <small  ><b>Qty</b> </small>
                                        <input type="text" name="qty" id="qty" class="form-control form-control-sm" placeholder="qty" value="1">
                                    </div>
                                    <div class="col-md-2">
                                        <small  ><b>Price</b> </small>
                                        <input type="text" name="price" id="price" class="form-control form-control-sm" placeholder="price" readonly>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </form>
                    <div class="col-md-12">
                        <button class="btn-primary btn-sm float-right" id="saveCompanyPurchaseItem">Add</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <b>Company Supplier Name</b>
                    <button type='button' class='btn btn-success btn-sm ml-2 float-right generatePurchaseInvoice' data-bs-toggle='tooltip' data-bs-placement='top' title='Invoice'><i class='fas fa-file-invoice'></i></button>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">SN</th>
                            <th scope="col">Style no</th>
                            <th scope="col">Color</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>PE1001458</td>
                            <td>Black</td>
                            <td>4</td>
                            <td>2023-01-12</td>
                            <td>5:13 PM</td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>PE1001458</td>
                            <td>Black</td>
                            <td>6</td>
                            <td>2023-01-12</td>
                            <td>5:13 PM</td>
                          </tr>
                          <tr>
                            <td>3</td>
                            <td>PE1001458</td>
                            <td>Black</td>
                            <td>8</td>
                            <td>2023-01-12</td>
                            <td>5:13 PM</td>
                          </tr>
                        </tbody>
                      </table>
                </div>
            </div>
        </div>    
    </div>

    <div class="modal fade" id="generatePurchaseInvoiceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Debit Note Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm float-end" onClick="printAlterReceipt()">Print</button>
                </div>
            </div>
        </div>
    </div>  
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $(document).on('change','#company_supplier_id', function (e) {
                e.preventDefault();
                var company_supplier_id = $('#company_supplier_id').val();
                companySupplierDetail(company_supplier_id);
            });

            $(document).on('click','#saveCompanyPurchaseItem',function(){
                saveCompanyPurchaseProduct();
            });

            $(document).on('click','.generatePurchaseInvoice',function(){
                var purchase_return_id = $(this).val();
                $('#generatePurchaseInvoiceModal').modal('show');
            });



            // functions

            function companySupplierDetail(company_supplier_id) {
                $.ajax({
                    type: "get",
                    url: "company-supplier-detail/"+company_supplier_id,
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 200) {
                            $('#gst_no').val(response.companySupplier.gst_no) ;
                            $('#supplier_code').val(response.companySupplier.supplier_code) ;
                            $('#supplier_address').val(response.companySupplier.address) ;
                        }
                    }
                });
            }


            function saveCompanyPurchaseProduct() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var formData = new FormData($("#purchaseCompanyItemsData")[0]);
                $.ajax({
                    type: "post",
                    url: "save-company-purchase-item",
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
                            // window.location.reload();
                            $('#style_no').val("");
                            $('#style_no_id').val("");
                            $('#size').val("");
                            $('#color').val("");
                            // $('#qty').val("");
                            $('#price').val("");
                            $('#discount').val("");
                            $('#taxable').val("");
                            $('#total_igst').val("");
                            $('#total_sgst').val("");
                            $('#total_cgst').val("");
                            $('#total_amount').val("");
                            $('#barcode').val("");
                            // purchaseReturnShowData();
                        }     
                    }
                });
            }

        });
    </script>
@endsection