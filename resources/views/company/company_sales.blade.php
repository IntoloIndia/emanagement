@extends('layouts.app')
@section('page_title', 'Company Sales')

@section('content')
    <div class="row">
        <form id="companySalesForm">
            @csrf
            <div class="company_sales_err"></div>
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <b>Suppliers Details</b>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <select id="company_supplier_id" name="company_supplier_id"
                                        class="form-select form-select-sm">
                                        <option selected disabled value="0">Supplier</option>
                                        @foreach ($companySuppliers as $list)
                                            <option value="{{ $list->id }}" state-type="{{ $list->state_type }}">
                                                {{ ucwords($list->supplier_name) }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12 mt-2">
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
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <b>Billing-- 017791071723</b>
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
                                                    <th scope="col">Style no</th>
                                                    <th scope="col">Product</th>
                                                    <th scope="col">Qty</th>
                                                    <th scope="col">Size</th>
                                                    <th scope="col">Price</th>
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
                                    <input type="text" name="" class="form-control form-control-sm"
                                        id="item_total_amount" value="0" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 text-end">
                                    <b>Discount :</b>
                                </div>
                                <div class="col-md-2 justify-content-end">
                                    <input type="text" name="" id="total_discount"
                                        class="form-control form-control-sm" value="0" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 text-end">
                                    <b>SGST :</b>
                                </div>
                                <div class="col-md-2 justify-content-end">
                                    <input type="text" name="" id="total_sgst"
                                        class="form-control form-control-sm " value="0" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 text-end">
                                    <b>CGST :</b>
                                </div>
                                <div class="col-md-2 justify-content-end">
                                    <input type="text" name="" id="total_cgst"
                                        class="form-control form-control-sm " value="0" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-10 text-end">
                                    <b>IGST :</b>
                                </div>
                                <div class="col-md-2 justify-content-end">
                                    <input type="text" name="" id="total_igst"
                                        class="form-control form-control-sm " value="0" readonly>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-md-10 text-end">
                                    <b>Points :</b>
                                </div>
                                <div class="col-md-2 justify-content-end">
                                    <input type="text" name="redeem_points" id="redeem_points"
                                        class="form-control form-control-sm" value="0">
                                </div>
                            </div> --}}

                            {{-- <div class="row">
                                <div class="col-md-10 text-end">
                                    <b>Credit Note Amount :</b>
                                </div>
                                <div class="col-md-2 justify-content-end">
                                  
                                    <input type="text" name="credit_note_amount" id="credit_note_amount"
                                        class="form-control form-control-sm " value="0" readonly>
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="col-md-10 text-end">
                                    <b>Gross Amount :</b>
                                </div>
                                <div class="col-md-2 justify-content-end">
                                    {{-- <input type="text" name="" id="item_total_amount" class="form-control form-control-sm " value="0" readonly> --}}
                                    <input type="text" name="" id="gross_amount"
                                        class="form-control form-control-sm " value="0" readonly>
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
                                    <input type="text" name="" id="given_amount"
                                        class="form-control form-control-sm">
                                    <input type="text" name="" id="return_amount"
                                        class="form-control form-control-sm mt-1" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div class="col-md-4"></div>
                            <div class="col-md-4"></div>
                            <div class="col-md-3 d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="button" id="saveOrderBtn" class="btn btn-primary btn-sm">Save</button>
                                <button type="button" id="updateOrderBtn"
                                    class="btn btn-primary btn-sm hide">Update</button>
                                <button type="button" class="btn btn-secondary btn-sm"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
                <td style="width: 250px;">
                    <input type="text" name="product_code[]" class="form-control form-control-sm product_code">
                </td>

                <td style="width: 120px;">
                    <input type="text" name="style_no[]" class="form-control form-control-sm style_no" readonly>
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
                <td style="width: 100px;">
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
                addItem();
            });

            $(document).on('click', '#saveOrderBtn', function(e) {
                e.preventDefault();
                validateForm();
                saveCompanySales();
            });

            $(document).on("keypress", ".qty, #given_amount", function(e) {
                if (!(e.which >= 48 && e.which <= 57)) {
                    if (!((e.which == 0) || (e.which == 8)))
                        e.preventDefault();
                }
            });

            $(document).on("click", ".delete_item", function() {
                if ($("#item_list tr").length == 1) {
                    alert("Order must have at least 1 item.");
                    return false;
                }
                $(this).parent().parent().remove();
                calculateTotalAmount();
                calculateCreditnoteReturnTotalAmount();
            });

            $(document).on('change', '.product_code', function() {
                var object = $(this);
                getProductDetail(object);
            });

            // $(document).on('keyup', '#mobile_no', function() {
            //     const mobile_no = $(this).val();
            //     if (mobile_no.length == 10) {
            //         getCustomerData(mobile_no)
            //     }
            // });

            $(document).on('keyup', '.discount', function() {
                var object = $(this);
                calculateAmount(object);
            });

            $(document).on('keyup', '.qty', function() {
                var object = $(this);
                calculateAmount(object);
            });

            $(document).on('keyup', '.price', function() {
                var object = $(this);
                calculateAmount(object);
            });

            $(document).on('keyup', '#given_amount', function() {
                returnAmount();
            });

            $(document).on('click', '.orderInvoiceBtn', function(e) {
                e.preventDefault();
                const bill_id = $(this).val();
                generateInvoice(bill_id);
            });

            $(document).on('click', '#printBtn', function() {
                e.preventDefault();
                printInvoice();
            });

            $(document).on('click', '#reload_invoice_print', function() {
                window.location.reload();
            });

            $(document).on('keyup', '#redeem_points', function(e) {
                e.preventDefault();
                calculateTotalAmount();
            });

            $(document).on('click', '.credit_note', function() {
                var credit_note_id = $(this).val();
                calculateCreditnoteReturnTotalAmount();
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

            function saveCompanySales() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var formData = new FormData($("#companySalesForm")[0]);
                $.ajax({
                    type: "post",
                    url: "save-company-sales",
                    data: formData,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === 400) {
                            $('#company_sales_err').html('');
                            $('#company_sales_err').addClass('alert alert-danger');
                            var count = 1;
                            $.each(response.errors, function(key, err_value) {
                                $('#company_sales_err').append('<span>' + count++ + '. ' +
                                    err_value +
                                    '</span></br>');
                            });

                        } else {
                            if (response.status === 200) {
                                generateInvoice(response.bill_id);
                            }
                            // $('#company_sales_err').html('');
                            // window.location.reload();
                        }
                    }
                });
            }

            function calculateCreditnoteReturnTotalAmount() {
                var gross_amount = $('#gross_amount').val();
                var total_amount = $('#item_total_amount').val();
                var total_Return = 0;
                var total_note_amount = 0;

                $('.credit_note:checked').each(function() {
                    var note_amount = parseFloat($(this).attr('credit-note-amount'));
                    total_note_amount = total_note_amount + note_amount;
                });

                total_Return = parseFloat(total_amount - parseFloat(total_note_amount));
                // $("#gross_amount").val(total_Return.toFixed(2));
                // $("#total_amount").val(total_Return.toFixed(2));
                // $("#credit_note_amount").val(total_note_amount.toFixed(2));


                if (total_note_amount > total_amount) {
                    $("#gross_amount").val(Math.abs(total_Return).toFixed(2));
                    $("#total_amount").val(Math.abs(total_Return).toFixed(2));
                    $("#credit_note_amount").val(total_note_amount.toFixed(2));

                } else if (total_note_amount == total_amount) {
                    $("#gross_amount").val("0.00");
                    $("#total_amount").val('0.00');
                    $("#credit_note_amount").val('0.00');
                } else {
                    $("#gross_amount").val(total_Return.toFixed(2));
                    $("#total_amount").val(total_Return.toFixed(2));
                    $("#credit_note_amount").val(total_note_amount.toFixed(2));
                }
                // $("#credit_note_amount").val(total_note_amount.toFixed(2));


            }

            function addItem() {
                $('#item_list').append($('#item_row').html());
                $(".product_code").focus();
                // $("#item_list tr").find(".item").chosen();
            }

            function getProductDetail(object) {
                const product_code = $(object).val();
                $.ajax({
                    type: "get",
                    url: "get-product-detail/" + product_code,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 200) {
                            console.log(response)
                            $(object).parent().parent().find(".product_code").val(response
                                .product_detail.barcode);
                            $(object).parent().parent().find(".style_no").val(response
                                .product_detail.style_no_id);
                            $(object).parent().parent().find(".price").val(response.product_detail
                                .price);
                            $(object).parent().parent().find(".product").val(response.product_detail
                                .product);
                            $(object).parent().parent().find(".product_id").val(response.product_detail
                                .product_id);
                            $(object).parent().parent().find(".size").val(response.product_detail.size);
                            addItem();
                        } else {
                            $(object).parent().parent().find(".qty").val('');
                            $(object).parent().parent().find(".price").val('');
                            $(object).parent().parent().find(".product").val('');
                            $(object).parent().parent().find(".product_id").val('');
                            $(object).parent().parent().find(".size").val('');
                        }
                        calculateAmount(object);
                        // $('.barcode').val("")
                    }
                });
            }

            function calculateAmount(object) {

                var price = parseFloat($(object).parent().parent().find(".price").val());
                var qty = parseFloat($(object).parent().parent().find(".qty").val());

                var discount = parseFloat($(object).parent().parent().find(".discount").val());

                if (qty == "" || isNaN(qty)) {
                    qty = 0;
                }

                if (discount == "" || isNaN(discount)) {
                    discount = 0;
                }
                var amount = parseFloat(price * qty);

                var taxable = 0;
                var discount_amount = 0;
                taxable = calculateTaxable(discount, amount);

                discount_amount = (amount - taxable);
                var gst = calculateGst(taxable)

                $(object).parent().parent().find(".discount_amount").val(discount_amount.toFixed(2));
                $(object).parent().parent().find(".sgst").val(gst.sgst);
                $(object).parent().parent().find(".cgst").val(gst.cgst);
                $(object).parent().parent().find(".igst").val(gst.igst);
                $(object).parent().parent().find(".amount").val(taxable);
                $(object).parent().parent().find(".taxable").val(gst.base_amount);

                calculateTotalAmount();
                calculateCreditnoteReturnTotalAmount();
            }

            function calculateTaxable(discount, amount) {
                var taxable = 0;
                if (discount > 0) {
                    var discount_amount = amount * discount / 100;
                    taxable = (amount - discount_amount);
                } else {
                    taxable = amount;
                }

                return parseFloat(taxable.toFixed(2));
            }

            function calculateGst(taxable) {
                // var state_type = $('input[name=state_type]:checked', '.state_type').val();
                var state_type = 1;
                var sgst = 0;
                var cgst = 0;
                var igst = 0;

                if (taxable < 1000) {
                    base_amount = parseFloat(taxable / 1.05);
                } else {
                    base_amount = parseFloat(taxable / 1.12);
                }

                if (state_type == 1) {
                    if (base_amount < 1000) {
                        sgst = parseFloat(base_amount * 2.5 / 100);
                        cgst = parseFloat(base_amount * 2.5 / 100);
                    } else {
                        sgst = parseFloat(base_amount * 6 / 100);
                        cgst = parseFloat(base_amount * 6 / 100);
                    }
                } else {
                    if (base_amount < 1000) {
                        igst = parseFloat(base_amount * 5 / 100);
                    } else {
                        igst = parseFloat(base_amount * 12 / 100);
                    }
                }

                data = {
                    "sgst": sgst.toFixed(2),
                    "cgst": cgst.toFixed(2),
                    "igst": igst.toFixed(2),
                    "base_amount": base_amount.toFixed(2),
                }

                return (data);
            }

            function calculateTotalAmount() {
                var item_total_amount = 0;
                var gross_amount = 0;

                $(".amount").each(function() {
                    var total_amount = parseFloat($(this).val());
                    if (!isNaN(total_amount)) {
                        item_total_amount += total_amount;
                    }
                });
                $("#item_total_amount").val(item_total_amount.toFixed(2));


                // returnAmount();

                calculateTotalDiscount();
                calculateTotalGst();

                var redeem_points = redeemPoint();
                if (redeem_points > 0) {
                    gross_amount = (item_total_amount - redeem_points);
                } else {
                    gross_amount = item_total_amount;
                }
                // new
                $("#gross_amount").val(gross_amount.toFixed(2));
                $("#total_amount").val(gross_amount.toFixed(2));
                // $("#credit_payment").val(gross_amount.toFixed(2));

            }

            function calculateTotalDiscount() {
                var total_discount = 0;

                $(".discount_amount").each(function() {
                    discount_amount = parseFloat($(this).val());
                    if (!isNaN(discount_amount)) {
                        total_discount += discount_amount;
                    }
                });

                $("#total_discount").val(total_discount.toFixed(2));
            }

            function calculateTotalGst() {
                var total_sgst = 0;
                var total_cgst = 0;
                var total_igst = 0;

                $(".sgst").each(function() {
                    sgst = parseFloat($(this).val());
                    if (!isNaN(sgst)) {
                        total_sgst += sgst;
                    }
                });

                $(".cgst").each(function() {
                    cgst = parseFloat($(this).val());
                    if (!isNaN(cgst)) {
                        total_cgst += cgst;
                    }
                });

                $(".igst").each(function() {
                    igst = parseFloat($(this).val());
                    if (!isNaN(igst)) {
                        total_igst += igst;
                    }
                });

                $("#total_sgst").val(total_sgst.toFixed(2));
                $("#total_cgst").val(total_cgst.toFixed(2));
                $("#total_igst").val(total_igst.toFixed(2));
            }

            function redeemPoint() {
                var total_points = parseFloat($('#total_points').val());
                var redeem_points = parseFloat($('#redeem_points').val());

                if (total_points == "" || isNaN(total_points)) {
                    total_points = 0;
                }
                if (redeem_points == "" || isNaN(redeem_points)) {
                    redeem_points = 0;
                }
                if (redeem_points > total_points) {
                    $('#redeem_points').val('0');
                    alert('Your total points ' + total_points + ' and redeem points ' + redeem_points +
                        ' not allowed.');
                    return false;
                }
                return redeem_points;
            }

            function returnAmount() {
                const given_amount = parseFloat($('#given_amount').val());
                const total_amount = parseFloat($("#total_amount").val());
                const return_amount = parseFloat(given_amount - total_amount);
                $("#return_amount").val(return_amount);
            }

            function validateForm() {
                var msg = "";

                if ($("#item_list tr").length == 0) {
                    msg = "Please add at least 1 item";
                    validateModal(msg);
                    return false;
                }

                $(".item").each(function() {
                    msg = "Please select item";
                    validateModal(msg);
                    return false;
                });
            }

            function printInvoice() {
                var backup = document.body.innerHTML;
                var div_content = document.getElementById("invoiceModalPrint").innerHTML;
                document.body.innerHTML = div_content;
                window.print();
                document.body.innerHTML = backup;
                window.location.reload();
            }

        });
    </script>
    <script>
        function myFun(params) {
            var backup = document.body.innerHTML;
            var divcon = document.getElementById(params).innerHTML;
            document.body.innerHTML = divcon;
            window.print();
            document.body.innerHTML = backup;
        }
    </script>
@endsection
