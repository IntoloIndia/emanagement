    //without size type
    function calculateQtyPriceWithout() {
        var total_qty = 0;
        var total_price = 0;

        var without_qty = parseFloat($('#without_qty').val());
        var without_price = parseFloat($('#without_price').val());

        if(without_qty == "" || isNaN(without_qty))
        {without_qty = 0;}

        if(without_price == "" || isNaN(without_price))
        {without_price = 0;}

        total_qty = without_qty;
        $('#total_qty').val(total_qty);

        total_price = parseFloat(without_qty * without_price);
        $('#total_price').val(total_price);

        var total_amount = 0;
        var total_taxable = 0;
        var without_taxable = 0;

        var total_sgst = 0;
        var total_cgst = 0;
        var total_igst = 0;

        var without_sgst = 0;
        var without_cgst = 0;
        var without_igst = 0;

        if (without_qty > 0) {
            var without_taxable = calculateTaxable(without_qty, without_price);
            if (without_taxable > 0) {
                var without_gst = calculateGst(without_taxable);
                without_sgst = without_gst.sgst;
                without_cgst = without_gst.cgst;
                without_igst = without_gst.igst;
            }
        }

        total_taxable = without_taxable;
        $('#taxable').val(total_taxable.toFixed(2));

        total_sgst = parseFloat(without_sgst);
        total_cgst = parseFloat(without_cgst);
        total_igst = parseFloat(without_igst);

        
        $('#total_sgst').val(total_sgst.toFixed(2));
        $('#total_cgst').val(total_cgst.toFixed(2));
        $('#total_igst').val(total_igst.toFixed(2));

        total_amount = parseFloat(total_taxable + (total_sgst + total_cgst + total_igst));
        $('#total_amount').val(total_amount.toFixed(2));

        
    }
    
    
    //kids size type
    function calculateQtyPriceKids() {
        var total_qty = 0;
        var total_price = 0;

        var k_18_qty = parseFloat($('#k_18_qty').val());
        var k_18_price = parseFloat($('#k_18_price').val());

        var k_20_qty = parseFloat($('#k_20_qty').val());
        var k_20_price = parseFloat($('#k_20_price').val());

        var k_22_qty = parseFloat($('#k_22_qty').val());
        var k_22_price = parseFloat($('#k_22_price').val());

        var k_24_qty = parseFloat($('#k_24_qty').val());
        var k_24_price = parseFloat($('#k_24_price').val());

        var k_26_qty = parseFloat($('#k_26_qty').val());
        var k_26_price = parseFloat($('#k_26_price').val());

        var k_28_qty = parseFloat($('#k_28_qty').val());
        var k_28_price = parseFloat($('#k_28_price').val());

        var k_30_qty = parseFloat($('#k_30_qty').val());
        var k_30_price = parseFloat($('#k_30_price').val());

        var k_32_qty = parseFloat($('#k_32_qty').val());
        var k_32_price = parseFloat($('#k_32_price').val());

        var k_34_qty = parseFloat($('#k_34_qty').val());
        var k_34_price = parseFloat($('#k_34_price').val());

        var k_36_qty = parseFloat($('#k_36_qty').val());
        var k_36_price = parseFloat($('#k_36_price').val());

        if(k_18_qty == "" || isNaN(k_18_qty))
        {k_18_qty = 0;}
        if(k_20_qty == "" || isNaN(k_20_qty))
        {k_20_qty = 0;}
        if(k_22_qty == "" || isNaN(k_22_qty))
        {k_22_qty = 0;}
        if(k_24_qty == "" || isNaN(k_24_qty))
        {k_24_qty = 0;}
        if(k_26_qty == "" || isNaN(k_26_qty))
        {k_26_qty = 0;}
        if(k_28_qty == "" || isNaN(k_28_qty))
        {k_28_qty = 0;}
        if(k_30_qty == "" || isNaN(k_30_qty))
        {k_30_qty = 0;}
        if(k_32_qty == "" || isNaN(k_32_qty))
        {k_32_qty = 0;}
        if(k_34_qty == "" || isNaN(k_34_qty))
        {k_34_qty = 0;}
        if(k_36_qty == "" || isNaN(k_36_qty))
        {k_36_qty = 0;}

        if(k_18_price == "" || isNaN(k_18_price))
        {k_18_price = 0;}
        if(k_20_price == "" || isNaN(k_20_price))
        {k_20_price = 0;}
        if(k_22_price == "" || isNaN(k_22_price))
        {k_22_price = 0;}
        if(k_24_price == "" || isNaN(k_24_price))
        {k_24_price = 0;}
        if(k_26_price == "" || isNaN(k_26_price))
        {k_26_price = 0;}
        if(k_28_price == "" || isNaN(k_28_price))
        {k_28_price = 0;}
        if(k_30_price == "" || isNaN(k_30_price))
        {k_30_price = 0;}
        if(k_32_price == "" || isNaN(k_32_price))
        {k_32_price = 0;}
        if(k_34_price == "" || isNaN(k_34_price))
        {k_34_price = 0;}
        if(k_36_price == "" || isNaN(k_36_price))
        {k_36_price = 0;}

        total_qty = k_18_qty + k_20_qty + k_22_qty + k_24_qty + k_26_qty + k_28_qty + k_30_qty + k_32_qty + k_34_qty + k_36_qty;
        $('#total_qty').val(total_qty);

        total_price = parseFloat(k_18_qty * k_18_price) + parseFloat(k_20_qty * k_20_price) + parseFloat(k_22_qty * k_22_price) + parseFloat(k_24_qty * k_24_price) + parseFloat(k_26_qty * k_26_price) + parseFloat(k_28_qty * k_28_price) + parseFloat(k_30_qty * k_30_price) + parseFloat(k_32_qty * k_32_price) + parseFloat(k_34_qty * k_34_price) + parseFloat(k_36_qty * k_36_price);
        $('#total_price').val(total_price);

        var total_amount = 0;
        var total_taxable = 0;
        var k_18_taxable = 0;
        var k_20_taxable = 0;
        var k_22_taxable = 0;
        var k_24_taxable = 0;
        var k_26_taxable = 0;
        var k_28_taxable = 0;
        var k_30_taxable = 0;
        var k_32_taxable = 0;
        var k_34_taxable = 0;
        var k_36_taxable = 0;

        var total_sgst = 0;
        var total_cgst = 0;
        var total_igst = 0;

        var k_18_sgst = 0;
        var k_18_cgst = 0;
        var k_18_igst = 0;

        var k_20_sgst = 0;
        var k_20_cgst = 0;
        var k_20_igst = 0;

        var k_22_sgst = 0;
        var k_22_cgst = 0;
        var k_22_igst = 0;

        var k_24_sgst = 0;
        var k_24_cgst = 0;
        var k_24_igst = 0;

        var k_26_sgst = 0;
        var k_26_cgst = 0;
        var k_26_igst = 0;

        var k_28_sgst = 0;
        var k_28_cgst = 0;
        var k_28_igst = 0;

        var k_30_sgst = 0;
        var k_30_cgst = 0;
        var k_30_igst = 0;

        var k_32_sgst = 0;
        var k_32_cgst = 0;
        var k_32_igst = 0;

        var k_34_sgst = 0;
        var k_34_cgst = 0;
        var k_34_igst = 0;

        var k_36_sgst = 0;
        var k_36_cgst = 0;
        var k_36_igst = 0;

        if (k_18_qty > 0) {
            var k_18_taxable = calculateTaxable(k_18_qty, k_18_price);
            if (k_18_taxable > 0) {
                var k_18_gst = calculateGst(k_18_taxable);
                k_18_sgst = k_18_gst.sgst;
                k_18_cgst = k_18_gst.cgst;
                k_18_igst = k_18_gst.igst;
            }
        }
        if (k_20_qty > 0) {
            var k_20_taxable = calculateTaxable(k_20_qty, k_20_price);
            if (k_20_taxable > 0) {
                var k_20_gst = calculateGst(k_20_taxable);
                k_20_sgst = k_20_gst.sgst;
                k_20_cgst = k_20_gst.cgst;
                k_20_igst = k_20_gst.igst;
            }
        }
        if (k_22_qty > 0) {
            var k_22_taxable = calculateTaxable(k_22_qty, k_22_price);
            if (k_22_taxable > 0) {
                var k_22_gst = calculateGst(k_22_taxable);
                k_22_sgst = k_22_gst.sgst;
                k_22_cgst = k_22_gst.cgst;
                k_22_igst = k_22_gst.igst;
            }
        }
        if (k_24_qty > 0) {
            var k_24_taxable = calculateTaxable(k_24_qty, k_24_price);
            if (k_24_taxable > 0) {
                var k_24_gst = calculateGst(k_24_taxable);
                k_24_sgst = k_24_gst.sgst;
                k_24_cgst = k_24_gst.cgst;
                k_24_igst = k_24_gst.igst;
            }
        }
        if (k_26_qty > 0) {
            var k_26_taxable = calculateTaxable(k_26_qty, k_26_price);
            if (k_26_taxable > 0) {
                var k_26_gst = calculateGst(k_26_taxable);
                k_26_sgst = k_26_gst.sgst;
                k_26_cgst = k_26_gst.cgst;
                k_26_igst = k_26_gst.igst;
            }
        }

        if (k_28_qty > 0) {
            var k_28_taxable = calculateTaxable(k_28_qty, k_28_price);
            if (k_28_taxable > 0) {
                var k_28_gst = calculateGst(k_28_taxable);
                k_28_sgst = k_28_gst.sgst;
                k_28_cgst = k_28_gst.cgst;
                k_28_igst = k_28_gst.igst;
            }
        }
        if (k_30_qty > 0) {
            var k_30_taxable = calculateTaxable(k_30_qty, k_30_price);
            if (k_30_taxable > 0) {
                var k_30_gst = calculateGst(k_30_taxable);
                k_30_sgst = k_30_gst.sgst;
                k_30_cgst = k_30_gst.cgst;
                k_30_igst = k_30_gst.igst;
            }
        }
        if (k_32_qty > 0) {
            var k_32_taxable = calculateTaxable(k_32_qty, k_32_price);
            if (k_32_taxable > 0) {
                var k_32_gst = calculateGst(k_32_taxable);
                k_32_sgst = k_32_gst.sgst;
                k_32_cgst = k_32_gst.cgst;
                k_32_igst = k_32_gst.igst;
            }
        }

        if (k_34_qty > 0) {
            var k_34_taxable = calculateTaxable(k_34_qty, k_34_price);
            if (k_34_taxable > 0) {
                var k_34_gst = calculateGst(k_34_taxable);
                k_34_sgst = k_34_gst.sgst;
                k_34_cgst = k_34_gst.cgst;
                k_34_igst = k_34_gst.igst;
            }
        }

        if (k_36_qty > 0) {
            var k_36_taxable = calculateTaxable(k_36_qty, k_36_price);
            if (k_36_taxable > 0) {
                var k_36_gst = calculateGst(k_36_taxable);
                k_36_sgst = k_36_gst.sgst;
                k_36_cgst = k_36_gst.cgst;
                k_36_igst = k_36_gst.igst;
            }
        }

        total_taxable = k_18_taxable + k_20_taxable + k_22_taxable + k_24_taxable + k_26_taxable + k_28_taxable + k_30_taxable + k_32_taxable + k_34_taxable + k_36_taxable;
        $('#taxable').val(total_taxable.toFixed(2));

        total_sgst = parseFloat(k_18_sgst) + parseFloat(k_20_sgst) + parseFloat(k_22_sgst) + parseFloat(k_24_sgst) + parseFloat(k_26_sgst) + parseFloat(k_28_sgst) + parseFloat(k_30_sgst) + parseFloat(k_32_sgst) + parseFloat(k_34_sgst) + parseFloat(k_36_sgst);
        total_cgst = parseFloat(k_18_cgst) + parseFloat(k_20_cgst) + parseFloat(k_22_cgst) + parseFloat(k_24_cgst) + parseFloat(k_26_cgst) + parseFloat(k_28_cgst) + parseFloat(k_30_cgst) + parseFloat(k_32_cgst) + parseFloat(k_34_cgst) + parseFloat(k_36_cgst);
        total_igst = parseFloat(k_18_igst) + parseFloat(k_20_igst) + parseFloat(k_22_igst) + parseFloat(k_24_igst) + parseFloat(k_26_igst) + parseFloat(k_28_igst) + parseFloat(k_30_igst) + parseFloat(k_32_igst) + parseFloat(k_34_igst) + parseFloat(k_36_igst);

        
        $('#total_sgst').val(total_sgst.toFixed(2));
        $('#total_cgst').val(total_cgst.toFixed(2));
        $('#total_igst').val(total_igst.toFixed(2));

        total_amount = parseFloat(total_taxable + (total_sgst + total_cgst + total_igst));
        $('#total_amount').val(total_amount.toFixed(2));


    }

    //normal size
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
            document.getElementById('take_photo').innerHTML = '<img class="card-img-top img-thumbnail after_capture_frame" src="'+data_uri+'"/>';
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
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#show_total_qty').html('');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#show_total_value').html('');
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#show_purchase_entry').append(response.html);
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#show_total_qty').append(response.total_qty);
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#show_total_value').append(response.total_value);
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

    function manageSizeTypeHtml() {
        // console.log(size_type);

        var category_id = $('#category_id').val();
        var size_type = $('#category_id').find("option:selected").attr('size-type');
        $('#size_type_id').val(size_type);
        $('#show_size').empty();
        if (size_type == 2) {
            $('#show_size').append($('#kids_size_type').html());
            $('#show_size').css('width','700px');
        }else if (size_type == 3) {
            $('#show_size').append($('#without_size_type').html());
            $('#show_size').css('width','100%');
        } else {
            $('#show_size').append($('#normal_size_type').html());
            $('#show_size').css('width','650px');
        }

        getSubCategoryByCategory(category_id);
        totalAmountFieldZero();
        
    }

    function totalAmountFieldZero(){
        $('#total_qty').val('0');
        $('#total_price').val('0');
        $('#discount').val('0');
        $('#taxable').val('0');
        $('#total_sgst').val('0');
        $('#total_cgst').val('0');
        $('#total_igst').val('0');
        $('#total_amount').val('0');
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
                console.log(response);

                if (response.status === 400) {
                    $('#purchase_entry_err').html('');
                    $('#purchase_entry_err').addClass('alert alert-danger');
                    var count = 1;
                    $.each(response.errors, function (key, err_value) {
                        $('#purchase_entry_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                    });

                } else {
                    $('#purchase_entry_err').html('');
                    $('#purchase_entry_err').removeClass('alert alert-danger');
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
                // console.log(response);

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
                        
                        $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find('#take_photo').append('<img class="card-img-top img-thumbnail after_capture_frame" src="'+response.purchase_entry.img+'" style="height: 100px;"/>');
                    }

                    // $('#size_type_id').val(size_type);
                    $('#show_size').empty();
                    if (response.size_type == 2) {
                        $('#show_size').append($('#kids_size_type').html());
                        $('#show_size').css('width','700px');
                    }else if (response.size_type == 3) {
                        $('#show_size').append($('#without_size_type').html());
                        $('#show_size').css('width','100%');
                    } else {
                        $('#show_size').append($('#normal_size_type').html());
                        $('#show_size').css('width','650px');
                    }

                    var discount = 0;
                    $.each(response.purchase_entry_items, function (key, list) {
                        var size = "";
                        if (response.size_type == 2) {
                            //kids
                            size = 'k_'+list.size;
                        } else if (response.size_type == 3) {
                            //without
                            size = 'without';
                        } else {
                            //normal
                            if (list.size == '3xl') {
                                size = 'three_xl';
                            }else if(list.size == '4xl'){
                                size = 'four_xl';
                            }else if(list.size == '5xl'){
                                size = 'five_xl';
                            }else{
                                size = list.size;
                            }
                        } 

                        $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find('#'+size+'_qty').val(list.qty);
                        $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find('#'+size+'_price').val(list.price);
                        $('#purchaseEntryModal').find('#purchaseEntryForm').find('#product_section').find('#'+size+'_mrp').val(list.mrp);
                        discount = list.discount;
                    });
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#discount').val(discount);

                    if (response.size_type == 2) {
                        calculateQtyPriceKids();
                    }else if (response.size_type == 3) {
                        calculateQtyPriceWithout();
                    } else {
                        calculateQtyPrice();
                    }
                                        
                    // $('#purchaseEntryModal').find('#purchaseEntryForm').find('#supplier_id').val(response.purchase.supplier_id);
                    // $('#purchaseEntryModal').find('#purchaseEntryForm').find('#supplier_id').remove();
                    
                    // $("#supplier_div").append('<input type="hidden" name="supplier_id" value="">\
                    // <input type="text" value="'+response.purchase.supplier_id+'" class="form-control form-control-sm" readonly disabled>');
                    
                    $('#purchaseEntryModal').find('#purchaseEntryForm').find('#size_type_id').val(response.size_type);
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
                // console.log(response);
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

    function getBarcodeByPurchaseEntry(purchase_entry_id){
        $.ajax({
            type: "get",
            url: "barcode-by-purchase-entry/"+purchase_entry_id,
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response.status == 200) {
                    $('#barcodeModal').modal('show');
                    $('#view_barcode').html('');
                    $('#view_barcode').append(response.html);
                }
            }
        });

    }

    function getAllBarcodeByPurchaseEntry(purchases_id){
        $.ajax({
            type: "get",
            url: "barcode-all-purchase-entry/"+purchases_id,
            dataType: "json",
            success: function (response) {
                console.log(response);
                if (response.status == 200) {
                    $('#barcodeModal').modal('show');
                    $('#view_barcode').html('');
                    $('#view_barcode').append(response.html);
                }
            }
        });
    }

    function loadPtFileData() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        var formData = new FormData($("#purchaseEntryForm")[0]);
        $.ajax({
            type: "post",
            url: "load-pt-file-data",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false, 
            processData: false, 
            success: function (response) {
                $('#show_pt_file_data').html('');
                if (response.status == 200) {
                    // $('#barcodeModal').modal('show');
                    $('#show_pt_file_data').append(response.html);
                }
            }
        });
    }

    function savePtFile(formData) {
        $.ajax({
            type: "post",
            url: "save-pt-file",
            data: formData,
            dataType: "json",
            success: function (response) {
                // console.log(response);
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
                }
            }
        });
    }

    //function printBarcodeWithModal(){
        
        // var backup = document.body.innerHTML;
        // var div_content = document.getElementById("print_barcode").innerHTML;
        // document.body.innerHTML = div_content;
        // window.print();
        // document.body.innerHTML = backup;
        // window.location.reload();


        // const section = $("section");
        // const modalBody = $("#print_barcode").detach();
        // // const modalBody = document.getElementById("print_barcode").innerHTML;

        // section.empty();
        // section.append(modalBody);
        // window.print();
        // window.location.reload();

        
    //}




