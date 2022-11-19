
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
            }
        }
    });
}