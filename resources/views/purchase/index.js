//Purchase 

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
                // console.log(response);
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
                    window.location.reload();
                    // $.each(response.brands, function (key, list) {
                    //     // $('#brand_id').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                    //     // $('#brand_id').append('<select >' + count++ + '. ' + err_value + '</select></br>');
                    //     console.log(list.id);
                    // });
                }
            }
        });
    }

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

        total_qty = xs_qty + s_qty + m_qty + l_qty + xl_qty + xxl_qty;
        $('#total_qty').val(total_qty);

        total_price = parseFloat(xs_qty * xs_price) + parseFloat(s_qty * s_price) + parseFloat(m_qty * m_price) + parseFloat(l_qty * l_price) + parseFloat(xl_qty * xl_price) + parseFloat(xxl_qty * xxl_price) ;
        $('#total_price').val(total_price);

        // calculateGst(parseFloat(total_price))
    }

    function calculateGst(total_price) {
        var state_type = $('#supplier_id').find("option:selected").attr('state-type');
        var sgst = 0;
        var cgst = 0;
        var igst = 0;

        if (state_type == '{{MyApp::WITH_IN_STATE}}') {
            if (total_price < '{{MyApp::THOUSAND}}') {
                sgst = parseFloat(total_price * 2.5 / 100);
                cgst = parseFloat(total_price * 2.5 / 100);
            }else{
                sgst = parseFloat(total_price * 6 / 100) ;
                cgst = parseFloat(total_price * 6 / 100) ;
            }
        }else{
            if (total_price < '{{MyApp::THOUSAND}}') {
                igst = parseFloat(total_price * 5 / 100) ;
            }else{
                igst = parseFloat(total_price * 12 / 100) ;
            }
        }
        console.log(state_type);
        

        // $('#total_sgst').val(sgst.toFixed(2));
        // $('#total_cgst').val(cgst.toFixed(2));
        // $('#total_igst').val(igst.toFixed(2));

    }


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
                    alert("Save purchase entry successfully");
                    // $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find("option:selected").val();
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find("#color").val('');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find("#product_image").val('');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find(".qty").val('');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find(".price").val('');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find(".mrp").val('');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find(".after_capture_frame").removeAttr('src');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find("#total_qty").val('');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find("#total_price").val('');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#show_purchase_entry').html('');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#show_purchase_entry').append(response.html);
                    // $('#productModal').modal('hide');
                    // window.location.reload();
                }
            }
        });
    }
    
    function editProduct(product_id){
        $.ajax({
            type: "get",
            url: "edit-product/"+product_id,
            dataType: "json",
            success: function (response) {
                if(response.status == 200){
                    $('#purchaseEntryModal').modal('show');
                    $('#product_err').html('');
                    $('#product_err').removeClass('alert alert-danger');
                    $("#purchaseEntryForm").trigger( "reset" ); 
                    $('#savePurchaseEntryBtn').addClass('hide');
                    $('#updatePurchaseEntryBtn').removeClass('hide');

                    $('#supplier_id').val(response.product.supplier_id);
                    $('#gst_no').val(response.product.gst_no);
                    $('#hsn_code').val(response.product.hsn_code);
                    $('#bill_no').val(response.product.bill_no);

                    $('#category_id').val(response.product.category_id);
                    $('#sub_category_id').html("");
                    $('#sub_category_id').append(response.html);
                    $('#product_name').val(response.product.product);


                    $('#qty').val(response.product.qty);//

                    $('#size').val(response.product.size);
                    $('#color').val(response.product.color);
                    $('#purchase_price').val(response.product.purchase_price);
                    $('#sales_price').val(response.product.sales_price);


                    $('#updateProductBtn').val(response.product.id);
                }
            }
        });
    }

    function updateProduct(product_id){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData = new FormData($("#purchaseEntryForm")[0]);
        $.ajax({
            type: "post",
            url: "update-product/"+product_id,
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false, 
            processData: false, 
            success: function (response) {
                if(response.status === 400)
                {
                    $('#product_err').html('');
                    $('#product_err').addClass('alert alert-danger');
                    var count = 1;
                    $.each(response.errors, function (key, err_value) { 
                        $('#product_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                    });

                }else{
                    $('#product_err').html('');
                    $('#purchaseEntryModal').modal('hide');
                    window.location.reload();
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
                window.location.reload();
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
            // console.log(response);
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
                window.location.reload();
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
               console.log(response);
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
                $('#styleNoModal').modal('hide');
                window.location.reload();
            }
        }
    });
}

