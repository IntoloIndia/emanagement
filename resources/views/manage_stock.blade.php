@extends('layouts.app')
@section('page_title', 'Manage Stock')

@section('style')
    <style>
    #colorinput{
        border: none;
    }
    </style>
@endsection;

@section('content')

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <b>Category </b>
                </div>
                <div class="card-body table-responsive p-0" style="height: 250px;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th scope="col">SN</th>
                                <th scope="col">Category</th>
                                {{-- <th scope="col">Qty</th> --}}
                                <th scope="col">Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{$count = "";}}
                            @foreach ($category_qty as $item)
                                @php 
                                    $qty = ManageStockItemQty($item['id']);
                                    // print_r($qty);
                                @endphp 
                                     
                                    <tr>
                                        <th scope="row">{{++$count}}</th>
                                        <td>{{ucwords($item['category'])}}</td>
                                        {{-- <td>{{$item['count']}}</td> --}}
                                        <td>{{$qty}}</td>
                                        </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6"><b>Sub Categoty</b></div>
                        <div class="col-md-6">
                            <select id="category_id" name="category_id" class="form-select form-select-sm" >
                                <option selected disabled >Category</option>
                                @foreach ($categories as $key => $list)
                                    <option value="{{$list->id}}" >{{ucwords($list->category)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0" style="height: 250px;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th >Sno</th>
                                <th >Sub Categoty</th>
                                <th >Qty</th>
                            </tr>
                        </thead>
                        <tbody >

                            {{$count = "";}}
                            @foreach ($sub_category_qty as $item)
                                @php 
                                    $manage_sub_category_qty = ManageSubCategoryQty($item['id']);
                                // print_r($qty);
                                @endphp 
                                <tr class="row_filter" category-id="{{$item['category_id']}}">
                                    <th scope="row">{{++$count}}</th>
                                    <td>{{ucwords($item['sub_category'])}}</td>
                                    <td>{{$manage_sub_category_qty}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-2"><b>Products</b></div>
                     
                        <div class="col-md-2">
                            <select id="filter_category_id" class="form-select form-select-sm select_chosen" onchange="getSubCategoryByCategory(this.value);" >
                                <option selected disabled >Category</option>
                                @foreach ($categories as $key => $list)
                                    <option value="{{$list->id}}" >{{$list->category}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="sub_category_id" class="form-select form-select-sm">
                                <option selected disabled >Choose...</option>
                                {{-- @foreach ($sub_categories as $items)
                                    <option value="{{$items->id}}">{{$items->sub_category}}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="col-md-3">
                            {{-- <div id="show_style_no"></div> --}}
                            <select id="style_no_id" class="form-select form-select-sm" >
                                <option selected disabled >Style No</option>
                                @foreach ($get_style_no as $key => $list)
                                    <option value="{{$list->id}}" >{{$list->style_no}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="button" id="reset_products" class="btn btn-dark btn-sm mt-1">Reset</button>
                        </div>
                        <div class="col-md-1" >
                            <b><span id="assign_work_count" >100</span></b>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="show_product"></div>
                    {{-- <div class='accordion accordion-flush table-responsive' id='accordionFlushExample' style="height: 500px;">
                        <table class='table table-striped table-head-fixed'>
                            <thead>
                                <tr style='position: sticky;z-index: 1;'>
                                    <th scope="col">SN</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Sub Category</th>
                                    <th scope="col">Style No</th>
                                    <th scope="col">Color</th>
                                    
                                </tr>
                            </thead>
                            <tbody > --}}
                                {{-- @foreach ($purchase_entry as $key => $list)
                                       
                                    <tr class='accordion-button collapsed' data-bs-toggle='collapse' data-bs-target='#collapse_{{$list->id}}' aria-expanded='false' aria-controls='flush-collapseOne'>
                                        <td>{{++$key}}</td>
                                        <td>{{ucwords($list->category)}}</td>
                                        <td>{{ucwords($list->sub_category)}}</td>
                                        <td>{{ucwords($list->style_no)}}</td>
                                        <td>{{ucwords($list->color)}}</td>
                                    </tr> 

                                    @php
                                        $purchase_entry_item = getPurchaseEntryItems($list->id)
                                     
                                    @endphp
                                   
                                    <tr>
                                        <td colspan='5'>
                                            <div id='collapse_{{$list->id}}' class='accordion-collapse collapse' aria-labelledby='flush-headingOne' data-bs-parent='#accordionFlushExample'>
                                                <div class='accordion-body'>
                                                    <table class="table ">
                                                        <thead>
                                                            <tr>
                                                                <th> SN</th>
                                                                <th> Size</th>
                                                                <th> Qty</th>
                                                                <th> Price</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($purchase_entry_item['items'] as $key1 => $item)
                                                                
                                                                <tr>
                                                                    <td>{{++$key1}}</td>
                                                                    <td>{{$item->size}}</td>
                                                                    <td>{{$item->qty}}</td>
                                                                    <td>{{$item->price}}</td>
                                                                </tr>
                                                            @endforeach
                    
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                @endforeach                                               
                            </tbody>
                        </table>  
                    </div> --}}

                </div>
            </div>
        </div>

    </div>

@endsection;

@section('script')
    <script>

        $(document).ready(function () {
            $(".select_chosen").chosen({ width: '100%' });

            $(document).on('change','#filter_category_id', function (e) {
                e.preventDefault();
                const category_id = $(this).val();
                var row = $('.row_filter');
                row.hide()
                row.each(function(i, el) {
                    if($(el).attr('category-id') == category_id) {
                        $(el).show();
                    }
                })

                showProduct();

            
                // $(".iform_row_filter ").each(function () {
                //     if ($(this).text().toLowerCase().search(value) > -1) {
                //         $(this).show();
                //     } else {
                //         $(this).hide();
                //     }
                // });
                // getSubCategoryByCategory(category_id);

                // $(".filter").change(function() {
                //     var filterValue = $(this).val();
                //     var row = $('.row'); 
                    
                //     row.hide()
                //     row.each(function(i, el) {
                //         if($(el).attr('data-type') == filterValue) {
                //             $(el).show();
                //         }
                //     })
                    
                // });
                
            });
            $(document).on('change','#sub_category_id', function (e) {
                showProduct();
            });     
            $(document).on('change','#style_no_id', function (e) {
                showProduct();
            });
            $(document).on('click','#reset_products', function (e) {
                window.location.reload();
            });

        });

        function showProduct()
        {
            var category_id = $('#filter_category_id').val();
            var sub_category_id = $('#sub_category_id').val();
            var style_no_id = $('#style_no_id').val();

            $.ajax({
                type: "get",
                dataType: "json",
                url: "show-product/"+ category_id + "/" + sub_category_id + "/" + style_no_id,
                success: function (response) {
                    console.log(response);
                    if(response.status == 200){
                        $('#show_product').html("");
                        $('#show_product').append(response.html)
                    }
                }
            });
        }
    </script>
@endsection
