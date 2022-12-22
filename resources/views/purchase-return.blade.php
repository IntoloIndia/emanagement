@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <b>Purchase Return</b>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                        <label for="exampleFormControlInput1" class="form-label">Barcode</label>
                        <input type="text" name="" id="barcode" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2">
                       {{-- <button class="btn btn-primary btn-sm">show</button> --}}
                    </div>
                  </div>
                  <div class="card mt-2">
                      <div class="card-header">
                          <b>product Dateils</b>
                          <button class="btn-primary btn-sm float-right" id="saveReturnItem">Add</button>
                       </div> 
                        <div class="card-body">
                            <form id="returnItemsData">
                                @csrf
                                <div class="return_item_err"></div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">supplier name</th>
                                                <th scope="col">product name</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Size</th>
                                                <th scope="col">Color</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="item_list">
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                      </div>
                  </div>
                </div>
            </div>
        </div>
           {{-- @foreach ($allSupliers as $returnItems) --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        {{-- <h3 class="card-title"> <b>{{ucwords($allSupliers->id)}}</b></h3> --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Item name</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Time</th>
                                  </tr>
                                </thead>
                                 @php
                                     $count =0
                                 @endphp
                                <tbody>
                                 @foreach ($returnItems as $list)
                                     <tr>
                                        <td>{{++$count}}</td>
                                        <td>{{$list->sub_category_id}}</td>
                                        <td>{{$list->qty}}</td>
                                        <td>{{$list->size}}</td>
                                        <td>{{$list->color}}</td>
                                        <td>{{$list->date}}</td>
                                        <td>{{$list->time}}</td>
                                     </tr>
                                 @endforeach
                                </tbody>
                              </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- @endforeach --}}
    </div>

    <div class="row">
        {{-- @foreach ($SubCategories as $categories) --}}
            
            <div class="col-sm-6 col-md-4 mt-1">
                <div class="card">
                    <div class="card-header">
                        {{-- <h3 class="card-title"> <b>{{ucwords($categories->category)}}</b></h3> --}}
                    </div>
                    <div class="card-body table-responsive p-0" style="height: 250px;">
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Image</th>
                                    <th>Sub category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                // $category_items = subCategoryItems($categories->category_id);   
                                // {{$count =0;}}
                            @endphp
                            <tbody>
                            {{-- @foreach ($category_items as $list)
                                <tr>
                                  <td>{{++$count}}</td>
                                  <td>
                                      {{-- <a href="{{asset('/storage/app/public/'.$list->sub_category_img)}}" target="_blank"> --}}
                                      {{-- <img src="{{asset('/storage/app/public/'.$list->sub_category_img)}}"  alt="image not found" srcset="" class="card-img-top img-thumbnail img-wh-40" style="cursor:pointer"></td>
                                      <td>{{ucwords($list->sub_category)}}</td>
                                    <td>
                                      <button type="button" class="btn btn-info btn-sm editsubCategoryBtn mr-1" value="{{$list->id}}"><i class="fas fa-edit"></i></button>
                                      <button type="button" class="btn btn-danger btn-sm deletesubCategoryBtn ml-1" value="{{$list->id}}"><i class="fas fa-trash"></i></button>
                                  </td>
                                </tr>
                            @endforeach --}} 
                            </tbody>                   
                         </table>
                    </div>
    
                </div>
            </div>
    
        {{-- @endforeach --}}
    
    </div>

    <table class="hide">
        <tbody id="item_row">
            <tr>
                <td id="count_item"></td>
    
                <td>
                    <input type="text"   class="form-control form-control-sm supplier_name" id="supplier_name" readonly >
                    <input type="hidden" name="supplier_id" id="supplier_id">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" id="sub_category" readonly >
                    <input type="hidden" name="sub_category_id"  id="sub_category_id">
                </td>
               
                <td>
                    <input type="text" id="qty" name="qty" value="1" class="form-control form-control-sm qty" min="1" value="0"readonly>
                </td>
                <td>
                    <input type="text"  name="size" class="form-control form-control-sm size" id="size" readonly>
                    {{-- <input type="hidden" name="size_id[]" class="size_id"> --}}
                </td>
                <td>
                    <input type="text"  name="color" class="form-control form-control-sm" id="color" readonly>
                    {{-- <input type="hidden" name="size_id[]" class="size_id"> --}}
                </td>
                
                <td>
                    <button type="button" class="btn btn-danger btn-flat btn-sm delete_item"><i class="far fa-window-close"></i></button>
                </td>
            </tr>
        </tbody>
    </table> 

@section('script')
<script>
    $(document).ready(function(){
        $(document).on('change','#barcode',function(){
            addItem();
        });
        // save funcation 
        $(document).on('click','#saveReturnItem',function(){
            // alert("call");
            saveReturnProduct();
        });
    });

    // function start 
        function addItem() {
            
            $('#item_list').append($('#item_row').html());
            // $("#item_list tr").find(".item").chosen();
        }

        $(document).on('change','#barcode', function () {
                const barcode_code = $(this).val();
                // var object = $(this);
                $.ajax({
                    type: "get",
                    url: "get-return-product-item/"+barcode_code,
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        $('#supplier_name').val(response.return_product.supplier_name);
                        $('#supplier_id').val(response.return_product.id);
                        $('#size').val(response.return_product.size);
                        $('#sub_category').val(response.return_product.sub_category);
                        $('#sub_category_id').val(response.return_product.sub_category_id);
                        $('#qty').val(response.return_product.qty);
                        $('#color').val(response.return_product.color);
                       
                    }
                });
                
            });

            function saveReturnProduct() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#returnItemsData")[0]);
            $.ajax({
                type: "post",
                url: "save-return-item",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    // console.log(response);
                    if (response.status === 400) {
                        $('#return_item_err').html('');
                        $('#return_item_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) {
                            $('#return_item_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                        });

                    } else {
                        $('#return_item_err').html('');
                        // $('#brandModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

</script>
@endsection
@endsection
