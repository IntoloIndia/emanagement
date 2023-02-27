@extends('layouts.common_modal')
@extends('layouts.app')
@section('page_title', 'Purchase Entry')
@section('style')

<link rel="stylesheet" media="print" href="{{asset('public/assets/css/print.css')}}" />
<style>

.form-control, .form-select {
    margin-bottom: 2px;
    padding: 1px 5px;
}

.chosen-container{
    width: 100%;
}

  #colorinput{
    border: none;
    background-color": "yellow";
  }

.barcode{
    length:100%;
    width:100%;
}

.popover-content {
  height: 180px;  
  width: 200px;  
}

/* textarea.popover-textarea {
   border: 0px;   
   margin: 0px; 
   width: 100%;
   height: 100%;
   padding: 0px;  
   box-shadow: none;
}

.popover-footer {
  margin: 0;
  padding: 8px 14px;
  font-size: 14px;
  font-weight: 400;
  line-height: 18px;
  background-color: #F7F7F7;
  border-bottom: 1px solid #EBEBEB;
  border-radius: 5px 5px 0 0;
}

a {
    padding: 0px 20px 20px 20px;
    float: left;
    vertical-align: middle;
    width: 100px;
    margin: 5px;
}  */


 
</style>
@endsection

@section('content-header')
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="m-0"><b>Purchase Invoice</b></h3>
            </div>
            <div class="col-sm-6">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                    <button type="button" id="purchaseEntry" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-plus"></i> Purchase Entry</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

