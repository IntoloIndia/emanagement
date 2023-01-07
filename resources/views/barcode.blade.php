@extends('layouts.app')
@section('page_title', 'Barcode')
@section('style')
<style>
    /* .colorbox{
        width: 200px !important;
        height: 200px !important;   
        border: 1px solid black;
        background-color: red

    } */
</style>
@endsection
@section('content')
    {{-- <h1>Barcode</h1> --}}
     <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-1">
                    <b>Barcodes</b>
                </div>
            
                <div class="col-md-2 ">
                         <select id="filter_category_id" class="form-select form-select-sm select_chosen" onchange="getSubCategoryByCategory(this.value);" >
                        <option selected disabled >Category</option>
                        @foreach ($categories as $key => $list)
                            <option value="{{$list->id}}" >{{$list->category}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="sub_category_id" class="form-select form-select-sm select_chosen">
                        <option selected disabled >Choose...</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="brand_id" class="form-select form-select-sm select_chosen" >
                        <option selected disabled value="0">Brand</option>
                        @foreach ($brands as $key => $list)
                            <option value="{{$list->id}}">{{ucwords($list->brand_name)}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="style_no_id" data-placeholder='Style no' class="form-select form-select-sm select_chosen">
                        <option selected disabled value="0">Style no</option>
                        @foreach ($get_style_no as $key => $list)
                            <option value="{{$list->id}}" >{{$list->style_no}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="color" data-placeholder='Select color' class="form-select form-select-sm select_chosen" >
                        <option selected value="" disabled ></option>
                        @foreach ($colors as $key => $list)
                            <option value="{{$list->id}}">{{$list->color}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1 text-end position-relative" >
                    <i class="fas fa-redo cursor-pointer position-absolute top-50 start-50 translate-middle" id="reset_filter"></i>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div id="show_filter_barcode"></div>
            {{-- <div class="row">
                @foreach ($Barcodes_data as $list)
                <div class="col-md-3">
                    <div class="card" id="div1">
                      
                            <div class="card-body" >
                                   

                                <div class="row mb-2"></div>
                                <div class="row" >
                                    <div class="col-md-12 ">
                                    <span class="tect-center business_title ml-2" style="letter-spacing: 3px;"><b>MANGALDEEP CLOTHS LLP</b></span><br/>
                                    <span class="product_detail ml-3">Product : </span> <span  class="ml-5 filter_row " row-value="{{$list->id}}">{{ucwords($list->sub_category)}}</span> <br/>
                                    <span class="product_detail ml-3">Brand : </span> <span class="ml-5 ">{{ucwords($list->brand_name)}}</span> <br/>
                                    <span class="product_detail ml-3">Style: </span> <span  class="ml-5 ">{{$list->style_no}}</span> <br/>
                                    <span class="product_detail ml-3">Color : </span> <span class="ml-5 colorbox ">{{ucwords($list->color)}}</span> <br/>
                                    <span class="product_detail ml-3">Size : </span> <span  class="ml-5">{{ucwords($list->size)}}</span> <br/>
                                    <span class="product_detail ml-3" style="font-size: 20px;">MRP </span>: <b  class="ml-5" style="font-size: 20px;">{{$list->mrp}}</b> <br/>
                                </div>
                                    <div class="col-md-12" >
                                        <img src="{{$list->barcode_img}}" class="barcode_image barcode img-fluid"><br/>
                                        <span class="product_detail"><b style="letter-spacing: 15px;">{{$list->barcode}}</b></span> <br/>
                                     </div>
                                </div>
                                <button class="btn btn-success btn-sm float-right" onclick="printBarcode('div1')"><i class="fas fa-file-invoice"></i></button>
                            </div>
                        
                                                  
                    </div>
                </div>
                @endforeach
            </div> --}}
        </div> 
    </div>

    {{-- <div class="row">
        <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <b>card</b>
                </div>
                {{-- div start  --}}
                {{-- <div id="divprint" style="">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                           <strong>product name</strong><br/>
                           <strong>sec</strong><br/>
                           <strong>style no</strong><br/>
                           <strong>color</strong><br/>
                           <strong>size</strong><br/>
                           <strong>MRP</strong>
                        </div>
                        <div class="col-md-6">
                          <strong>Jeans</strong><br/>
                          <strong>Super Slim (DD) J</strong><br/>
                          <strong>MFT-28457-P</strong><br/>
                          <strong>black</strong><br/>
                          <strong>xl</strong><br/>
                          <strong>2500rs</strong><br/>
                        </div> 
                        <strong>Sec</strong>:<strong class="ml-2"> Super</strong><br/> 
                            <strong>style no</strong>:<strong class="ml-2">sty1021</strong><br/>
                           <strong>color</strong>:<strong class="ml-2">black</strong><br/>
                           <strong>size</strong>:<strong class="ml-2">xl</strong><br/> 
                        
                         <div class="col-md-12" >
                            <img src="{{$list->barcode_img}}" class="barcode_image barcode img-fluid" style="height:50px;"><br/> --}} 
                            {{-- <img src="{{asset('public/assets/barcodes/barcode.gif')}}" class="img-thumbnail " > --}}
                             {{-- <span class="product_detail"><b style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">{{$list->barcode}}</b></span> <br/>
                         </div>
                        </div> 
                </div>
                        <button class="btn btn-primary btn-sm float-right" onclick="myFun('divprint')">print</button>
                        
                </div>
            </div>  --}}
                 {{-- div start  --}}
            {{-- </div>
        </div> --}}
        {{-- <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <b>table</b>
                </div>
                <div class="card-body">
                    <div id="divprint1">
                        <table class="table" style="width:400px;">
                            <tbody>
                              <tr>
                                <td>prod:</td>
                                <td>Jeans</td>
                                <td>Jeans</td>
                              </tr>
                               <td colspan="3">

                                 <img src="{{$list->barcode_img}}" class="barcode_image barcode img-fluid" ><br/>
                                <span class="product_detail"><b style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">{{$list->barcode}}</b></span> <br/>

                                </td>
                              
                              </tr>
                            </tbody>
                          </table>
                    </div>
                    <button class="btn btn-primary btn-sm float-right" onclick="myFun('divprint1')">print</button>
                </div>

            </div>
        </div> --}}
    {{-- </div> --}} 
 
   


@endsection

@section('script')
<script>

    $(document).ready(function () {
        $(".select_chosen").chosen({ width: '100%' });

        $(document).on('click','#reset_filter', function (e) {
                window.location.reload();
        });
        
        $(document).on('change','#sub_category_id', function (e) {
            filterBarcode();
        });
        $(document).on('change','#brand_id', function (e) {
            filterBarcode();
        });
        $(document).on('change','#style_no_id', function (e) {
            filterBarcode();
        });
        $(document).on('change','#color', function (e) {
            filterBarcode();
        });

        $(document).on('click','.print', function (e) {
            var print_section = $(this).attr('print-section');
            printBarcode(print_section);
        });

        // $("#sub_category_id").change(function() {
        //     var filterValue = $(this).val();
        //     var row = $('.filter_row'); 
        //     row.hide()
        //     row.each(function(i, el) {
        //         if($(el).attr('row-value') == filterValue) {
        //             $(el).show();
        //         }
        //     })
        // });



    });
    

    // function printBarcode(){
        
    //     var backup = document.body.innerHTML;
    //     var div_content = document.getElementById("show_barcode_body").innerHTML;
    //     document.body.innerHTML = div_content;
    //     window.print();
    //     document.body.innerHTML = backup;


    //     // const section = $("section");
    //     // // const modalBody = $("#show_barcode_body").detach();
    //     // const modalBody = document.getElementById("barcode_body").innerHTML;

    //     // section.empty();
    //     // section.append(modalBody);
    //     // window.print();
    //     // window.location.reload();

    //     // var print_div = document.getElementById("show_barcode_body");
    //     // // var print_div = document.getElementById("barcode_body");
    //     // var print_area = window.open();
    //     // print_area.document.write(print_div.innerHTML);
    //     // print_area.document.close();
    //     // print_area.focus();
    //     // print_area.print();
      
    //     window.location.reload();
    // }

    function filterBarcode()
    {
        var sub_category_id = $('#sub_category_id').val();
        var brand_id = $('#brand_id').val();
        var style_no_id = $('#style_no_id').val();
        var color = $('#color option:selected').text();

        $.ajax({
            type: "get",
            dataType: "json",
            url: "filter-barcode/"+ sub_category_id + "/" +brand_id + "/" + style_no_id + "/" + color,
            success: function (response) {
                // console.log(response);
                if(response.status == 200){
                    $('#show_filter_barcode').html("");
                    $('#show_filter_barcode').append(response.html)
                }
            }
        });
    }


</script>
@endsection

