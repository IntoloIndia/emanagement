{{-- product modal --}}
<div class="modal fade" id="purchaseEntryModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Purchase Invoice Entry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="purchaseEntryForm" action="{{url('admin/export-excel-data')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div id="purchase_entry_err"></div>
                        
                        <div class="row">
                            <div class="col-md-12">

                                <div class="card">
                                    <div class="card-header"><b>Supplier</b></div>
                                    <div class="card-body">
                                        
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        {{-- <select id="supplier_id" name="supplier_id" class="form-select form-select-sm" onchange="supplierDetail(this.value);"> --}}
                                                        <select id="supplier_id" name="supplier_id" class="form-select form-select-sm" >
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
                                    <div class="card-body table-responsive" style="height: 350px;" >
                                        <table class="table table-head-fixed text-nowrap" id="show_purchase_entry">
                                            
                                        </table>

                                    </div>
                                    {{-- <div class="card-footer text-muted">
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                                            <button type="button" id="viewPurchaseBtn" class="btn btn-info btn-sm "> View Purchase </button>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>

                            <div class="col-md-8">
                                {{-- <div class="card"> --}}
                                    
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

                                                    <div class="input-group">
                                                        <select id="color" name="color" data-placeholder='Select color' class="form-select form-select-sm color_code select_chosen_70">
                                                            <option selected disabled >Color</option>
                                                            @foreach ($colors as $list)
                                                            <option value="{{$list->color}}">{{ucwords($list->color)}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="input-group-text" style=" padding: 3px 5px 3px 5px;">
                                                            <i class="fas fa-plus cursor_pointer" id="addNewColorBtn"></i>
                                                        </span>
                                                    </div>

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
                                        
                                                    {{-- <div class="row "> --}}
                                                        <div class="card">
                                                            <div class="card-body ">
                                                                    
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
                                                                        
                                                                    </tbody>
                                                                </table>
                            
                                                            </div>
                                                        </div>
                                                        
                                                    {{-- </div> --}}
                                                </div>
                                        
                                            </div>

                                            
                                        </div>
                                        <div class="row">
                                            <div class="card card-body" >
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <small  ><b>Qty</b> </small>
                                                        <input type="text" name="" id="total_qty" class="form-control form-control-sm" placeholder="QTY" readonly disabled>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <small  ><b>Value</b> </small>
                                                        <input type="text" name="" id="total_price" class="form-control form-control-sm" placeholder="Value" readonly disabled>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small  ><b>Discount</b> </small>
                                                        <input type="text" name="discount" id="discount" class="form-control form-control-sm" placeholder="Discount" value="0">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <small  ><b>Taxable</b> </small>
                                                        <input type="text" name="" id="taxable" class="form-control form-control-sm" placeholder="Taxable" value="0" readonly disabled>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <small  ><b>SGST</b> </small>
                                                        <input type="text" name="" id="total_sgst" class="form-control form-control-sm sgst" placeholder="SGST" value="0"  readonly disabled>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <small  ><b>CGST</b> </small>
                                                        <input type="text" name="" id="total_cgst" class="form-control form-control-sm cgst" placeholder="CGST" value="0" readonly disabled>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <small ><b>IGST</b> </small>
                                                        <input type="text" name="" id="total_igst" class="form-control form-control-sm igst" placeholder="IGST" value="0" readonly disabled>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <small ><b>Amount</b> </small>
                                                        <input type="text" name="" id="total_amount" class="form-control form-control-sm total_amount" placeholder="Amount" readonly disabled>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                    </div>

                                    {{-- <div class="row"> --}}
                                        {{-- <div class="mypopover-content "> --}}
                                            {{-- <div class="card card-body" >
                                                <div class="row">
                                                    <div class="col-md-1">
                                                        <small  ><b>Qty</b> </small>
                                                        <input type="text" name="" id="total_qty" class="form-control form-control-sm" placeholder="QTY" >
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small  ><b>Value</b> </small>
                                                        <input type="text" name="" id="total_price" class="form-control form-control-sm" placeholder="Value" >
                                                    </div>
                                                    <div class="col-md-1">
                                                        <small  ><b>Dis.</b> </small>
                                                        <input type="text" name="" id="total_discount" class="form-control form-control-sm" placeholder="Discount" >
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small  ><b>SGST</b> </small>
                                                        <input type="text" name="" id="total_sgst" class="form-control form-control-sm sgst" placeholder="SGST" >
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small  ><b>CGST</b> </small>
                                                        <input type="text" name="" id="total_cgst" class="form-control form-control-sm cgst" placeholder="CGST">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small ><b>IGST</b> </small>
                                                        <input type="text" name="" id="total_igst" class="form-control form-control-sm igst" placeholder="IGST">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <small ><b>Amount</b> </small>
                                                        <input type="text" name="" id="total_amount" class="form-control form-control-sm total_amount" placeholder="Amount">
                                                    </div>
                                                </div>
                                            </div> --}}
                                        {{-- </div> --}}
                                    {{-- </div> --}}

                                    <div class="card-footer ">
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                                            <button type="button" id="savePurchaseEntryBtn" class="btn btn-primary btn-sm ">Save </button>
                                        </div>
                                    </div>
                                        
                                </div>
                                {{-- </div> --}}
                                
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

<div class="modal fade" id="generatePurchaseInvoiceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Purchase Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="show_purchase_invoice"> </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm float-end" onClick="printPurchaseInvoice()">Print</button>
            </div>
        </div>
    </div>
</div>  

{{-- excel data entry modal start --}}

<!-- Button trigger modal -->

  <!-- Modal -->
  <div class="modal fade" id="purchaseExcelModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Excel Purchase Entry</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="purchaseExcelEntryForm" action="{{url('admin/export-excel-data')}}" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                @csrf
                    <div id="purchase_entry_err"></div>
                        <div class="row">
                                <div class="col-md-6">
                                    <input type="file"name="file" id="file" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-primary btn-sm mt-1">Save</button>
                                </div>
                            </div>
                        </div>
                <div class="modal-footer">
                    <button class="btn btn-success btn-sm" href="{{url('admin/import-data')}}">Download Excel File</button>
                </div>
            </form>
         </div>
        </div>
    </div>
{{-- excel data entry modal end --}}



{{-- <div class='accordion accordion-flush' id='accordionFlushExample'>
    <table class='table table-striped'>
        <thead>
            <tr style='position: sticky;z-index: 1;'>
                <th>SN</th>
                <th>Style</th>
                <th>Color</th>
                
            </tr>
        </thead>
        <tbody >
            @php
               $count = 0; 
               $orders = 5;
               @endphp
               @for ($i = 0; $i < $orders; $i++)
                   
               
                <tr class='accordion-button collapsed' data-bs-toggle='collapse' data-bs-target='#collapse_{{$i}}' aria-expanded='false' aria-controls='flush-collapseOne'>
                    
                    <td>sfjsf</td>
                    <td>sfjsf</td>
                    <td>sfjsf</td>
                    
                </tr> 
                <tr>
                    <td colspan='3'>
                        <div id='collapse_{{$i}}' class='accordion-collapse collapse' aria-labelledby='flush-headingOne' data-bs-parent='#accordionFlushExample'>
                            <div class='accordion-body'>
                                <table class="table table-striped table-hover ">
                                    <thead>
                                        <tr>
                                            <th> SN</th>
                                            <th> Size</th>
                                            <th> Qty</th>
                                            <th> Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>XXL</td>
                                            <td>5</td>
                                            <td>1299</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
                @endfor                                               
            </tbody>
    </table>  
</div> --}}