{{-- product modal --}}
<div class="modal fade" id="purchaseEntryModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Purchase Invoice Entry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="purchaseEntryForm" action="{{url('admin/export-excel-data')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div id="purchase_entry_err"></div>
                        {{-- <div class="row">
                            <div class="col-md-6">
                                <input type="file"name="file" id="file" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary btn-sm">save product</button>
                                <a href="{{url('admin/import-data')}}">Excel download file</a>
                            </div>
                        </div> --}}

                        <div class="row">
                            <div class="col-md-12">

                                <div class="card">
                                    <div class="card-header"><b>Supplier</b></div>
                                    <div class="card-body">
                                        
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <select id="supplier_id" name="supplier_id" class="form-select form-select-sm" onchange="supplierDetail(this.value);">
                                                            <option selected disabled value="0">Supplier</option>                                          
                                                            @foreach ($suppliers as $list)
                                                            <option value="{{$list->id}}" state-type="{{$list->state_type}}"> {{ucwords($list->supplier_name)}} </option>
                                                            @endforeach
                                                        </select>                                                    
                                                    </div>
                                                    
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-12">
                                                        <textarea class="form-control" id="supplier_address" style="height: 70px;"  placeholder="Address" disabled readonly></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="text" name="supplier_code" id="supplier_code" class="form-control form-control-sm" placeholder="Supplier Code" readonly disabled>
                                                    </div>
                                                </div>
                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <input type="text"  name="gst_no"  id="gst_no" class="form-control form-control-sm" placeholder="GSTIN" readonly disabled>
                                                    </div>
                                                </div>
                                                <div class="row mt-1">
                                                    <div class="col-md-12">
                                                        <input type="text" name="bill_no"  id="bill_no" class="form-control form-control-sm" placeholder="Bill no">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="text"  name="payment_days"  id="payment_days" class="form-control form-control-sm" placeholder="Payment Days">
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <select id="category_id" name="category_id" class="form-select select_chosen_80" onchange="getSubCategoryByCategory(this.value);">
                                                                <option selected disabled value="0">Category</option>
                                                                @foreach ($categories as $list)
                                                                <option value="{{$list->id}}"> {{ucwords($list->category)}} </option>
                                                                @endforeach
                                                            </select>
                                                            <span class="input-group-text" style=" padding: 3px 5px 3px 5px;">
                                                                <i class="fas fa-plus cursor_pointer" id="categoryBtn"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <select id="sub_category_id" name="sub_category_id" class="form-select select_chosen_80">
                                                                <option selected disabled >Sub Category</option>
                                                            </select>
                                                            <span class="input-group-text" style=" padding: 3px 5px 3px 5px;">
                                                                <i class="fas fa-plus cursor_pointer" id="subCategoryBtn"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input type="date"  name="bill_date"  id="bill_date" class="form-control form-control-sm" placeholder="Bill Date">
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <select id="brand_id" name="brand_id" class="form-select select_chosen_80" >
                                                                <option selected disabled value="0">Brand</option>
                                                                @foreach ($brands as $list)
                                                                    <option value="{{$list->id}}"> {{ucwords($list->brand_name)}} </option>
                                                                @endforeach
                                                            </select>
                                                            <span class="input-group-text" style=" padding: 3px 5px 3px 5px;">
                                                                <i class="fas fa-plus cursor_pointer" id="addBrandBtn"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <select id="style_no_id" name="style_no_id" class="form-select select_chosen_80">
                                                                <option selected disabled >Style No</option>
                                                            </select>
                                                            <span class="input-group-text" style=" padding: 3px 5px 3px 5px;">
                                                                <i class="fas fa-plus cursor_pointer" id="styleNoBtn"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                               
                                            </div>

                                        </div>
    
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                {{-- <div class="card"> --}}
                                    {{--<div class="card-body">

                                         <div class="row">
                                            <div class="col-md-12">

                                                <div class="row">

                                                    <div class="col-md-3">
                                                        <div class="input-group">
                                                            <select id="category_id" name="category_id" class="form-select select_chosen_80" onchange="getSubCategoryByCategory(this.value);">
                                                                <option selected disabled value="0">Category</option>
                                                                @foreach ($categories as $list)
                                                                    <option value="{{$list->id}}"> {{ucwords($list->category)}} </option>
                                                                @endforeach
                                                            </select>
                                                            <span class="input-group-text" style=" padding: 3px 5px 3px 5px;">
                                                                <i class="fas fa-plus cursor_pointer" id="categoryBtn"></i>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="input-group">
                                                            <select id="sub_category_id" name="sub_category_id" class="form-select select_chosen_80">
                                                                <option selected disabled >Sub Category</option>
                                                            </select>
                                                            <span class="input-group-text" style=" padding: 3px 5px 3px 5px;">
                                                                <i class="fas fa-plus cursor_pointer" id="subCategoryBtn"></i>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="input-group">
                                                            <select id="category_id" name="category_id" class="form-select select_chosen_80" onchange="getSubCategoryByCategory(this.value);">
                                                                <option selected disabled value="0">Brand</option>
                                                                @foreach ($brands as $list)
                                                                    <option value="{{$list->id}}"> {{ucwords($list->brand_name)}} </option>
                                                                @endforeach
                                                            </select>
                                                            <span class="input-group-text" style=" padding: 3px 5px 3px 5px;">
                                                                <i class="fas fa-plus cursor_pointer" id="categoryBtn"></i>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="input-group">
                                                            <select id="style_no" name="style_no" class="form-select select_chosen_80">
                                                                <option selected disabled >Style No</option>
                                                            </select>
                                                            <span class="input-group-text" style=" padding: 3px 5px 3px 5px;">
                                                                <i class="fas fa-plus cursor_pointer" id="styleNoBtn"></i>
                                                            </span>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div> 

                                    </div>--}}

                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-6">
                                                    <b>Product</b>
                                                </div>
                                                {{-- <div class="col-6 d-flex justify-content-end">
                                                    <button class="btn btn-primary btn-sm"  id="addItemBtn"> Add New</button>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div class="card-body" id="product_section">
                                           <div class="row item_list" id="item_list">

                                            <div class="row">

                                                <div class="col-md-3">
                                                    <select id="color" name="color" class="form-select form-select-sm color_code select_chosen">
                                                        <option selected disabled >Color</option>
                                                        @foreach ($colors as $list)
                                                        <option value="{{$list->color}}">{{ucwords($list->color)}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div id="take_photo" class="take_photo mt-2">
                                                        {{-- <img class="card-img-top img-thumbnail after_capture_frame" src="{{asset('public/assets/images/user-img.jpg')}}" style="width: 60px; height:60px;" /> --}}
                                                        {{-- <img class="card-img-top img-thumbnail after_capture_frame" src="" style="width: 60px; height:60px;" /> --}}
                                                    </div>                                
                                                    <input type="hidden" name="product_image" id="product_image" class="product_image">
                                                    <div class="d-grid gap-2 mt-2">
                                                        <button class="btn btn-primary btn-sm captureLivePhotoBtn" type="button">Live Camera</button>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-9">
                                        
                                                    <div class="row ">
                                                        <div class="card">
                                                            <div class="card-body ">
                                                                {{-- <div class="row"> --}}
                                                                    
                                                                    {{-- <div class="col-md-12 table-responsive p-0"> --}}
                                                                        <table class="table">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <th>Size</th>
                                                                                    <td>XS <input type="hidden" name="xs_size" value="xs"></td>
                                                                                    <td>S <input type="hidden" name="s_size" value="s"></td>
                                                                                    <td>M <input type="hidden" name="m_size" value="m"></td>
                                                                                    <td>L <input type="hidden" name="l_size" value="l"></td>
                                                                                    <td>XL <input type="hidden" name="xl_size" value="xl"></td>
                                                                                    <td>XXL <input type="hidden" name="xxl_size" value="xxl"></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Qty</th>
                                                                                    <td><input type="text" id="xs_qty" name="xs_qty" class="form-control form-control-sm qty" placeholder="Qty"></td>
                                                                                    <td><input type="text" id="s_qty" name="s_qty" class="form-control form-control-sm qty" placeholder="Qty"></td>
                                                                                    <td><input type="text" id="m_qty" name="m_qty" class="form-control form-control-sm qty" placeholder="Qty"></td>
                                                                                    <td><input type="text" id="l_qty" name="l_qty" class="form-control form-control-sm qty" placeholder="Qty"></td>
                                                                                    <td><input type="text" id="xl_qty" name="xl_qty" class="form-control form-control-sm qty" placeholder="Qty"></td>
                                                                                    <td><input type="text" id="xxl_qty" name="xxl_qty" class="form-control form-control-sm qty" placeholder="Qty"></td>
                                                                                    
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Price</th>
                                                                                    <td><input type="text" rel="popover" id="xs_price" name="xs_price" class="form-control form-control-sm xs_price price example-popover" placeholder="Price" ></td>
                                                                                    <td><input type="text" rel="popover" id="s_price" name="s_price" class="form-control form-control-sm s_price price" placeholder="Price"  ></td>
                                                                                    <td><input type="text" rel="popover" id="m_price" name="m_price" class="form-control form-control-sm m_price price" placeholder="Price"  ></td>
                                                                                    <td><input type="text" rel="popover" id="l_price" name="l_price" class="form-control form-control-sm l_price price" placeholder="Price"  ></td>
                                                                                    <td><input type="text" rel="popover" id="xl_price" name="xl_price" class="form-control form-control-sm xl_price price" placeholder="Price"  ></td>
                                                                                    <td>
                                                                                        <input type="text" rel="popover" id="xxl_price" name="xxl_price" class="form-control form-control-sm xxl_price price" placeholder="Price"  >
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>MRP</th>
                                                                                    <td><input type="text" name="xs_mrp" class="form-control form-control-sm xs_mrp mrp" placeholder="MRP" value=""></td>
                                                                                    <td >
                                                                                        <input type="text" name="s_mrp" class="form-control form-control-sm s_mrp mrp" placeholder="MRP" value="">
                                                                                    </td>
                                                                                    <td ><input type="text" name="m_mrp" class="form-control form-control-sm m_mrp mrp" placeholder="MRP" value=""></td>
                                                                                    <td ><input type="text" name="l_mrp" class="form-control form-control-sm l_mrp mrp" placeholder="MRP" value=""></td>
                                                                                    <td ><input type="text" name="xl_mrp" class="form-control form-control-sm xl_mrp mrp" placeholder="MRP" value=""></td>
                                                                                    <td ><input type="text" name="xxl_mrp" class="form-control form-control-sm xxl_mrp mrp" placeholder="MRP" value=""></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Total</th>
                                                                                    <td colspan="3">
                                                                                        <div class="form-floating">
                                                                                            <input type="text" class="form-control" id="total_qty" value="0" readonly disabled>
                                                                                            <label for="floatingInputGrid">Quantity</label>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td colspan="3">
                                                                                        <div class="form-floating">
                                                                                            <input type="text" class="form-control" id="total_price" value="0" readonly disabled>
                                                                                            <label for="floatingInputGrid">Value</label>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                
                                                                            </tbody>
                                                                        </table>
                            
                                                                        
                                                                    {{-- </div> --}}

                                                                    

                                                                {{-- </div> --}}
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                        
                                            </div>

                                        </div>
                                        
                                    </div>

                                    {{-- <div class="row"> --}}
                                        {{-- <div class="mypopover-content ">
                                            <div class="card card-body" >
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <small  ><b>Total Qty</b> </small>
                                                        <input type="text" name="" id="total_qty" class="form-control form-control-sm" placeholder="QTY" >
                                                    </div>
                                                    <div class="col-md-3">
                                                        <small  ><b>Value</b> </small>
                                                        <input type="text" name="" id="total_price" class="form-control form-control-sm" placeholder="Value" >
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small  ><b>SGST</b> </small>
                                                        <input type="text" name="" id="total_sgst" class="form-control form-control-sm sgst" placeholder="SGST" >
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small  ><b>CGST</b> </small>
                                                        <input type="text" name="" id="total_cgst" class="form-control form-control-sm cgst" placeholder="CGST">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <small ><b>IGST</b> </small>
                                                        <input type="text" name="" id="total_igst" class="form-control form-control-sm igst" placeholder="IGST">
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    {{-- </div> --}}

                                    <div class="card-footer text-muted">
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                                            <button type="button" id="savePurchaseEntryBtn" class="btn btn-primary btn-sm ">Save </button>
                                        </div>
                                    </div>
                                        
                                </div>
                                {{-- </div> --}}
                                
                            </div>
                            <div class="div col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-6">
                                                <b>Details</b>
                                            </div>
                                            <div class="col-6">
                                                <div class="card-tools">
                                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                                                        <button type="button" class="btn  btn-sm" data-card-widget="collapse" title="Collapse" style="background-color: #ABEBC6;">
                                                          <i class="fas fa-minus"></i>
                                                        </button>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                    <div class="card-body table-responsive p-0 " style="height: 250px;" >
                                        <table class="table table-head-fixed text-nowrap" id="show_purchase_entry">
                                            {{-- <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Style</th>
                                                    <th>Color</th>
                                                    <th>QTY</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <tr>
                                                    <td>1</td>
                                                    <td>ABC-15-A</td>
                                                    <td>Red</td>
                                                    <td>1</td>
                                                    <td>1</td>
                                                </tr>
                                                
                                            </tbody> --}}
                                        </table>
                                    </div>
                                    <div class="card-footer text-muted">
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                                            <button type="button" id="viewPurchaseBtn" class="btn btn-info btn-sm "> View Purchase </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    {{-- <input type="hidden" name="admin_id" id="admin_id" value=""> --}}
                    {{-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="savePurchaseEntryBtn" class="btn btn-primary btn-sm ">Save </button>
                        <button type="button" id="updateProductBtn" class="btn btn-primary btn-sm hide">Update </button>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Delete User </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <h5>Are you sure?</h5>
                        <button type="button" id="yesDeleteProductBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                        <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                    <hr>
                </center>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="captureLivePhotoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Take Live Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="my_camera" class="card pre_capture_frame" ></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm float-end" onClick="takePhoto()">Take</button>
            </div>
        </div>
    </div>
</div>



{{-- camera modal end --}}

{{-- <div class="row mb-3 ">
    <div class="col-12">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
            <button type="button" id="purchaseEntry" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-plus"></i> Purchase Entry</button>
        </div>
    </div>
</div> --}}

<div class="row">


    <div class="col-md-5">
        <div class="card">

            <div class="card-header">
                <div class="row">
                    <div class="col-md-5 col-lg-5 col-xl-5">
                        <h3 class="card-title">Purchase</h3>
                    </div>
                    <div class=" col-md-6 col-lg-6 col-xl-6">
                        <select id="filter_supplier_id" name="filter_supplier_id" class="form-select form-select-sm">
                            <option selected disabled value="0">Supplier</option>                                          
                            @foreach ($suppliers as $list)
                            <option value="{{$list->id}}" state-type="{{$list->state_type}}"> {{ucwords($list->supplier_name)}} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class=" col-md-1 col-lg-1 col-xl-1">
                        {{-- <div class="card-tools">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                                <button type="button" class="btn btn-sm" data-card-widget="collapse" title="Collapse" style="background-color: #ABEBC6;">
                                  <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div> --}}
                        {{-- <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fas fa-minus"></i>
                          </button> --}}
                    </div>

                    
                </div>
            </div>

            <div class="card-body table-responsive p-0" style="height: 500px;" >
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Bill Date</th>
                            <th>Bill No</th>
                            <th>Supplier</th>
                            <th>Pay Days</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($purchases->isEmpty())
                            <div class="alert alert-warning text-light my-2" role="alert">
                                <span>State is not available to add new state click add button</span>
                            </div>
                        @else
                            {{$count = "";}}
                            @foreach ($purchases as $list)
                                <tr>
                                    <td>{{++$count}}</td>
                                    <td>{{date('d-m-Y', strtotime($list->bill_date))}}</td>
                                    <td>{{strtoupper($list->bill_no)}}</td>
                                    <td>{{ucwords($list->supplier_name)}}</td>
                                    <td>{{$list->payment_days}}</td>
                                    <td>
                                        {{-- <button type="button" class="btn btn-info btn-sm " value="{{$list->id}}"><i class="fas fa-eye"></i></button> --}}
                                        <button type="button" class="btn btn-success btn-sm generatePurchaseInvoice" value="{{$list->id}}"><i class="fas fa-file-invoice"></i></button>
                                        {{-- <button type="button" class="btn btn-danger btn-sm deleteBtn" module-type="{{MyApp::STATE}}" value="{{$item->id}}"><i class="fas fa-trash"></i></button> --}}
                                    </td>
                                </tr>
                            @endforeach
                        @endif 
                    </tbody>
                </table>
                {{-- <br>
                <div class="row">
                    <div class="col-md-12 table-responsive" style="height: 200px;">
                        <table class="table table-striped table-head-fixed" id="customer_list" >
                            
                        </table>    
                    </div>
                </div> --}}
        </div>
    </div>

   

    
   
    {{-- <div class="col-lg-9 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <b>Purchase</b>
            </div>
            <div class="card-body">
                <div class="table-responsive p-0" style="height: 600px;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                          <tr>
                            <th scope="col">Sno</th>
                            <th scope="col">Code</th>
                            <th scope="col">Supplier</th>
                            <th scope="col">Category</th>
                            <th scope="col">Sub category</th>
                            <th scope="col">Product</th>
                            <th scope="col">Purchaes Price</th>
                            <th scope="col">Sales Price</th>
                            <th scope="col">Size</th>
                            <th scope="col">Color</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        @php
                            $count=0;
                        @endphp
                        <tbody>
                          @foreach ($products as $list)
                              <tr>
                                <td>{{++$count}}</td>
                                <td>{{$list->product_code}}</td>
                                <td>{{ucwords($list->supplier_name)}}</td>
                                <td>{{ucwords($list->category)}}</td>
                                <td>{{ucwords($list->sub_category)}}</td>
                                <td>{{ucwords($list->product)}}</td>
                                <td>{{$list->purchase_price}} </td>
                                <td>{{$list->sales_price}} </td>
                                <td>{{$list->size}}</td>
                                <td><input type="text"  disabled style="width:15px; height:15px; background-color:{{$list->color}};" id="colorinput"></td> 
                                <td>
                                    <button type="button" class="btn btn-info btn-sm editProductBtn mr-1" value="{{$list->id}}"><i class="fas fa-edit"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm deleteProductBtn ml-1" value="{{$list->id}}"><i class="fas fa-trash"></i></button>
                                </td>
                              </tr>
                          @endforeach
                          
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div> --}}



    
    {{-- <div class="col-md-3 ">
        <div class="card hide">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6"><b>Barcodes</b></div>
                    <div class="col-md-6">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                            <button type="button" id="openBtn" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-print"></i> Preview</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body page" id="barcode_body" >
                @foreach ($products as $list)
                    <div class="card" >
                        <div class="card-body pt-5">

                            <div class="row mb-2">
                                <span class="tect-center business_title text-center"><b>MANGALDEEP CLOTHS LLP</b></span>
                            </div>
                            <div class="row" >
                                <div class="col-md-7">
                                    <span class="product_detail" >Prod : Jeans</span> <br/>
                                    <span class="product_detail" >Sec : Super Slim (DD) J</span> <br/>
                                    <span class="product_detail" >Sty : MFT-28457-P</span> <br/>
                                    <span class="product_detail" >Clr : 134-Blue Black</span> <br/>
                                    <span class="product_detail" >Size : 34</span> <br/>
                                    <span class="product_detail" >MRP : 1250</span> <br/>
                                </div>
                                <div class="col-md-5">
                                    <img src="{{$list->barcode}}" class="barcode_image barcode" ><br/>
                                    <span class="product_detail"><b>{{$list->product_code}}</b></span> <br/>
                                </div>
                            </div>
                            <hr style="color:black">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="product_detail" ><b>Mktd By :</b> Abc Marketing Pvt Ltd</span> <br/>
                                    <span class="product_detail" ><b>Plot No :</b> 84 Central Road Shashtri Nagar Bhopal 482007</span> <br/>
                                </div>
                            </div>
                                
                        </div>
                    </div>
                @endforeach
            </div> 
           
        </div>
    </div> --}}


</div>

<div class="hide">
    <div id="item_row">

        {{-- <div class="row">

            <div class="col-md-3">
                <select id="color" name="color" class="form-select form-select-sm color_code ">
                    <option selected disabled >Color</option>
                    @foreach ($colors as $list)
                    <option value="{{$list->color}}">{{ucwords($list->color)}}</option>
                    @endforeach
                </select>
                <div id="take_photo" class="take_photo mt-2">
                    <img class="card-img-top img-thumbnail after_capture_frame" src="{{asset('public/assets/images/user-img.jpg')}}" style="width: 60px; height:60px;" />
                </div>                                
                <input type="hidden" name="product_image" id="product_image" class="product_image">
                <div class="d-grid gap-2 mt-2">
                    <button class="btn btn-primary btn-sm captureLivePhotoBtn" type="button">Live Camera</button>
                </div>
            </div>
            
            <div class="col-md-8">
    
                <div class="row ">
                    <div class="card">
                        <div class="card-body ">
                            <div class="row">
                                
                                <div class="col-md-12 table-responsive p-0">
                                    <table class="table table-head-fixed text-nowrap">
                                        <tbody>
                                            <tr>
                                                <th>Size</th>
                                                <td>XS</td>
                                                <td>S</td>
                                                <td>M</td>
                                                <td>L</td>
                                                <td>XL</td>
                                                <td>XXL</td>
                                            </tr>
                                            <tr>
                                                <th>Qty</th>
                                                <td><input type="text" name="xs_qty[]" class="form-control form-control-sm" placeholder="Qty"></td>
                                                <td><input type="text" name="s_qty[]" class="form-control form-control-sm" placeholder="Qty"></td>
                                                <td><input type="text" name="m_qty[]" class="form-control form-control-sm" placeholder="Qty"></td>
                                                <td><input type="text" name="l_qty[]" class="form-control form-control-sm" placeholder="Qty"></td>
                                                <td><input type="text" name="xl_qty[]" class="form-control form-control-sm" placeholder="Qty"></td>
                                                <td><input type="text" name="xxl_qty[]" class="form-control form-control-sm" placeholder="Qty"></td>
                                                
                                            </tr>
                                            <tr>
                                                <th>Price</th>
                                                <td><input type="text" rel="popover" name="xs_price[]" class="form-control form-control-sm xs_price example-popover" placeholder="Price" value="" ></td>
                                                <td><input type="text" rel="popover" name="s_price[]" class="form-control form-control-sm s_price" placeholder="Price" value="" ></td>
                                                <td><input type="text" rel="popover" name="m_price[]" class="form-control form-control-sm m_price" placeholder="Price" value="" ></td>
                                                <td><input type="text" rel="popover" name="l_price[]" class="form-control form-control-sm l_price" placeholder="Price" value="" ></td>
                                                <td><input type="text" rel="popover" name="xl_price[]" class="form-control form-control-sm xl_price" placeholder="Price" value="" ></td>
                                                <td>
                                                    <input type="text" rel="popover" name="xxl_price[]" class="form-control form-control-sm xxl_price" placeholder="Price" value="" >
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>MRP</th>
                                                <td><input type="text" name="xs_mrp[]" class="form-control form-control-sm xs_mrp" placeholder="MRP" value=""></td>
                                                <td >
                                                    <input type="text" name="s_mrp[]" class="form-control form-control-sm s_mrp" placeholder="MRP" value="">
                                                </td>
                                                <td ><input type="text" name="m_mrp[]" class="form-control form-control-sm m_mrp" placeholder="MRP" value=""></td>
                                                <td ><input type="text" name="l_mrp[]" class="form-control form-control-sm l_mrp" placeholder="MRP" value=""></td>
                                                <td ><input type="text" name="xl_mrp[]" class="form-control form-control-sm xl_mrp" placeholder="MRP" value=""></td>
                                                <td ><input type="text" name="xxl_mrp[]" class="form-control form-control-sm xxl_mrp" placeholder="MRP" value=""></td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>

                                    <div class="mypopover-content hide">
                                        <div class="card card-body" >
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <small  ><b>SGST</b> </small>
                                                    <input type="text" name="" class="form-control form-control-sm sgst" placeholder="SGST" >
                                                </div>
                                                <div class="col-md-4">
                                                    <small  ><b>CGST</b> </small>
                                                    <input type="text" name="" class="form-control form-control-sm cgst" placeholder="CGST">
                                                </div>
                                                <div class="col-md-4">
                                                    <small ><b>IGST</b> </small>
                                                    <input type="text" name="" id="" class="form-control form-control-sm igst" placeholder="IGST">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
    
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-flat btn-sm delete_item"><i class="far fa-window-close"></i></button>
            </div>
        </div> --}}

    </div>
   
</div>


{{-- <div class="hide">
    <div id="mypopover-content">
      <p>This is the custom popover html content that should be inserted into my example popover</p>
      <button type="button" class="btn btn-primary">and the button as well</button>
    </div>
</div> --}}

{{-- <div class="row">
    <div class="col-12">
        <div class="card-box">
            <div class="header-title"> <a href="#" class="btn btn-info btn-sm" onclick="printDiv('printableArea')" >
                <i class="fa fa-print"></i>
                Print
            </a>
        </div>
        <div class="panel-body" id="printableArea">
            @foreach($products as $product)
            <div class="col-md-2" style="padding: 10px; border: 1px solid #adadad; " align="center">
                <p>{{$product->name}}</p>
                <?php echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($product->code, "c128A",1,33,array(1,1,1), true) . '"   />'; ?>
                <br>
                <small style="font-size: 8px !important;"><b>{{$product->code}}</b></small>
                <p style="line-height: 12px !important; font-size: 8px !important;">
                    <b>Price: {{$product->sale_price}} </b>
                </p>
            </div>
            @endforeach     
        </div>
    </div>
</div> --}}



<section>
    <div id="newcontent">
        <div class="modal fade" id="generateBarcodeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Barcodes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="show_barcode_body" >
                        
                    </div>
                    <div class="modal-footer">
                        <img src="" class=" " ><br/>
                        <button type="button" id="printBtn" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-print"></i> Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection

@section('script')

<script>

   
	
	

	// function saveSnap(){
	//     var base64data = $("#product_image").val();
    //     alert(base64data);
    //     $.ajax({
    //         type: "POST",
    //         dataType: "json",
    //         url: "capture_image_upload.php",
    //         data: {image: base64data},
    //         success: function(data) { 
    //             alert(data);
    //         }
    //     });
    // }

    $(document).ready(function () {

        $(".select_chosen_80").chosen({ width: '90%' });
        $(".select_chosen").chosen({ width: '100%' });

            Webcam.set({
                width: 450,
                height: 287,
                image_format: 'jpeg',
                jpeg_quality: 90
            });	 
            Webcam.attach( '#my_camera' );

            $(document).on('click','#purchaseEntry', function (e) {
                e.preventDefault();
                $('#purchaseEntryModal').modal('show');
                $('#purchase_entry_err').html('');
                $('#purchase_entry_err').removeClass('alert alert-danger');
                $("#purchaseEntryForm").trigger("reset"); 
                $("#supplier_id").chosen({ width: '100%' });
            
                $('#savePurchaseEntryBtn').removeClass('hide');
                $('#updatePurchaseEntryBtn').addClass('hide');
            });
            
           
            $(document).on('click','#addBrandBtn',function(e)
            {
                e.preventDefault();
                $('#brandModal').modal('show');
                $('#brand_err').html('');
                $('#brand_err').removeClass('alert alert-danger');
                $('#brandForm').trigger('reset');
                $('#saveBrandBtn').removeClass('hide');
                $('#updateBrandBtn').addClass('hide');
            });

            $(document).on('click','#saveBrandBtn', function (e) {
                e.preventDefault();
                // alert('dd')
                saveBrand();
                
            });
            $(document).on('click','.editBrandBtn', function (e) {
                e.preventDefault();
                const brand_id = $(this).val();
                editDepartment(brand_id);
            });

            $(document).on('click','#updateBrandBtn', function (e) {
                e.preventDefault();
                const brand_id = $(this).val();
                updateDepartment(brand_id);
            });

            $(document).on('click','.deleteBrandBtn', function (e) {
                e.preventDefault();
                const brand_id = $(this).val();
                // alert(brand_id)
                $('#deleteBrandModal').modal('show');
                $('#yesdeleteBrandBtn').val(brand_id);
            });

            $(document).on('click','#yesdeleteBrandBtn', function (e) {
                e.preventDefault();
                const brand_id = $(this).val();
                deleteBrand(brand_id);
            });


            $(document).on('click','#addItemBtn', function (e) {
                e.preventDefault();

                // var supplier_id = $('#supplier_id').find("option:selected").attr('state-type');;
                var supplier_id = $('#purchaseEntryModal').find('#purchaseEntryForm').find('#supplier_id').find("option:selected").val();
                var bill_no = $('#purchaseEntryModal').find('#purchaseEntryForm').find('#bill_no').val();
                var category_id = $('#purchaseEntryModal').find('#purchaseEntryForm').find('#category_id').find("option:selected").val();
                var sub_category_id = $('#purchaseEntryModal').find('#purchaseEntryForm').find('#sub_category_id').find("option:selected").val();
                var style_no = $('#purchaseEntryModal').find('#purchaseEntryForm').find('#style_no').find("option:selected").val();

                // if (supplier_id == 0) {
                //     alert('Please select first supplier.');
                //     return false;
                // }

                // if (bill_no == 0) {
                //     alert('Please enter bill no.');
                //     return false;
                // }

                // if (category_id == 0) {
                //     alert('Please select first category.');
                //     return false;
                // }

                // if (sub_category_id == 0) {
                //     alert('Please select first sub category.');
                //     return false;
                // }

                // if (style_no == 0) {
                //     alert('Please select first style no.');
                //     return false;
                // }

                addItem();

                // $(".product_code").focus();
            });

            $(document).on("click",".delete_item", function(){

                // if($("#item_list tr").length == 1)
                // {
                //     alert("Order must have at least 1 item.");
                //     return false;
                // }
                $(this).parent().parent().remove();
            });

            $(document).on('keyup','.qty', function () {
                calculateQtyPrice();
            });

            $(document).on('keyup','.price', function () {
                calculateQtyPrice();
            });
            
            
            $(document).on('click','.captureLivePhotoBtn', function (e) {
                e.preventDefault();
                $('#captureLivePhotoModal').modal('show');
            });

            $(document).on("focusout","#bill_no", function(e){
                var supplier_id = $('#supplier_id').val();
                var bill_no = $('#bill_no').val();

                getPurchaseEntry(supplier_id, bill_no);
            });

           

            $(document).on('click','#savePurchaseEntryBtn', function (e) {
                e.preventDefault();
                // let productCode = Math.floor((Math.random() * 1000000) + 1);
                // alert(productCode);

                // savePurchaseEntry();
                validateForm();
            });

            $(document).on('change','#category_id', function (e) {
                e.preventDefault();
                const category_id = $(this).val();
                getSubCategoryByCategory(category_id);
                
            });

            $(document).on('change','.color_code', function (e) {
                e.preventDefault();
                const color_code = $(this).val();
                // const color = $(this).val();
                // alert(color);
                var object = $(this);
                $.ajax({
                    type: "get",
                    url: "get-color_code/"+ color_code,
                    dataType: "json",
                    success: function (response) {
                        // console.log(response);
                        $(object).parent().parent().find(".color_name").val(response.color.color);
                        // $(object).parent().parent().find("#color_name").val(response.color.color).css("background-color".color.color);
            
                    }
                });
                
            });
            
            $(document).on('click','.editProductBtn', function (e) {
                e.preventDefault();
                const product_id = $(this).val();
                // alert(product_id);
                editProduct(product_id);
            });

            $(document).on('click','#updateProductBtn', function (e) {
                e.preventDefault();
                const product_id = $(this).val();
                // alert(product_id);
                updateProduct(product_id);
            });
            
            $(document).on('click','.deleteProductBtn', function (e) {
                e.preventDefault();
                const product_id = $(this).val();
                // alert(product_id);
                $('#deleteProductModal').modal('show');
                $('#yesDeleteProductBtn').val(product_id);
            });

            $(document).on('click','#yesDeleteProductBtn', function (e) {
                e.preventDefault();
                const product_id = $(this).val();
                // alert(product_id)
                deleteProduct(product_id);
            });
          

            $(document).on('click','#openBtn', function (e) {
                e.preventDefault();

                var modal_data = $('#barcode_body').html();
                $('#show_barcode_body').html('');
                $('#show_barcode_body').append(modal_data);
                $('#generateBarcodeModal').modal('show');
                
                // getBarcode();
            });


            $(document).on('click','#printBtn', function (e) {
                e.preventDefault();
                // const product_id = $(this).val();

                // $(".business_title").css({"font-size":"60px"});
                // $(".product_detail").css({"font-size":"40px"});
                // $(".barcode_image").css({"height":"250px", "width":"400px"});

                const png_target = document.getElementById('show_barcode_body');

                html2canvas(png_target).then( (canvas)=>{
                    const base64image = canvas.toDataURL('image/png');

                    var anchor = document.createElement('a');
                    anchor.setAttribute("href", base64image);
                    anchor.setAttribute("download", "my-image.png");
                    alert(base64image);
                })

                // const canvas = document.getElementById('show_barcode_body');
                // const img    = canvas.toDataURL('image/png');
                // document.getElementById('existing-image-id').src = img

                // printBarcode();
            });

          
            
            // $(document).on("focusin","[rel=popover]", function(e){
            //     var price = parseFloat($(this).val());
            //     calculateGst( $(this), price );
            //     $(this).parent().parent().parent().parent().parent().find('.mypopover-content').show();
            // });
            // $(document).on("focusout","[rel=popover]", function(e){
            //     $(this).parent().parent().parent().parent().parent().find('.mypopover-content').hide();

            // });

            // $(document).on('keyup','.xs_price', function () {
            //     var price = parseFloat($(this).val());
            //     calculateGst( $(this), price );
            // });

            // $(document).on('keyup','.s_price', function () {
            //     var price = parseFloat($(this).val());
            //     calculateGst( $(this), price );
            // });

            // $(document).on('keyup','.m_price', function () {
            //     var price = parseFloat($(this).val());
            //     calculateGst( $(this), price );
            // });
            // $(document).on('keyup','.l_price', function () {
            //     var price = parseFloat($(this).val());
            //     calculateGst( $(this), price );
            // });
            // $(document).on('keyup','.xl_price', function () {
            //     var price = parseFloat($(this).val());
            //     calculateGst( $(this), price );
            // });
            // $(document).on('keyup','.xxl_price', function () {
            //     var price = parseFloat($(this).val());
            //     calculateGst( $(this), price );
            // });

            $(document).on('click','#categoryBtn', function () {
                $('#categoryModal').modal('show');
            });
            // save category of purchase entry
            $(document).on('click','#saveCategoryBtn', function (e) {
                e.preventDefault();
                saveCategory();
            });
          
            $(document).on('click','#subCategoryBtn', function () {
                $('#subCategoryModal').modal('show');
            });
              // save sub category
            $(document).on('click','#savesubCategoryBtn', function (e) {
                e.preventDefault();
                saveSubCategory();
            });

            $(document).on('click','#styleNoBtn', function () {
                $('#styleNoModal').modal('show');
            });
            // save style no
            $(document).on('click','#saveStyleNoBtn', function (e) {
                e.preventDefault();
                manageStyleNo();
            });

          

           
        });
            

            $(document).on('click','.generatePurchaseInvoice', function (e) {
                e.preventDefault();
                generatePurchaseInvoice();
            });

          

            // $(document).on("click",".price", function(e){
                // e.preventDefault();

                // var content = document.getElementById('mypopover-content');
                // $('body').popover({
                //     selector: '[rel=popover]',
                //     trigger: 'click',
                //     content : content,
                //     placement: "bottom",
                //     html: true
                // })

            // });

            // $(document).on('keyup','#base_amount', function () {
            //     calculateGst($(this));
            // });
           

        });

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

        function generatePurchaseInvoice() {  

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




        
    
        
    </script>
    
@endsection