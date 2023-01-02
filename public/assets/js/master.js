
//common function
function getSubCategoryByCategory(category_id) {
    $.ajax({
        type: "get",
        url: "get-sub-category-by-category/"+category_id,
        dataType: "json",
        success: function (response) {
            $('#sub_category_id').html("");
            if (response.status == 200) {
                $('#sub_category_id').append(response.html); 
                $("#sub_category_id").trigger("chosen:updated");  
            }
        }
    });
}

function getStateByCountry(country_id) {
    $.ajax({
        type: "get",
        url: "get-state-by-country/"+country_id,
        dataType: "json",
        success: function (response) {
            $('#state_id').html("");
            $('#city_id').html("");
            if (response.status == 200) {
                $('#state_id').append(response.html);  
                $("#state_id").trigger("chosen:updated"); 
            }
        }
    });
}

function getCityByState(state_id) {
    $.ajax({
        type: "get",
        url: "get-city-by-state/"+state_id,
        dataType: "json",
        success: function (response) {
            $('#city_id').html("");
            if (response.status == 200) {
                $('#city_id').append(response.html); 
                $("#city_id").trigger("chosen:updated");  
                
            }
        }
    });
}

function generateInvoice(bill_id) {
    $.ajax({
       type: "get",
       url: "generate-invoice/"+bill_id,
       dataType: "json",
       success: function (response) {
        //    console.log(response);

           if (response.status == 200) {
               $('#generateInvoiceModal').html(response.html);
               $('#generateInvoiceModal').modal('show');
               // window.location.reload();
           }
       }
   });
}




function saveColor() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var formData = new FormData($("#colorForm")[0]);
    $.ajax({
        type: "post",
        url: "save-color",
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            if (response.status === 400) {
                $('#color_err').html('');
                $('#color_err').addClass('alert alert-danger');
                var count = 1;
                $.each(response.errors, function (key, err_value) {
                    $('#color_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                });

            } else {
                $('#color_err').html('');
                $('#colorModal').modal('hide');
                // window.location.reload();
                $('#color').html('');
                $('#color').append(response.color_html); 
                $("#color").trigger("chosen:updated");  
            }
        }
    });
}

function manageCity(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var formData = new FormData($("#cityForm")[0]);
    $.ajax({
        type: "post",
        url: "manage-city",
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false, 
        processData: false, 
        success: function (response) {
            //console.log(response);
            if(response.status === 400)
            {
                $('#city_err').html('');
                $('#city_err').addClass('alert alert-danger');
                var count = 1;
                $.each(response.errors, function (key, err_value) { 
                    $('#city_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                });
                

            }else{
                $('#city_err').html('');
                $('#cityModal').modal('hide');
                var state_id = $("#put_country_id").val();

                // alert(state_id);
                getCityByState(state_id);
                // window.location.reload();
            }
        }
    });
}
