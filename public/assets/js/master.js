
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