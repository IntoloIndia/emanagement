//Purchase 

    function calculateQtyPrice() { 

        var total_qty = 0;
        var total_price = 0;

        var xs_qty = parseFloat($('#xs_qty').val());
        var xs_price = parseFloat($('#xs_price').val());

        var s_qty = parseFloat($('#s_qty').val());
        var s_price = parseFloat($('#s_price').val());

        var m_qty = parseFloat($('#m_qty').val());
        var m_price = parseFloat($('#m_price').val());

        var l_qty = parseFloat($('#l_qty').val());
        var l_price = parseFloat($('#l_price').val());

        var xl_qty = parseFloat($('#xl_qty').val());
        var xl_price = parseFloat($('#xl_price').val());

        var xxl_qty = parseFloat($('#xxl_qty').val());
        var xxl_price = parseFloat($('#xxl_price').val());

        var three_xl_qty = parseFloat($('#three_xl_qty').val());
        var three_xl_price = parseFloat($('#three_xl_price').val());

        var four_xl_qty = parseFloat($('#four_xl_qty').val());
        var four_xl_price = parseFloat($('#four_xl_price').val());

        var five_xl_qty = parseFloat($('#five_xl_qty').val());
        var five_xl_price = parseFloat($('#five_xl_price').val());

        if(xs_qty == "" || isNaN(xs_qty))
        {xs_qty = 0;}
        if(s_qty == "" || isNaN(s_qty))
        {s_qty = 0;}
        if(m_qty == "" || isNaN(m_qty))
        {m_qty = 0;}
        if(l_qty == "" || isNaN(l_qty))
        {l_qty = 0;}
        if(xl_qty == "" || isNaN(xl_qty))
        {xl_qty = 0;}
        if(xxl_qty == "" || isNaN(xxl_qty))
        {xxl_qty = 0;}
        if(three_xl_qty == "" || isNaN(three_xl_qty))
        {three_xl_qty = 0;}
        if(four_xl_qty == "" || isNaN(four_xl_qty))
        {four_xl_qty = 0;}
        if(five_xl_qty == "" || isNaN(five_xl_qty))
        {five_xl_qty = 0;}

        if(xs_price == "" || isNaN(xs_price))
        {xs_price = 0;}
        if(s_price == "" || isNaN(s_price))
        {s_price = 0;}
        if(m_price == "" || isNaN(m_price))
        {m_price = 0;}
        if(l_price == "" || isNaN(l_price))
        {l_price = 0;}
        if(xl_price == "" || isNaN(xl_price))
        {xl_price = 0;}
        if(xxl_price == "" || isNaN(xxl_price))
        {xxl_price = 0;}
        if(three_xl_price == "" || isNaN(three_xl_price))
        {three_xl_price = 0;}
        if(four_xl_price == "" || isNaN(four_xl_price))
        {four_xl_price = 0;}
        if(five_xl_price == "" || isNaN(five_xl_price))
        {five_xl_price = 0;}

        total_qty = xs_qty + s_qty + m_qty + l_qty + xl_qty + xxl_qty + three_xl_qty + four_xl_qty + five_xl_qty;
        $('#total_qty').val(total_qty);

        total_price = parseFloat(xs_qty * xs_price) + parseFloat(s_qty * s_price) + parseFloat(m_qty * m_price) + parseFloat(l_qty * l_price) + parseFloat(xl_qty * xl_price) + parseFloat(xxl_qty * xxl_price) + parseFloat(three_xl_qty * three_xl_price) + parseFloat(four_xl_qty * four_xl_price) + parseFloat(five_xl_qty * five_xl_price);
        $('#total_price').val(total_price);

        var total_amount = 0;
        var total_taxable = 0;
        var xs_taxable = 0;
        var s_taxable = 0;
        var m_taxable = 0;
        var l_taxable = 0;
        var xl_taxable = 0;
        var xxl_taxable = 0;
        var three_xl_taxable = 0;
        var four_xl_taxable = 0;
        var five_xl_taxable = 0;

        var total_sgst = 0;
        var total_cgst = 0;
        var total_igst = 0;

        var xs_sgst = 0;
        var xs_cgst = 0;
        var xs_igst = 0;

        var s_sgst = 0;
        var s_cgst = 0;
        var s_igst = 0;

        var m_sgst = 0;
        var m_cgst = 0;
        var m_igst = 0;

        var l_sgst = 0;
        var l_cgst = 0;
        var l_igst = 0;

        var xl_sgst = 0;
        var xl_cgst = 0;
        var xl_igst = 0;

        var xxl_sgst = 0;
        var xxl_cgst = 0;
        var xxl_igst = 0;

        var three_xl_sgst = 0;
        var three_xl_cgst = 0;
        var three_xl_igst = 0;

        var four_xl_sgst = 0;
        var four_xl_cgst = 0;
        var four_xl_igst = 0;

        var five_xl_sgst = 0;
        var five_xl_cgst = 0;
        var five_xl_igst = 0;

        if (xs_qty > 0) {
            var xs_taxable = calculateTaxable(xs_qty, xs_price);
            if (xs_taxable > 0) {
                var xs_gst = calculateGst(xs_taxable);
                xs_sgst = xs_gst.sgst;
                xs_cgst = xs_gst.cgst;
                xs_igst = xs_gst.igst;
            }
           
        }
        if (s_qty > 0) {
            var s_taxable = calculateTaxable(s_qty, s_price);
            if (s_taxable > 0) {
                var s_gst = calculateGst(s_taxable);
                s_sgst = s_gst.sgst;
                s_cgst = s_gst.cgst;
                s_igst = s_gst.igst;
            }
        }
        if (m_qty > 0) {
            var m_taxable = calculateTaxable(m_qty, m_price);
            if (m_taxable > 0) {
                var m_gst = calculateGst(m_taxable);
                m_sgst = m_gst.sgst;
                m_cgst = m_gst.cgst;
                m_igst = m_gst.igst;
            }
        }
        if (l_qty > 0) {
            var l_taxable = calculateTaxable(l_qty, l_price);
            if (l_taxable > 0) {
                var l_gst = calculateGst(l_taxable);
                l_sgst = l_gst.sgst;
                l_cgst = l_gst.cgst;
                l_igst = l_gst.igst;
            }
        }
        if (xl_qty > 0) {
            var xl_taxable = calculateTaxable(xl_qty, xl_price);
            if (xl_taxable > 0) {
                var xl_gst = calculateGst(xl_taxable);
                xl_sgst = xl_gst.sgst;
                xl_cgst = xl_gst.cgst;
                xl_igst = xl_gst.igst;
            }
        }
        if (xxl_qty > 0) {
            var xxl_taxable = calculateTaxable(xxl_qty, xxl_price);
            if (xxl_taxable > 0) {
                var xxl_gst = calculateGst(xxl_taxable);
                xxl_sgst = xxl_gst.sgst;
                xxl_cgst = xxl_gst.cgst;
                xxl_igst = xxl_gst.igst;
            }
        }

        if (three_xl_qty > 0) {
            var three_xl_taxable = calculateTaxable(three_xl_qty, three_xl_price);
            if (three_xl_taxable > 0) {
                var three_xl_gst = calculateGst(three_xl_taxable);
                three_xl_sgst = three_xl_gst.sgst;
                three_xl_cgst = three_xl_gst.cgst;
                three_xl_igst = three_xl_gst.igst;
            }
        }

        if (four_xl_qty > 0) {
            var four_xl_taxable = calculateTaxable(four_xl_qty, four_xl_price);
            if (four_xl_taxable > 0) {
                var four_xl_gst = calculateGst(four_xl_taxable);
                four_xl_sgst = four_xl_gst.sgst;
                four_xl_cgst = four_xl_gst.cgst;
                four_xl_igst = four_xl_gst.igst;
            }
        }

        if (five_xl_qty > 0) {
            var five_xl_taxable = calculateTaxable(five_xl_qty, five_xl_price);
            if (five_xl_taxable > 0) {
                var five_xl_gst = calculateGst(five_xl_taxable);
                five_xl_sgst = five_xl_gst.sgst;
                five_xl_cgst = five_xl_gst.cgst;
                five_xl_igst = five_xl_gst.igst;
            }
        }

        total_taxable = xs_taxable + s_taxable + m_taxable + l_taxable + xl_taxable + xxl_taxable + three_xl_taxable + four_xl_taxable + five_xl_taxable;
        $('#taxable').val(total_taxable.toFixed(2));

        total_sgst = parseFloat(xs_sgst) + parseFloat(s_sgst) + parseFloat(m_sgst) + parseFloat(l_sgst) + parseFloat(xl_sgst) + parseFloat(xxl_sgst) + parseFloat(three_xl_sgst) + parseFloat(four_xl_sgst) + parseFloat(five_xl_sgst);
        total_cgst = parseFloat(xs_cgst) + parseFloat(s_cgst) + parseFloat(m_cgst) + parseFloat(l_cgst) + parseFloat(xl_cgst) + parseFloat(xxl_cgst) + parseFloat(three_xl_cgst) + parseFloat(four_xl_cgst) + parseFloat(five_xl_cgst);
        total_igst = parseFloat(xs_igst) + parseFloat(s_igst) + parseFloat(m_igst) + parseFloat(l_igst) + parseFloat(xl_igst) + parseFloat(xxl_igst) + parseFloat(three_xl_igst) + parseFloat(four_xl_igst) + parseFloat(five_xl_igst);

        
        $('#total_sgst').val(total_sgst.toFixed(2));
        $('#total_cgst').val(total_cgst.toFixed(2));
        $('#total_igst').val(total_igst.toFixed(2));

        total_amount = parseFloat(total_taxable + (total_sgst + total_cgst + total_igst));
        $('#total_amount').val(total_amount.toFixed(2));

        // calculateGst(parseFloat(total_price))
    }

    function calculateTaxable(qty, price) {

        var discount = parseFloat($('#discount').val());
        // var value = parseFloat($('#total_price').val());

        var taxable = 0;
        if (discount > 0) {
            var discount_amount = price * discount / 100 ;
            taxable = (price - discount_amount) * qty  ;
        }else{
            taxable = price * qty;
        }

        return parseFloat(taxable.toFixed(2));
    }

    function calculateGst(price) {

        var state_type = $('#supplier_id').find("option:selected").attr('state-type');
        var sgst = 0;
        var cgst = 0;
        var igst = 0;
        
        if (state_type == 1) {
            if (price < 1000) {
                sgst = parseFloat(price * 2.5 / 100);
                cgst = parseFloat(price * 2.5 / 100);
            }else{
                sgst = parseFloat(price * 6 / 100) ;
                cgst = parseFloat(price * 6 / 100) ;
            }
        }else{
            if (price < 1000) {
                igst = parseFloat(price * 5 / 100) ;
            }else{
                igst = parseFloat(price * 12 / 100) ;
            }
        }

        data = {
            "sgst":sgst,
            "cgst":cgst,
            "igst":igst,
        }

        return(data);

    }

    // function calculateGst(taxable) {
    //     var state_type = $('#supplier_id').find("option:selected").attr('state-type');
    //     var sgst = 0;
    //     var cgst = 0;
    //     var igst = 0;

    //     if (state_type == '{{MyApp::WITH_IN_STATE}}') {
    //         if (total_price < '{{MyApp::THOUSAND}}') {
    //             sgst = parseFloat(total_price * 2.5 / 100);
    //             cgst = parseFloat(total_price * 2.5 / 100);
    //         }else{
    //             sgst = parseFloat(total_price * 6 / 100) ;
    //             cgst = parseFloat(total_price * 6 / 100) ;
    //         }
    //     }else{
    //         if (total_price < '{{MyApp::THOUSAND}}') {
    //             igst = parseFloat(total_price * 5 / 100) ;
    //         }else{
    //             igst = parseFloat(total_price * 12 / 100) ;
    //         }
    //     }
    //     console.log(state_type);
        

    //     // $('#total_sgst').val(sgst.toFixed(2));
    //     // $('#total_cgst').val(cgst.toFixed(2));
    //     // $('#total_igst').val(igst.toFixed(2));

    // }


    // function calculateGst(object, price) {
    //     var state_type = $('#supplier_id').find("option:selected").attr('state-type');
        
    //     var price = price;
    //     var purchase_amount = 0;
    //     var sgst = 0;
    //     var cgst = 0;
    //     var igst = 0;


    //     if (price < '{{MyApp::THOUSAND}}') {
    //         purchase_amount = parseFloat(price / 1.05);
    //     }else{
    //         purchase_amount = parseFloat(price / 1.12);
    //     }

    //     if (state_type == '{{MyApp::WITH_IN_STATE}}') {
    //         if (price < '{{MyApp::THOUSAND}}') {
    //             sgst = parseFloat(purchase_amount * 2.5 / 100);
    //             cgst = parseFloat(purchase_amount * 2.5 / 100);
    //         }else{
    //             sgst = parseFloat(purchase_amount * 6 / 100) ;
    //             cgst = parseFloat(purchase_amount * 6 / 100) ;
    //         }
    //     }else{
    //         if (price < '{{MyApp::THOUSAND}}') {
    //             igst = parseFloat(purchase_amount * 5 / 100) ;
    //         }else{
    //             igst = parseFloat(purchase_amount * 12 / 100) ;
    //         }
    //     }

    //     $(object).parent().parent().parent().parent().parent().find('.mypopover-content').find('.sgst').val(sgst.toFixed(2));
    //     $(object).parent().parent().parent().parent().parent().find('.mypopover-content').find('.cgst').val(cgst.toFixed(2));
    //     $(object).parent().parent().parent().parent().parent().find('.mypopover-content').find('.igst').val(igst.toFixed(2));

    // }

    function addItem() {
        // $(".product_code").focus();
        $('#item_list').append($('#item_row').html());
        $("#item_list ").find(".item").chosen();

        $('.item_list > .row').each(function(index){
            console.log(index);
        });
        
    }

    function takePhoto() {
        Webcam.snap( function(data_uri) {
            document.getElementById('take_photo').innerHTML = 
            '<img class="card-img-top img-thumbnail after_capture_frame" src="'+data_uri+'"/>';
            $("#product_image").val(data_uri);
        });	 
        $('#captureLivePhotoModal').modal('hide');
    }

    function supplierDetail(supplier_id) {
        $.ajax({
            type: "get",
            url: "supplier-detail/"+supplier_id,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if (response.status == 200) {
                   $('#gst_no').val(response.supplier.gst_no) ;
                   $('#supplier_code').val(response.supplier.supplier_code) ;
                   $('#supplier_address').val(response.supplier.address) ;
                   $('#payment_days').val(response.supplier.payment_days) ;
                //    $('#state_type').val(response.supplier.state_type) ;

                   supplierStyleNo(response.supplier.id);
                }
            }
        });
    }

    function supplierStyleNo(supplier_id){
        $.ajax({
            type: "get",
            url: "supplier-style-no/"+supplier_id,
            dataType: "json",
            success: function (response) {
                $('#style_no_id').empty();
                if (response.status == 200) {
                    $('#style_no_id').append(response.html) ;
                    $("#style_no_id").trigger("chosen:updated");
                }
            }
        });
    }

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;

    }

    function getBarcode() {
        $.ajax({
            type: "get",
            url: "barcode",
            dataType: "json",
            success: function (response) {
                //console.log(response);
                if (response.status == 200) {
                    $('#generateBarcodeModal').html(response.html);
                    $('#generateBarcodeModal').modal('show');
                }
            }
        });
    }

    function getPurchaseEntry(supplier_id, bill_no){
        
        $.ajax({
            type: "get",
            url: "get-purchase-entry/"+supplier_id+'/'+bill_no,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if (response.status == 200) {
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#show_purchase_entry').html('');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#show_purchase_entry').append(response.html);
                }
            }
        });
    }

    function validateForm() {

        var msg = "";
        // if($("#invoice_no").val() == "")
        // {
        //     msg = "Please enter customer name";
        //     validateModal(msg);
        //     return false;
        // }

        // if($("#item_list tr").length == 0)
        if($("#supplier_id").val() == null)
        {
            msg = "Please select supplier.";
            alert(msg);
            return false;
        }

        if($("#bill_date").val() == "")
        {
            msg = "Please select bill date.";
            alert(msg);
            return false;
        }

        if($("#bill_no").val() == "")
        {
            msg = "Please enter bill no.";
            alert(msg);
            return false;
        }

        if($("#category_id").val() == null)
        {
            msg = "Please select category.";
            alert(msg);
            return false;
        }
        if($("#sub_category_id").val() == null)
        {
            msg = "Please select sub category.";
            alert(msg);
            return false;
        }
        if($("#brand_id").val() == null)
        {
            msg = "Please select brand.";
            alert(msg);
            return false;
        }
        if($("#style_no_id").val() == null)
        {
            msg = "Please select style no.";
            alert(msg);
            return false;
        }
        if($("#color").val() == null)
        {
            msg = "Please select color.";
            alert(msg);
            return false;
        }

        savePurchaseEntry()
    }

    function generatePurchaseInvoice(purchase_id) {

        $.ajax({
            type: "get",
            url: "generate-purchase-invoice/"+purchase_id,
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response.status == 200) {
                    $('#generatePurchaseInvoiceModal').modal('show');
                    $('#generatePurchaseInvoiceModal').find('#show_purchase_invoice').html('');
                    $('#generatePurchaseInvoiceModal').find('#show_purchase_invoice').append(response.html);
                }
            }
        });

    }

    function savePurchaseEntry() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData = new FormData($("#purchaseEntryForm")[0]);
        $.ajax({
            type: "post",
            url: "save-purchase-entry",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                // console.log(response);

                if (response.status === 400) {
                    $('#purchase_entry_err').html('');
                    $('#purchase_entry_err').addClass('alert alert-danger');
                    var count = 1;
                    $.each(response.errors, function (key, err_value) {
                        $('#purchase_entry_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                    });

                } else {
                    $('#purchase_entry_err').html('');
                    // $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find("option:selected").val();
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find("#color").val('').trigger('chosen:updated');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find("#product_image").val('');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find(".qty").val('');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find(".price").val('');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find(".mrp").val('');
                    // $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find('#take_photo').find(".after_capture_frame").removeAttr('src');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find(".after_capture_frame").addClass('hide');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find("#total_qty").val('');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find("#total_price").val('');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find("#discount").val('0');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#show_purchase_entry').html('');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#show_purchase_entry').append(response.html);
                    
                    setTimeout(() => {
                        
                        calculateQtyPrice();
                    }, 200);

                    // window.location.reload();
                }
            }
        });
    }

    function viewPurchaseEntry(purchase_id) {

        $.ajax({
            type: "get",
            url: "view-purchase-entry/"+purchase_id,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if (response.status == 200) {
                    $('#view_purchase_entry').html('');
                    $('#view_purchase_entry').append(response.html);
                }
            }
        });

    }
    
    function editPurchaseEntry(purchase_entry_id){
        $.ajax({
            type: "get",
            url: "edit-purchase-entry/"+purchase_entry_id,
            dataType: "json",
            success: function (response) {
                console.log(response);

                if(response.status == 200){

                    $('#purchaseEntryModal').modal('show');
                    $('#product_err').html('');
                    $('#product_err').removeClass('alert alert-danger');
                    $("#purchaseEntryForm").trigger( "reset" ); 
                    $('#savePurchaseEntryBtn').addClass('hide');
                    $('#updatePurchaseEntryBtn').removeClass('hide');

                    // $('#supplier_id').trigger("chosen:updated");

                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#supplier_id').html('');
                    $("#supplier_id").append('<option value="'+response.purchase.supplier_id+'" state-type="'+response.purchase.state_type+'"> '+response.purchase.supplier_name+' </option>');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#supplier_code').val(response.purchase.supplier_code);
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#gst_no').val(response.purchase.gst_no);
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#supplier_address').val(response.purchase.address);
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#payment_days').val(response.purchase.payment_days);
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#bill_date').val(response.purchase.bill_date);
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#bill_no').val(response.purchase.bill_no);
                    
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#category_id').val(response.purchase_entry.category_id).trigger('chosen:updated');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#sub_category_id').html(response.sub_category_html).trigger('chosen:updated');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#brand_id').val(response.purchase_entry.brand_id).trigger('chosen:updated');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#style_no_id').html(response.style_no_html).trigger('chosen:updated');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find('#color').val(response.purchase_entry.color).trigger('chosen:updated');
                    
                    
                    // $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find('#take_photo').find(".after_capture_frame").removeAttr('src');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find(".after_capture_frame").addClass('hide');
                    if (response.purchase_entry.img) {
                        
                        $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find('#take_photo').append('<img class="card-img-top img-thumbnail after_capture_frame" src="'+response.purchase_entry.img+'"/>');
                    }
                    var discount = 0;
                    $.each(response.purchase_entry_items, function (key, list) {
                        var size = "";
                        if (list.size == '3xl') {
                            size = 'three_xl';
                        }else if(list.size == '4xl'){
                            size = 'four_xl';
                        }else if(list.size == '5xl'){
                            size = 'five_xl';
                        }else{
                            size = list.size;
                        }

                        $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find('#'+size+'_qty').val(list.qty);
                        $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find('#'+size+'_price').val(list.price);
                        $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find('#'+size+'_mrp').val(list.mrp);
                        discount = list.discount;
                    });
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#discount').val(discount);
                    // alert(discount);
                    
                    calculateQtyPrice();
                    
                    // $('#purchaseEntryModal').find('#purchaseEntryForm').find('#supplier_id').val(response.purchase.supplier_id);
                    // $('#purchaseEntryModal').find('#purchaseEntryForm').find('#supplier_id').remove();
                    
                    // $("#supplier_div").append('<input type="hidden" name="supplier_id" value="">\
                    // <input type="text" value="'+response.purchase.supplier_id+'" class="form-control form-control-sm" readonly disabled>');
                    
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#purchase_id').val(response.purchase.id);
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#purchase_entry_id').val(response.purchase_entry.id);

                    // $('#updatePurchaseEntryBtn').val(response.purchase.id);
                }
            }
        });
    }

    function updatePurchaseEntry(purchase_id, purchase_entry_id){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData = new FormData($("#purchaseEntryForm")[0]);
        $.ajax({
            type: "post",
            url: "update-purchase-entry/"+purchase_id+"/"+purchase_entry_id,
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false, 
            processData: false, 
            success: function (response) {
                console.log(response);
                if(response.status === 400)
                {
                    $('#purchase_entry_err').html('');
                    $('#purchase_entry_err').addClass('alert alert-danger');
                    var count = 1;
                    $.each(response.errors, function (key, err_value) { 
                        $('#purchase_entry_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                    });

                }else{
                    $('#purchase_entry_err').html('');
                    $('#purchaseEntryModal').modal('hide');
                    window.location.reload();
                        
                    // $('#view_purchase_entry').html('');
                    // $('#view_purchase_entry').append(response.html);
                }
            }
        });
    }

    function deleteProduct(product_id){
        $.ajax({
            type: "get",
            url: "delete-product/"+product_id,
            dataType: "json",
            success: function (response) {
                // console.log(response);
                if(response.status == 200){
                    window.location.reload();
                }
            }
        });
    }

    function printBarcode(){
        var backup = document.body.innerHTML;
        var div_content = document.getElementById("show_barcode_body").innerHTML;
        document.body.innerHTML = div_content;
        window.print();
        document.body.innerHTML = backup;


        // const section = $("section");
        // // const modalBody = $("#show_barcode_body").detach();
        // const modalBody = document.getElementById("barcode_body").innerHTML;

        // section.empty();
        // section.append(modalBody);
        // window.print();
        // window.location.reload();


        // var print_div = document.getElementById("show_barcode_body");
        // // var print_div = document.getElementById("barcode_body");
        // var print_area = window.open();
        // print_area.document.write(print_div.innerHTML);
        // print_area.document.close();
        // print_area.focus();
        // print_area.print();
      
        window.location.reload();
    }

// save category of purchase entry
function saveCategory() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var formData = new FormData($("#categoryForm")[0]);
    $.ajax({
        type: "post",
        url: "save-category",
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            // console.log(response);
            if (response.status === 400) {
                $('#category_err').html('');
                $('#category_err').addClass('alert alert-danger');
                var count = 1;
                $.each(response.errors, function (key, err_value) {
                    $('#category_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                });
            } else {
                $('#category_err').html('');
                $('#categoryModal').modal('hide');
                $('#category_id').html('');
                $('#category_id').append(response.category_html); 
                $("#category_id").trigger("chosen:updated");  
                // window.location.reload();
            }
        }
    });
}

// save subcategory of purchase entry
function saveSubCategory() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var formData = new FormData($("#subcategoryForm")[0]);
    $.ajax({
        type: "post",
        url: "save-sub-category",
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            if (response.status === 400) {
                $('#subcategory_err').html('');
                $('#subcategory_err').addClass('alert alert-danger');
                var count = 1;
                $.each(response.errors, function (key, err_value) {
                    $('#subcategory_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                });
            } else {
                $('#subcategory_err').html('');
                $('#subCategoryModal').modal('hide');
                $('#sub_category_id').html('');
                $('#sub_category_id').append(response.sub_category_html); 
                $("#sub_category_id").trigger("chosen:updated"); 
                // window.location.reload();
            }
        }
    });
}

function saveBrand() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var formData = new FormData($("#brandForm")[0]);
    $.ajax({
        type: "post",
        url: "save-brand",
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status === 400) {
                $('#brand_err').html('');
                $('#brand_err').addClass('alert alert-danger');
                var count = 1;
                $.each(response.errors, function (key, err_value) {
                    $('#brand_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                });

            } else {
                $('#brand_err').html('');
                $('#brandModal').modal('hide');
                $('#brand_id').html('');
                $('#brand_id').append(response.brand_html); 
                $("#brand_id").trigger("chosen:updated");
                // window.location.reload();
            }
        }
    });
}

// save style no
function manageStyleNo(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var formData = new FormData($("#styleNoForm")[0]);
    $.ajax({
        type: "post",
        url: "save-style-no",
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false, 
        processData: false, 
        success: function (response) {
            //    console.log(response);
            if(response.status === 400)
            {
                $('#style_no_err').html('');
                $('#style_no_err').addClass('alert alert-danger');
                var count = 1;
                $.each(response.errors, function (key, err_value) { 
                    $('#style_no_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                });

            }else{
                $('#style_no_err').html('');
                $('#style_no_err').removeClass('alert alert-danger');
                $('#styleNoModal').modal('hide');
                $('#style_no_id').html('');
                $('#style_no_id').append(response.style_no_html); 
                $("#style_no_id").trigger("chosen:updated");
                // window.location.reload();
            }
        }
    });
}



