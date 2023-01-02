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
                                <th >SN</th>
                                <th >Category</th>
                                <th >Qty</th>
                                <th >Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{$count = "";}}
                            
                            @foreach ($categories as $key => $item)
                                @php 
                                    $result = stockItemQtyByCategory($item['id']);
                                @endphp 
                                    <tr>
                                        <th scope="row">{{++$key}}</th>
                                        <td>{{ucwords($item['category'])}}</td>
                                        <td>{{$result['total_qty']}}</td>
                                        <td>{{$result['total_amount']}}</td>
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
                            <select id="category_id" name="category_id" class="form-select form-select-sm select_chosen" >
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
                                <th >SN</th>
                                <th >Sub Categoty</th>
                                <th >Qty</th>
                                <th >Amount</th>
                            </tr>
                        </thead>
                        <tbody >
                            @foreach ($sub_categories as $key => $item)
                                @php 
                                    $result = stockItemQtyBySubCategory($item['id']);
                                 
                                    
                                @endphp 
                                <tr class="row_filter" category-id="{{$item['category_id']}}">
                                    <th scope="row">{{++$key}}</th>
                                    <td>{{ucwords($item['sub_category'])}}</td>
                                    <td>{{$result['total_qty']}}</td>
                                    <td>{{$result['total_amount']}}</td>
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
                        <div class="col-md-2 "><b>Products</b></div>
                    </div>
                     <div class="row">
                        <div class="col-md-2  offset-1">
                            <select id="filter_category_id" class="form-select form-select-sm select_chosen" onchange="getSubCategoryByCategory(this.value);" >
                                <option selected disabled >Category</option>
                                @foreach ($categories as $key => $list)
                                    <option value="{{$list->id}}" >{{ucwords($list->category)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="sub_category_id" class="form-select form-select-sm select_chosen">
                                <option selected disabled >Choose...</option>
                                {{-- @foreach ($sub_categories as $items)
                                    <option value="{{$items->id}}">{{$items->sub_category}}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="brand_id" class="form-select form-select-sm select_chosen" >
                                <option selected value="0">Brand</option>
                                @foreach ($brands as $key => $list)
                                    <option value="{{$list->id}}">{{ucwords($list->brand_name)}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select id="style_no_id" class="form-select form-select-sm select_chosen" >
                                <option selected value="0" >Style No</option>
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
                            <i class="fas fa-redo cursor-pointer position-absolute top-50 start-50 translate-middle" id="reset_products"></i>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="show_product"></div>                    
                </div>
            </div>
        </div>

    </div>

@endsection;

@section('script')
    <script>

        $(document).ready(function () {
            $(".select_chosen").chosen({ width: '100%' });
            showProduct();
            $(document).on('change','#category_id', function (e) {
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
            });

            $(document).on('change','#filter_category_id', function (e) {
                showProduct();
            });     
            $(document).on('change','#sub_category_id', function (e) {
                showProduct();
            });     
            $(document).on('change','#brand_id', function (e) {
                showProduct();
            });
            $(document).on('change','#style_no_id', function (e) {
                showProduct();
            });
            $(document).on('change','#color', function (e) {
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
            var brand_id = $('#brand_id').val();
            var style_no_id = $('#style_no_id').val();
            var color = $('#color option:selected').text();
          

            $.ajax({
                type: "get",
                dataType: "json",
                url: "show-product/"+ category_id + "/" + sub_category_id + "/" + brand_id + "/" + style_no_id + "/" + color,
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
