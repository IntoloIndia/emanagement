@extends('layouts.app')
@section('page_title', 'Company Sales')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <b>Suppliers Details</b>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <select id="company_supplier_id" name="company_supplier_id" class="form-select form-select-sm">
                                <option selected disabled value="0">Supplier</option>
                                @foreach ($companySuppliers as $list)
                                    <option value="{{ $list->id }}" state-type="{{ $list->state_type }}">
                                        {{ ucwords($list->supplier_name) }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control form-control-sm" name="supplier_code"
                                id="supplier_code" required placeholder="Supplier code" readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <input type="text" class="form-control form-control-sm" name="gst_no" id="gst_no"
                                required placeholder="GST No." readonly>
                        </div>
                        <div class="col-md-12 mt-2">
                            <textarea class="form-control" name="supplier_address" id="supplier_address" style="height: 60px;" placeholder="Address"
                                readonly></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <b>Billing</b>
                    <button type="button" class="btn btn-primary btn-sm float-right" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop">
                        View Invoice
                    </button>
                    <button class="btn btn-primary btn-sm  float-right mr-3" id="addItemBtn"> Add item</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive" style="max-height: 400px">
                                <table class="table" id="tablebox">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sno</th>
                                            <th scope="col">Code</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Size</th>
                                            <th scope="col">MRP</th>
                                            <th scope="col">Dis.</th>
                                            <th scope="col" class="sgst_show_hide">SGST</th>
                                            <th scope="col" class="cgst_show_hide">CGST</th>
                                            <th scope="col" class="igst_show_hide hide">IGST</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody id="item_list"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10 text-end">
                            <b>Total Amount :</b>
                        </div>
                        <div class="col-md-2 justify-content-end">
                            <input type="text" name="" class="form-control form-control-sm" id="item_total_amount"
                                value="0" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 text-end">
                            <b>Discount :</b>
                        </div>
                        <div class="col-md-2 justify-content-end">
                            <input type="text" name="" id="total_discount" class="form-control form-control-sm"
                                value="0" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 text-end">
                            <b>SGST :</b>
                        </div>
                        <div class="col-md-2 justify-content-end">
                            <input type="text" name="" id="total_sgst" class="form-control form-control-sm "
                                value="0" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 text-end">
                            <b>CGST :</b>
                        </div>
                        <div class="col-md-2 justify-content-end">
                            <input type="text" name="" id="total_cgst" class="form-control form-control-sm "
                                value="0" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10 text-end">
                            <b>IGST :</b>
                        </div>
                        <div class="col-md-2 justify-content-end">
                            <input type="text" name="" id="total_igst" class="form-control form-control-sm "
                                value="0" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 text-end">
                            <b>Points :</b>
                        </div>
                        <div class="col-md-2 justify-content-end">
                            <input type="text" name="redeem_points" id="redeem_points"
                                class="form-control form-control-sm" value="0">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-10 text-end">
                            <b>Credit Note Amount :</b>
                        </div>
                        <div class="col-md-2 justify-content-end">
                            {{-- <input type="text" name="" id="item_total_amount" class="form-control form-control-sm " value="0" readonly> --}}
                            <input type="text" name="credit_note_amount" id="credit_note_amount"
                                class="form-control form-control-sm " value="0" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 text-end">
                            <b>Gross Amount :</b>
                        </div>
                        <div class="col-md-2 justify-content-end">
                            {{-- <input type="text" name="" id="item_total_amount" class="form-control form-control-sm " value="0" readonly> --}}
                            <input type="text" name="" id="gross_amount" class="form-control form-control-sm "
                                value="0" readonly>
                        </div>
                    </div>

                    <div class="row mt-1 hide" id="given_return_amount">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-2 text-end">
                            <div><b>Given Amt :</b></div>
                            <div class="mt-2"><b>Return Amt :</b></div>
                        </div>
                        <div class="col-md-2 text-center">
                            <input type="text" name="" id="given_amount" class="form-control form-control-sm">
                            <input type="text" name="" id="return_amount"
                                class="form-control form-control-sm mt-1" readonly>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-md-4"></div>
                    <div class="col-md-4"></div>
                    <div class="col-md-3 d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" id="saveOrderBtn" class="btn btn-primary btn-sm" disabled>Save
                            Order</button>
                        <button type="button" id="updateOrderBtn" class="btn btn-primary btn-sm hide">Update
                            Order</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12 table-responsive p-0" style="height: 550px;">
                                <table class="table table-head-fixed">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sno</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Bill no</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Print</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- table --}}
    <table class="hide">
        <tbody id="item_row">
            <tr>
                <td id="count_item"></td>
                <td style="width: 200px;">
                    <input type="text" name="product_code[]" class="form-control form-control-sm product_code">
                </td>

                <td style="width:150px;">
                    {{-- <select name="product_id[]"  id="product_id" class=" form-select form-select-sm product_id">
                    <option selected>Choose..</option>
                    @foreach ($products as $item)
                        <option value="{{$item->id}}">{{ucwords($item->product)}}</option>
                    @endforeach
                </select> --}}
                    <input type="text" name="product[]" class="form-control form-control-sm product" readonly>
                    <input type="hidden" name="product_id[]" class="product_id">
                </td>

                <td style="width: 80px;">
                    <input type="text" name="qty[]" value="1" class="form-control form-control-sm qty"
                        min="1" value="0">
                </td>
                <td style="width: 80px;">
                    <input type="text" name="size[]" class="form-control form-control-sm size" readonly>
                    <input type="hidden" name="size_id[]" class="size_id">
                </td>
                <td style="width: 100px;">
                    <input type="text" name="price[]" class="form-control form-control-sm price">
                </td>
                <td style="width: 50px;">
                    <input type="text" class="form-control form-control-sm discount" value="0">
                    <input type="hidden" name="discount_amount[]" class="form-control form-control-sm discount_amount"
                        style="width: 100px;">
                </td>

                <td style="width: 80px;" class="sgst_show_hide">
                    <input type="text" name="sgst[]" class="form-control form-control-sm sgst " value="0"
                        readonly>
                </td>
                <td style="width: 80px;" class="cgst_show_hide">
                    <input type="text" name="cgst[]" class="form-control form-control-sm cgst " value="0"
                        readonly>
                </td>
                <td style="width: 80px;" class="igst_show_hide hide">
                    <input type="text" name="igst[]" class="form-control form-control-sm igst " value="0"
                        readonly>
                </td>
                <td style="width: 150px;">
                    <input type="text" name="amount[]" class="form-control form-control-sm amount" readonly>
                    <input type="hidden" name="taxfree_amount[]" class="form-control form-control-sm taxable"
                        style="width: 150px;">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-flat btn-sm delete_item"><i
                            class="far fa-window-close"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            addItem();
            $(document).on('change', '#company_supplier_id', function(e) {
                e.preventDefault();
                var company_supplier_id = $('#company_supplier_id').val();
                companySupplierDetail(company_supplier_id);
            });

            $(document).on('click', '#addItemBtn', function(e) {
                e.preventDefault();
                // alert("dfkj")
                addItem();
            });

            function addItem() {
                $('#item_list').append($('#item_row').html());
                $(".product_code").focus();
                // $("#item_list tr").find(".item").chosen();
            }

            $(document).on("click", ".delete_item", function() {
                if ($("#item_list tr").length == 1) {
                    alert("Order must have at least 1 item.");
                    return false;
                }
                $(this).parent().parent().remove();
            });

            //function
            function companySupplierDetail(company_supplier_id) {
                $.ajax({
                    type: "get",
                    url: "company-supplier-detail/" + company_supplier_id,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 200) {
                            $('#gst_no').val(response.companySupplier.gst_no);
                            $('#supplier_code').val(response.companySupplier.supplier_code);
                            $('#supplier_address').val(response.companySupplier.address);
                        }
                    }
                });
            }

        });
    </script>
@endsection
