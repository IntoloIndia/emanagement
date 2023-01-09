@extends('layouts.app')
@section('page_title', 'Dashboard')
@section('content')

{{-- delete modal start  --}}

<div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h5 class="modal-title" id="exampleModalLabel"> Delete Brand </h5> --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <h5>Do you want print bill received</h5>
                        <button type="button" id="yesdeleteBrandBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                        <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                    {{-- <hr> --}}
                </center>
            </div>
        </div>
    </div>
  </div>

{{-- delete modal end  --}}


<!-- Button trigger modal -->
    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Launch static backdrop modal
    </button> --}}
    
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Invoice</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12 table-responsive p-0" style="height: 550px;">
                            <table class="table table-head-fixed">
                                <thead>
                                    <tr>
                                        <th scope="col">Sno</th>
                                         <th scope="col">Name</th> 
                                         <th scope="col">Bill no</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Print</th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 0;
                                    @endphp
                                     @foreach ($customers_billing as $item)
                                    <tr>
                                        <td>{{++$count}}</td>
                                        <td>{{ucwords($item->customer_name)}}</td>
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->total_amount}}</td>
                                        <td>{{$item->bill_date}}</td>
                                        <td>  
                                            {{-- <button type="button" class="btn btn-secondary btn-flat btn-sm editOrderBtn" value="{{$list->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Order"><i class="far fa-edit"></i></button> --}}
                                            {{-- <button type="button" class="btn btn-info btn-flat btn-sm orderDetailBtn" value="{{$item->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="View Order"><i class="far fa-eye"></i></button> --}}
                                             <button type="button" class="btn btn-success btn-flat btn-sm orderInvoiceBtn" value="{{$item->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice"><i class="fas fa-file-invoice"></i></button>
                                            {{-- <button type="button" class="btn btn-danger btn-flat btn-sm" value="{{$item->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancel Order"><i class="fas fa-ban"></i></button> --}}
                                          </td>
                                    </tr>
                                    @endforeach 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            {{-- <button type="button" class="btn btn-primary">Understood</button> --}}
            </div>
        </div>
        </div>
    </div>


{{-- <div class="row"> --}}
    {{-- <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <b>Billing</b>
            </div>
            <div class="card-body">
            <form id="orderForm">
                    @csrf
                <div class="order_err"></div>
                <div class="row"> --}}
                    {{-- <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <b>Customer Details</b>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                         <label for="moblie_no" class="form-label" >Moblie no</label>
                                     <input type="number"  class="form-control form-control-sm " id="mobile_no" name="mobile_no" minlength="10" maxlength="10" required id="moblie_no" placeholder="mobile number">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="name" class="form-label">Customer name</label>
                                        <input type="text"  class="form-control form-control-sm" id="customer_name" required name="customer_name" placeholder="Enter name">
                                    </div>
                                    <div class="col-md-1">
                                        <label for="moblie_no" class="form-label" >DOB</label>
                                         <input type="number"  class="form-control form-control-sm" name="birthday_date" id="birthday_date" required id="days" min="1" placeholder="date of brith">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="moblie_no" class="form-label" >Months</label>
                                        <select class="form-select form-select-sm" name="month_id" id="month_id" style="height:30px">
                                        <option selected>Select...</option>
                                            @foreach ($months as $item)
                                                <option value="{{$item->id}}">{{$item->month}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label" >Anniversary</label>
                                        <input type="date" name="anniversary_date" id="anniversary_date"  class="form-control form-control-sm ">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Total Points</label>
                                        <input type="text" id="total_points" class="form-control form-control-sm" value="0" disabled>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                         <div class="col-md-2 col-sm-12">
                                            <div class="form-check state_type">
                                                <input class="form-check-input " type="radio" name="state_type" value="{{MyApp::WITH_IN_STATE}}" id="with_in_state" checked>
                                                <label class="form-check-label" for="flexRadioDefault1">With in State</label>
                                            </div>
                                        </div>  
                                    <div class="col-md-2 col-sm-12">
                                        <div class="form-check state_type">
                                            <input class="form-check-input " type="radio" name="state_type" value="{{MyApp::INTER_STATE}}"  id="inter_state" >
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                Inter State
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="city_id" id="city_id" class="form-select" >
                                            <option selected disabled>City</option>
                                            @foreach($cities as $item)
                                                <option value="{{$item->id}}">{{ucwords($item->city)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="gst_no" id="gst_no" placeholder="GST NO"  class="form-control form-control-sm ">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="cupan_code" id="cupan_code" placeholder="cupan code"  class="form-control form-control-sm ">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <b>Credit Notes</b>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" style="max-height: 100px;">
                                    <table class="table">
                                        <thead>
                                          <tr>
                                           <th scope="col">#</th>
                                           <th scope="col">Name</th>
                                           <th scope="col">Bill no</th>
                                           <th scope="col">Date</th>
                                           {{-- <th scope="col">Time</th> --}}
                                           {{-- <th scope="col">Action</th>
                                          </tr>
                                        </thead>
                                         @php  
                                             $count = 0;
                                         @endphp
                                        <tbody>
                                         @foreach ($sales_return_data  as $item)
                                             <tr>
                                                <td>{{++$count}}</td>
                                                <td>{{ucwords($item->customer_name)}}</td>
                                                <td>{{$item->bill_id}}</td>
                                                <td>{{date('d-m-Y',strtotime($item->create_date))}}</td>
                                                {{-- <td>{{$item->create_time}}</td> --}}
                                                {{-- <td> --}}
                                                    {{-- <button type="button" class="btn btn   -success btn-flat btn-sm returnproductBtn" value="{{$item->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice"><i class="fas fa-file-invoice"></i></button> --}}
                                                     {{-- <button class="btn btn-success btn-sm" onclick="alert('call')">Act</button>
                                                    <button class="btn btn-danger btn-sm">Deact</button> --}}
                                                    {{-- <button type="button" class="btn btn-success btn-flat btn-sm returnproductBtn" value="{{$item->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice"><i class="fas fa-file-invoice"></i></button> --}}
                                                 {{-- </td>
                                             </tr>
                                         @endforeach 
                                        </tbody>
                                      </table>
                                </div>
                            </div>
                        </div>
                    </div> --}} 
                    {{-- <div class="col-md-2">
                        <div class="mb-2">
                             <label for="moblie_no" class="form-label" >Moblie no</label>
                            <input type="number"  class="form-control form-control-sm " id="mobile_no" name="mobile_no" minlength="10" maxlength="10" required id="moblie_no" placeholder="mobile number">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-2">
                            <label for="name" class="form-label">Name</label>
                            <input type="text"  class="form-control form-control-sm" id="customer_name" required name="customer_name" placeholder="Enter name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-5">
                                    <label for="moblie_no" class="form-label" >DOB</label> 
                                <input type="number"  class="form-control form-control-sm" name="birthday_date" id="birthday_date" required id="days" min="1" placeholder="date of brith">
                            </div>
                            <div class="col-6">
                                <label for="moblie_no" class="form-label" >Months</label>
                                <select class="form-select form-select-sm" name="month_id" id="month_id" style="height:30px">
                                    <option selected>Select...</option>
                                    @foreach ($months as $item)
                                        <option value="{{$item->id}}">{{$item->month}}</option>
                                    @endforeach
                                  </select>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="row mb-2">
                        <div class="col-md-2">
                            <label class="form-label" >Anniversary</label>
                            <input type="date" name="anniversary_date" id="anniversary_date"  class="form-control form-control-sm ">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Total Points</label>
                            <input type="text" id="total_points" class="form-control form-control-sm" value="0" disabled>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row mb-2">
                            <div class="col-md-3 col-sm-12">
                                <div class="form-check state_type">
                                <input class="form-check-input " type="radio" name="state_type" value="{{MyApp::WITH_IN_STATE}}" id="with_in_state" checked>
                                <label class="form-check-label" for="flexRadioDefault1">With in State</label>
                            </div>
                            </div>  
                            <div class="col-md-3 col-sm-12">
                                <div class="form-check state_type">
                                    <input class="form-check-input " type="radio" name="state_type" value="{{MyApp::INTER_STATE}}"  id="inter_state" >
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Inter State
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="city_id" id="city_id" class="form-select" >
                                    <option selected disabled>City</option>
                                    @foreach($cities as $item)
                                        <option value="{{$item->id}}">{{ucwords($item->city)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="gst_no" id="gst_no" placeholder="GST NO"  class="form-control form-control-sm ">
                            </div>
                        </div>
                    </div>
                   
                </div> --}}
                   
                {{-- </div> --}}
            {{-- <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-2">
                                    <b>Items</b>
                                </div>                           
                                <div class="col-3">
                                    {{-- <input type="text" name="product_code" id="product_code" class="form-control form-control-sm"> --}}
                                    
                                {{-- </div>                           
                                <div class="col-md-7 ">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                                        <button class="btn btn-primary btn-sm  float-right"  id="addItemBtn"> Add item</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body"style="max-height:400px;">
                           <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="table-responsive" style="max-height: 250px">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sno</th>
                                            <th scope="col">Emp</th>
                                            <th scope="col">Code</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Size</th>
                                            <th scope="col">MRP</th>
                                            <th scope="col">Dis.</th>
                                            <th scope="col" class="sgst_show_hide">SGST</th>
                                            <th scope="col" class="cgst_show_hide">CGST</th>
                                            <th scope="col" class="igst_show_hide hide">IGST</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Delete</th>
                                        </tr>
                                    </thead> --}}
                                    {{-- <tbody id="item_list">
    
                                    </tbody>
                                </table>  
                                </div>
                            </div>
                           </div>
                        </div>
                        <div class="card-footer ">
                            <div class="row">
                                <div class="col-md-10 text-end">
                                    <b>Total Amount :</b>
                                </div>
                                <div class="col-md-2 justify-content-end">
                                    <input type="text" name="" class="form-control form-control-sm" id="item_total_amount" value="0" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 text-end">
                                    <b>Discount :</b>
                                </div>
                                <div class="col-md-2 justify-content-end">
                                    <input type="text" name="" id="total_discount" class="form-control form-control-sm" value="0" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 text-end">
                                    <b>SGST :</b>
                                </div>
                                <div class="col-md-2 justify-content-end">
                                    <input type="text" name="" id="total_sgst" class="form-control form-control-sm " value="0" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 text-end">
                                    <b>CGST :</b>
                                </div>
                                <div class="col-md-2 justify-content-end">
                                    <input type="text" name="" id="total_cgst" class="form-control form-control-sm " value="0" readonly>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-10 text-end">
                                    <b>IGST :</b>
                                </div>
                                <div class="col-md-2 justify-content-end">
                                    <input type="text" name="" id="total_igst" class="form-control form-control-sm " value="0" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 text-end">
                                    <b>Points :</b>
                                </div>
                                <div class="col-md-2 justify-content-end">
                                    <input type="text" name="redeem_points" id="redeem_points" class="form-control form-control-sm" value="0">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 text-end">
                                    <b>Gross Amount :</b>
                                </div>
                                <div class="col-md-2 justify-content-end">
                                    {{-- <input type="text" name="" id="item_total_amount" class="form-control form-control-sm " value="0" readonly> --}}
                                    {{-- <input type="text" name="" id="gross_amount" class="form-control form-control-sm " value="0" readonly>
                                </div>
                            </div> --}}
                                {{-- <div class="row text-end">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6 ">
                                        <b>LESS DISCOUNT : </b>
                                        <b>SGST AMOUNT :</b><br/>
                                        <b>CGST AMOUNT :</b><br/>
                                        <b>IGST AMOUNT :</b><br/>
                                        <b>OTHER ADJ  :</b><br/>
                                    
                                        <b>G.TOTAL  :</b><br/>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <span id="item_gross_amount"></span><br/>
                                        <span id="item_less_amount"></span><br/>
                                        <span id="item_add_sgst" ></span><br/>
                                        <span id="item_add_cgst" ></span><br/>
                                        <span id="item_add_igst" ></span><br/>
                                        <span id="item_other_adj"></span><br/>
                                        
                                        <span id="item_total_amount"></span><br/>
                                    </div>
                                </div> --}}
                            {{-- <div class="row mt-1 hide" id="given_return_amount" >
                                <div class="col-md-4"></div>
                                <div class="col-md-4"></div>
                                <div class="col-md-2 text-end">
                                    <div><b>Given Amt :</b></div>
                                    <div class="mt-2" ><b >Return Amt :</b></div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <input type="text" name="" id="given_amount" class="form-control form-control-sm">
                                    <input type="text" name="" id="return_amount" class="form-control form-control-sm mt-1" readonly>
                                </div>
                            </div> --}}
    
                        {{-- </div>
                    </div>
                </div>
            </div> --}}
                    {{-- <button class="btn btn-primary btn-sm float-right" id="saveOrderBtn">save</button> --}}
                {{-- <input type="hidden" name="total_amount" id="total_amount" class="form-control form-control-sm " >
                <hr>
                <div class="row">
                    <div class="col-md-2">
                        <span>Payment :</span>
                    </div>
                </div> --}}
            {{-- <div class="row">
               
                    <div class="col-md-1">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input payment_mode" type="checkbox" name="payment_mode" id="online" value="{{MyApp::ONLINE}}">Online
                        </div>
                    </div>
                        <div class="col-md-2">
                            <input type="text" name="pay_online" id="online_payment" class="form-control form-control-sm hide" value="0" placeholder="amount">
                        </div>
              
                    <div class="col-md-1">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input payment_mode" type="checkbox" name="payment_mode" id="cash" value="{{MyApp::CASH}}">Cash
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="pay_cash" id="cash_payment" class="form-control form-control-sm hide" value="0" placeholder="amount">
                    </div>
               
                    <div class="col-md-1">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input payment_mode" type="checkbox" name="payment_mode" id="card" value="{{MyApp::CARD}}">Card
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="pay_card" id="card_payment" class="form-control form-control-sm hide"  value="0" placeholder="amount">
                    </div>
               
                    {{-- <div class="col-md-1">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input payment_mode" type="checkbox" name="payment_mode" id="credit" value="{{MyApp::CREDIT}}">Credit
                        </div>
                    </div>
                    <div class="col-md-2">
                            <input type="text" name="pay_credit" id="credit_payment" class="form-control form-control-sm hide"  value="0" placeholder="amount">
                        </div> --}}
                {{-- </div>
               
                    <div class="row mt-2">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-3 d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="saveOrderBtn" class="btn btn-primary btn-sm" disabled>Save Order</button>
                            <button type="button" id="updateOrderBtn" class="btn btn-primary btn-sm hide">Update Order</button>
                        </div>
                    </div> --}}
                {{-- </div> --}}
                   
                   

                {{-- </ div> --}}
             
            {{-- </div>  --}} 
        {{-- </form>
    </div>
    </div>
</div>  --}}

    {{-- <div class="col-lg-3 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <b>Invoice</b>
                    </div>
                    <div class="col-md-6">
                        {{-- <b class="float-right">Date</b><br/>
                        <b class="float-right">time</b> --}}
                    {{-- </div>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12 table-responsive p-0" style="height: 550px;">
                <table class="table table-head-fixed">
                    <thead>
                        <tr>
                            <th scope="col">Sno</th>
                            {{-- <th scope="col">Name</th> --}}
                            {{-- <th scope="col">Bill no</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Date</th>
                            <th scope="col">Print</th>
                            </tr>
                    </thead>
                    <tbody id="item_list">
                        @php
                            $count = 0;
                        @endphp
                         @foreach ($customers_billing as $item)
                        <tr>
                            <td>{{++$count}}</td>
                            <td>{{ucwords($item->customer_name)}}</td>
                            <td>{{$item->id}}</td>
                            <td>{{$item->total_amount}}</td>
                            <td>{{$item->bill_date}}</td>

                            <td>  --}} 
                                {{-- <button type="button" class="btn btn-secondary btn-flat btn-sm editOrderBtn" value="{{$list->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Order"><i class="far fa-edit"></i></button> --}}
                                {{-- <button type="button" class="btn btn-info btn-flat btn-sm orderDetailBtn" value="{{$item->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="View Order"><i class="far fa-eye"></i></button> --}}
                                {{-- <button type="button" class="btn btn-success btn-flat btn-sm orderInvoiceBtn" value="{{$item->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Invoice"><i class="fas fa-file-invoice"></i></button> --}}
                                {{-- <button type="button" class="btn btn-danger btn-flat btn-sm" value="{{$item->id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancel Order"><i class="fas fa-ban"></i></button> --}}
                                
                             {{-- </td>
                            
                        </tr>
                        @endforeach 
                    </tbody>
                    <tfoot>
                        
                    </tfoot>
                </table>  
                </div> --}}
                {{-- <button class="orderInvoiceBtn" >print</button> --}}
            {{-- </div>
            
        </div>
    </div> --}}

        {{-- <div class="card " >
            <div class="card-body page" id="barcode_body" style="max_height: 300px;">
                @foreach ($product_barcode as $list)
                    <div class="card" >
                        <div class="card-body pt-5">
                            {{-- <div class="row mb-2">
                                <span class="tect-center business_title text-center"><b>MANGALDEEP CLOTHS LLP</b></span>
                            </div> --}}
                            {{-- <div class="row" >
                               
                                <div class="col-md-12" id="div1">
                                    <img src="{{$list->barcode_img}}" class="barcode_image barcode img-fluid" ><br/>
                                    {{-- <img src="{{asset('public/assets/barcodes/barcode.gif')}}" class="img-thumbnail " > --}}
                                    {{-- <span class="product_detail"><b>{{$list->barcode}}</b></span> <br/> --}}
                                {{-- </div>
                            </div>
                            <button class="btn btn-primary btn-sm float-right" onclick="myFun('div1')">print</button>
                        </div>
                    </div>
                @endforeach
            </div> --}} 
            
        {{-- </div> --}} 

    {{-- </div> --}}

    

   {{-- </div> --}}

   <table class="hide">
    <tbody id="item_row">
        <tr>
            <td id="count_item"></td>
            
            <td style="width: 200px;">
                <select name="employee_id[]" id="employee_id" class="form-select" >
                    <option selected disabled>Emp</option>
                    @foreach($users as $item)
                        <option value="{{$item->id}}">{{ucwords($item->code)}}</option>
                    @endforeach
                </select>
            </td>
            <td style="width: 200px;">
                <input type="text" name="product_code[]"  class="form-control form-control-sm product_code">
            </td>

            <td style="width:150px;">
                {{-- <select name="product_id[]"  id="product_id" class=" form-select form-select-sm product_id">
                    <option selected>Choose..</option>
                    @foreach ($products as $item)
                        <option value="{{$item->id}}">{{ucwords($item->product)}}</option>
                    @endforeach
                </select> --}}
                <input type="text"  name="product[]" class="form-control form-control-sm product" readonly >
                <input type="hidden" name="product_id[]" class="product_id">
            </td>
           
            <td style="width: 80px;">
                <input type="text" name="qty[]" value="1" class="form-control form-control-sm qty" min="1" value="0">
            </td>
            <td style="width: 80px;">
                <input type="text"  name="size[]" class="form-control form-control-sm size" readonly>
                <input type="hidden" name="size_id[]" class="size_id">
            </td>
            <td style="width: 100px;">
                <input type="text" name="price[]" class="form-control form-control-sm price" >
            </td>
            <td style="width: 50px;">
                <input type="text" class="form-control form-control-sm discount" value="0">
                <input type="hidden" name="discount_amount[]" class="form-control form-control-sm discount_amount" style="width: 100px;">
            </td>
             
             <td style="width: 80px;" class="sgst_show_hide">
                 <input type="text" name="sgst[]" class="form-control form-control-sm sgst " value="0" readonly>
            </td> 
            <td style="width: 80px;" class="cgst_show_hide">
                 <input type="text" name="cgst[]" class="form-control form-control-sm cgst " value="0" readonly>
            </td> 
            <td style="width: 80px;" class="igst_show_hide hide">
                 <input type="text" name="igst[]" class="form-control form-control-sm igst " value="0" readonly>
            </td> 
            <td style="width: 150px;">
                <input type="text" name="amount[]" class="form-control form-control-sm amount" readonly>
                <input type="hidden" name="taxfree_amount[]" class="form-control form-control-sm taxable" style="width: 150px;">
           </td> 
            <td>
                <button type="button" class="btn btn-danger btn-flat btn-sm delete_item"><i class="far fa-window-close"></i></button>
            </td>
        </tr>
    </tbody>
</table> 

<section>
    <div id="newcontent">
        <div class="modal fade" id="generateInvoiceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                
        </div>
    </div>
</section>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <b>Billing</b>
                <button type="button" class="btn btn-primary btn-sm float-right" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    View Invoice
                </button>
            </div>
            <div class="card-body">
                <form id="orderForm">
                        @csrf
                        <div class="order_err"></div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header">
                                        <b>Customer Details</b>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                                <div class="col-md-5">
                                                    <label for="moblie_no" class="form-label" >Moblie no</label>
                                                    <input type="number"  class="form-control form-control-sm " id="mobile_no" name="mobile_no" minlength="10" maxlength="10" required id="moblie_no" placeholder="mobile number">
                                                </div>
                                                <div class="col-md-7">
                                                    <label for="moblie_no" class="form-label" >Customer name</label>
                                                    <input type="text"  class="form-control form-control-sm" id="customer_name" required name="customer_name" placeholder="Enter name">
                                                </div>
                                        </div>
                                            <div class="row mt-1">
                                                <div class="col-md-6">
                                                    <label for="" class="form-label" >DOB</label>
                                                        <input type="number"  class="form-control form-control-sm" name="birthday_date" id="birthday_date" required id="days" min="1" placeholder="date of brith">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="" class="form-label" >Months</label>
                                                    <select class="form-select form-select-sm" name="month_id" id="month_id" style="height:30px">
                                                    <option selected>Month</option>
                                                        @foreach ($months as $item)
                                                            <option value="{{$item->id}}">{{$item->month}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                    
                                            <div class="row mt-1">
                                                <div class="col-md-6">
                                                    <label class="form-label" >City</label>
                                                    <select name="city_id" id="city_id" class="form-select" >
                                                        <option selected disabled>City</option>
                                                        @foreach($cities as $item)
                                                            <option value="{{$item->id}}">{{ucwords($item->city)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" >Anniversary Date</label>
                                                    <input type="date" name="anniversary_date" id="anniversary_date"  class="form-control form-control-sm ">
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-md-6">
                                                    <div class="form-check state_type">
                                                        <input class="form-check-input " type="radio" name="state_type" value="{{MyApp::WITH_IN_STATE}}" id="with_in_state" checked>
                                                        <label class="form-check-label" for="flexRadioDefault1">With in State</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check state_type">
                                                        <input class="form-check-input " type="radio" name="state_type" value="{{MyApp::INTER_STATE}}"  id="inter_state" >
                                                        <label class="form-check-label" for="flexRadioDefault2">
                                                            Inter State
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-md-8">
                                                     <label for="" class="form-label" >GST NO</label>
                                                     <input type="text" name="gst_no" id="gst_no" placeholder="GST NO"  class="form-control form-control-sm ">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Points</label>
                                                    <input type="text" id="total_points" class="form-control form-control-sm" value="0" disabled>
                                                </div>
                                            </div>
                                            <div class="row mt-1">
                                                <div class="col-md-12">
                                                    <label for="" class="form-label" >Coupon Code</label>
                                                    <input type="text" name="cupan_code" id="cupan_code" placeholder="Coupon Code"  class="form-control form-control-sm ">
                                               </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <b>Credit Note</b>
                                                        </div>
                                                        <div class="card-body">
                                                            <div id="credit_note"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header">
                                        <b>Item</b>
                                        <b style="margin-left: 200px">017791071723</b>
                                        <button class="btn btn-primary btn-sm  float-right"  id="addItemBtn"> Add item</button>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive" style="max-height: 400px">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Sno</th>
                                                                <th scope="col">Emp</th>
                                                                <th scope="col">Code</th>
                                                                <th scope="col">Product</th>
                                                                <th scope="col">Qty</th>
                                                                <th scope="col">Size</th>
                                                                <th scope="col">MRP</th>
                                                                <th scope="col">Dis.</th>
                                                                <th scope="col" class="sgst_show_hide">SGST</th>
                                                                <th scope="col" class="cgst_show_hide">CGST</th>
                                                                <th scope="col" class="igst_show_hide hide">IGST</th>
                                                                <th scope="col">Amount</th>
                                                                <th scope="col">Delete</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="item_list">
                        
                                                        </tbody>
                                                    </table>  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="card-footer ">
                                            <div class="row">
                                                <div class="col-md-10 text-end">
                                                    <b>Total Amount :</b>
                                                </div>
                                                <div class="col-md-2 justify-content-end">
                                                    <input type="text" name="" class="form-control form-control-sm" id="item_total_amount" value="0" readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10 text-end">
                                                    <b>Discount :</b>
                                                </div>
                                                <div class="col-md-2 justify-content-end">
                                                    <input type="text" name="" id="total_discount" class="form-control form-control-sm" value="0" readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10 text-end">
                                                    <b>SGST :</b>
                                                </div>
                                                <div class="col-md-2 justify-content-end">
                                                    <input type="text" name="" id="total_sgst" class="form-control form-control-sm " value="0" readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10 text-end">
                                                    <b>CGST :</b>
                                                </div>
                                                <div class="col-md-2 justify-content-end">
                                                    <input type="text" name="" id="total_cgst" class="form-control form-control-sm " value="0" readonly>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-10 text-end">
                                                    <b>IGST :</b>
                                                </div>
                                                <div class="col-md-2 justify-content-end">
                                                    <input type="text" name="" id="total_igst" class="form-control form-control-sm " value="0" readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10 text-end">
                                                    <b>Points :</b>
                                                </div>
                                                <div class="col-md-2 justify-content-end">
                                                    <input type="text" name="redeem_points" id="redeem_points" class="form-control form-control-sm" value="0">
                                                </div>
                                            </div>
                                           
                                            <div class="row">
                                                <div class="col-md-10 text-end">
                                                    <b>Credit Note Amount :</b>
                                                </div>
                                                <div class="col-md-2 justify-content-end">
                                                    {{-- <input type="text" name="" id="item_total_amount" class="form-control form-control-sm " value="0" readonly> --}}
                                                    <input type="text" name="credit_note_amount" id="credit_note_amount" class="form-control form-control-sm " value="0" readonly>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-10 text-end">
                                                    <b>Gross Amount :</b>
                                                </div>
                                                <div class="col-md-2 justify-content-end">
                                                    {{-- <input type="text" name="" id="item_total_amount" class="form-control form-control-sm " value="0" readonly> --}}
                                                    <input type="text" name="" id="gross_amount" class="form-control form-control-sm " value="0" readonly>
                                                </div>
                                            </div>
    
                                            <div class="row mt-1 hide" id="given_return_amount" >
                                                <div class="col-md-4"></div>
                                                <div class="col-md-4"></div>
                                                <div class="col-md-2 text-end">
                                                    <div><b>Given Amt :</b></div>
                                                    <div class="mt-2" ><b >Return Amt :</b></div>
                                                </div>
                                                <div class="col-md-2 text-center">
                                                    <input type="text" name="" id="given_amount" class="form-control form-control-sm">
                                                    <input type="text" name="" id="return_amount" class="form-control form-control-sm mt-1" readonly>
                                                </div>
                                            </div>
                    
                                        </div>
                                        {{-- <hr> --}}
                                    </div>
                                {{-- </div> --}}
                                <input type="hidden" name="total_amount" id="total_amount" class="form-control form-control-sm " >
                                <hr>
                                <div class="row">
                                    <div class="col-md-8">
                                        <span>Payment :</span>
                                    </div>
                                    {{-- <div class="col-md-3">
                                        <span>Payment :</span>
                                    </div> --}}
                                </div>
                                <div class="row">
               
                                    <div class="col-md-1">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input payment_mode" type="checkbox" name="payment_mode" id="online" value="{{MyApp::ONLINE}}">Online
                                        </div>
                                    </div>
                                        <div class="col-md-2">
                                            <input type="text" name="pay_online" id="online_payment" class="form-control form-control-sm hide" value="0" placeholder="amount">
                                        </div>
                                    <div class="col-md-1">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input payment_mode" type="checkbox" name="payment_mode" id="cash" value="{{MyApp::CASH}}">Cash
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="pay_cash" id="cash_payment" class="form-control form-control-sm hide" value="0" placeholder="amount">
                                    </div>
                               
                                    <div class="col-md-1">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input payment_mode" type="checkbox" name="payment_mode" id="card" value="{{MyApp::CARD}}">Card
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="pay_card" id="card_payment" class="form-control form-control-sm hide"  value="0" placeholder="amount">
                                    </div>
                               
                                    <div class="col-md-1">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input payment_mode" type="checkbox" name="payment_mode" id="credit" value="{{MyApp::CREDIT}}">Credit
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                            <input type="text" name="pay_credit" id="credit_payment" class="form-control form-control-sm"  value="0" placeholder="amount">
                                    </div>
                                </div>
                               
                                    <div class="row mt-2">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4"></div>
                                        <div class="col-md-3 d-grid gap-2 d-md-flex justify-content-md-end">
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                            <button type="button" id="saveOrderBtn" class="btn btn-primary btn-sm" disabled>Save Order</button>
                                            <button type="button" id="updateOrderBtn" class="btn btn-primary btn-sm hide">Update Order</button>
                                        </div>
                                    </div>
                                {{-- </div> --}}
                                   
                                   
                
                                {{-- </ div> --}}
                            </div> 
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


@section('script')

<script>
    
    $(document).ready(function () {

        // print modal open
        addItem();

        $(document).on('click','.deleteBrandBtn', function (e) {
                e.preventDefault();
                const brand_id = $(this).val();
                // alert(brand_id)
                $('#printModal').modal('show');
                $('#yesdeleteBrandBtn').val(brand_id);
            });

            $(document).on('click','#yesdeleteBrandBtn', function (e) {
                e.preventDefault();
                const brand_id = $(this).val();
                deleteBrand(brand_id);
            });

            // closed print modal 

        $(".select_chosen").chosen({ width: '100%' });
     
        
        $(document).on('click','#addItemBtn', function (e) {
            e.preventDefault();

            var state_type = $('input[name=state_type]:checked', '#orderForm').val();
            if (state_type == '{{MyApp::WITH_IN_STATE}}') {
                
            }
            addItem();
             
            // $(".product_code").focus();
        });

            $(document).on('click','#saveOrderBtn', function (e) {
                e.preventDefault();
                saveOrder();
            });

           
            $(document).on("keypress",".qty, #given_amount",function(e){
                if(!(e.which>=48 && e.which<=57 ))
                {
                    if(!((e.which == 0) || (e.which==8)))
                    e.preventDefault();    
                }
            }); 

            $(document).on("change",".payment_mode",function(e){
                const payment_mode = $('input[name="payment_mode"]:checked').val();
                if(payment_mode == '{{MyApp::CASH}}'){
                    $('#given_return_amount').removeClass('hide');
                }else{
                    $('#given_return_amount').addClass('hide');
                }
                $('#saveOrderBtn').prop("disabled", false);
            }); 
                 


            $(document).on("click",".delete_item", function(){
                if($("#item_list tr").length == 1)
                {
                    alert("Order must have at least 1 item.");
                    return false;
                }
                $(this).parent().parent().remove();
                calculateTotalAmount();
                calculateCreditnoteReturnTotalAmount();
            });


            $(document).on('change','.product_code', function () {
                var object = $(this);
                getProductDetail(object);
                
            });

            
            $(document).on('click','#with_in_state', function (e) {
                // $('#gst_no').addClass('hide');
                // $('#city_id').addClass('hide');
                $('.sgst_show_hide').removeClass('hide');
                $('.cgst_show_hide').removeClass('hide');
                $('.igst_show_hide').addClass('hide');
                
            });

            $(document).on('click','#inter_state', function (e) {
                // $('#gst_no').removeClass('hide');
                // $('#city_id').removeClass('hide');
                $('.sgst_show_hide').addClass('hide');
                $('.cgst_show_hide').addClass('hide');
                $('.igst_show_hide').removeClass('hide');

            });


            $('#online').change(function(){
                if($(this).is(":checked")) {
                    $('#online_payment').removeClass("hide");
                } else {
                    $('#online_payment').addClass("hide");
                    $('#online_payment').val(0);
                }
                payonlinecashcard()
            });

            $('#cash').change(function(){
                if($(this).is(":checked")) {
                    $('#cash_payment').removeClass("hide");
                } else {
                    $('#cash_payment').addClass("hide");
                    $('#cash_payment').val(0);
                }
                // payonlinecashcard()
            });

            $('#card').change(function(){
                if($(this).is(":checked")) {
                    $('#card_payment').removeClass("hide");
                } else {
                    $('#card_payment').addClass("hide");
                    $('#card_payment').val(0);
                }
                // payonlinecashcard()
            });

            $('#credit').change(function(){
                if($(this).is(":checked")) {
                    $('#credit_payment').removeClass("hide");
                } else {
                    $('#credit_payment').addClass("hide");
                }
                // payonlinecashcard()
            });

            $(document).on('keyup','#mobile_no', function () {
                const mobile_no = $(this).val();
                if( mobile_no.length == 10 ) {
                    getCustomerData(mobile_no)
                }
                
            });
            
            $(document).on('keyup','.discount', function () {
                var object = $(this);
                calculateAmount(object);
                
            });
             
            $(document).on('keyup','.qty', function () {
                var object = $(this);
                calculateAmount(object);
            });
            
            $(document).on('keyup','.price', function () {
                var object = $(this);
                calculateAmount(object);
            });
           
            
           
            $(document).on('keyup','#given_amount', function () {
                returnAmount();
            });

            $(document).on('click','#saveOrderBtn', function (e) {
                e.preventDefault();
                validateForm();
            });            
           
            $(document).on('click','.orderInvoiceBtn', function (e) {
                e.preventDefault();
                const bill_id = $(this).val();
                // alert(bill_id);
                generateInvoice(bill_id);
            });

            $(document).on('click','#printBtn', function () {

                printInvoice();
            });

            $(document).on('click','#reload_invoice_print', function () {
              window.location.reload();
            });

            $(document).on('keyup','#redeem_points', function (e) {
                e.preventDefault();
                // redeemPoint();
                calculateTotalAmount();
            });
            // credit note function 
            $(document).on('click','.credit_note', function () {
                var credit_note_id = $(this).val();
                calculateCreditnoteReturnTotalAmount();
            });

            $(document).on('change','#online_payment', function () {
                var pay_online = $(this).val();
                var total_amount =   $('#item_total_amount').val();
                var gross_amount = $('#gross_amount').val();
                    var pay_online_amount = parseFloat(gross_amount - parseFloat(pay_online));
                    $("#gross_amount").val(pay_online_amount.toFixed(2));
                    $("#total_amount").val(pay_online_amount.toFixed(2));
                    $("#credit_payment").val(pay_online_amount.toFixed(2));
                });

                $(document).on('change','#cash_payment', function () {
                    var gross_amount = $('#gross_amount').val();
                    var pay_cash = $(this).val();
                    var pay_online = $(this).val();
                    var total_amount =   $('#item_total_amount').val();
                    var pay_online_amount = parseFloat(gross_amount - parseFloat(pay_cash));
                    $("#gross_amount").val(pay_online_amount.toFixed(2));
                    $("#total_amount").val(pay_online_amount.toFixed(2));
                    $("#credit_payment").val(pay_online_amount.toFixed(2));
                });

                $(document).on('change','#card_payment', function () {
                    var gross_amount = $('#gross_amount').val();
                    var pay_card = $(this).val();
                    var total_amount =   $('#item_total_amount').val();
                    var pay_online_amount = parseFloat(gross_amount - parseFloat(pay_card));
                    $("#gross_amount").val(pay_online_amount.toFixed(2));
                    $("#total_amount").val(pay_online_amount.toFixed(2));
                    $("#credit_payment").val(pay_online_amount.toFixed(2));
                });

                
            
                
         });

            // function payonlinecashcard(){
            //     var pay_online = $('#online_payment').val();
            //     var gross_amount = $('#gross_amount').val();
            //     var pay_online_amount = parseFloat(gross_amount - parseFloat(pay_online));
            //     $("#gross_amount").val(pay_online_amount.toFixed(2));
            //     $("#total_amount").val(pay_online_amount.toFixed(2));
            //     $("#credit_payment").val(pay_online_amount.toFixed(2));
               
            // }


        function calculateCreditnoteReturnTotalAmount(){
             var gross_amount = $('#gross_amount').val();
             var total_amount =   $('#item_total_amount').val();
             var total_Return = 0;
             var total_note_amount = 0;

            $('.credit_note:checked').each(function() {
                var note_amount = parseFloat($(this).attr('credit-note-amount'));
                total_note_amount = total_note_amount + note_amount ;
            });

            total_Return =  parseFloat(total_amount - parseFloat(total_note_amount));
                // $("#gross_amount").val(total_Return.toFixed(2));
                // $("#total_amount").val(total_Return.toFixed(2));
                // $("#credit_note_amount").val(total_note_amount.toFixed(2));
              

            if(total_note_amount > total_amount){
                $("#gross_amount").val(Math.abs(total_Return).toFixed(2));
                $("#total_amount").val(Math.abs(total_Return).toFixed(2));
                $("#credit_note_amount").val(total_note_amount.toFixed(2));
                
            }else if(total_note_amount == total_amount){
                $("#gross_amount").val("0.00");
                $("#total_amount").val('0.00');
                $("#credit_note_amount").val('0.00');
            }else{
                $("#gross_amount").val(total_Return.toFixed(2));
                $("#total_amount").val(total_Return.toFixed(2));
                $("#credit_note_amount").val(total_note_amount.toFixed(2));
            }
            // $("#credit_note_amount").val(total_note_amount.toFixed(2));
                

        }

       

        function getCustomerData(mobile_no) {
            $.ajax({
                type: "get",
                url: "get-customer-data/"+mobile_no,
                dataType: "json",
                success: function(response) {

                    if (response.status == 200) {
                        console.log(response)
                        $('#customer_name').val(response.customersData.customer_name);
                        $('#birthday_date').val(response.customersData.birthday_date);
                        $('#month_id').val(response.customersData.month_id);
                        $('#city_id').val(response.customersData.city_id);
                        $('#gst_no').val(response.customersData.gst_no);
                        $('#total_points').val(response.total_points);
                        $('#anniversary_date').val(response.anniversary_date);
                        $('#credit_note').html('');
                        $('#credit_note').append(response.html);
                        
                        if(response.customersData.state_type==1){
                            $('#with_in_state').prop('checked',true);
                        }else{
                            $('#inter_state').prop('checked',true);
                        }
                    }else{
                        $('#customer_name').val('');
                        $('#birthday_date').val('');
                        $('#month_id').val('');
                        $('#city_id').val('');
                        $('#gst_no').val('');
                        // $('#with_in_state').prop('checked',false);
                        // $('#inter_state').prop('checked',false);
                        $('#credit_note').html('');
                        $('#credit_note').append('');
                        // $('#credit_note').append(response.html);
                    }
                }

            });

        }

        function addItem() {
            $('#item_list').append($('#item_row').html());
            $(".product_code").focus();
            // $("#item_list tr").find(".item").chosen();
        }

        function getProductDetail(object){
            const product_code = $(object).val();
            // const product_id = $(object).val();
            //     alert(product_id);
            $.ajax({
                type: "get",
                url: "get-product-detail/"+product_code,
                dataType: "json",
                success: function (response) {
                    if (response.status == 200) {
                        console.log(response)
                        // addItem();
                        if(response.product_detail.barcode==product_code){
                            $(object).parent().parent().find(".qty").val(response.product_detail.qty++);
                            // alert(true)
                         
                            $(object).parent().parent().find(".price").val(response.product_detail.mrp);
                            $(object).parent().parent().find(".product").val(response.product_detail.product);
                            $(object).parent().parent().find(".product_id").val(response.product_detail.product_id);
                            $(object).parent().parent().find(".size").val(response.product_detail.size);
                            $(object).parent().parent().find(".mrp").val(response.product_detail.mrp);
                        }
                    }else{
                        console.log(response)
                        alert(false)
                        $(object).parent().parent().find(".qty").val('');
                        $(object).parent().parent().find(".price").val('');
                        $(object).parent().parent().find(".product").val('');
                        $(object).parent().parent().find(".product_id").val('');
                        $(object).parent().parent().find(".size").val('');
                        $(object).parent().parent().find(".mrp").val('');
                        
                    }
                    calculateAmount(object);
                }
            });

        }

        

        function calculateAmount(object){
            
            var price = parseFloat($(object).parent().parent().find(".price").val());
            var qty = parseFloat($(object).parent().parent().find(".qty").val());

            var discount = parseFloat($(object).parent().parent().find(".discount").val());
          
            if(qty == "" || isNaN(qty))
            {
                qty = 0;   
            }

            if(discount == "" || isNaN(discount))
            {
                discount = 0;   
            }
            var amount = parseFloat(price * qty);
            
            var taxable = 0;
            var discount_amount = 0 ;
            taxable = calculateTaxable(discount, amount);

            discount_amount = ( amount - taxable );
            var gst = calculateGst(taxable)

            $(object).parent().parent().find(".discount_amount").val(discount_amount.toFixed(2));
            $(object).parent().parent().find(".sgst").val(gst.sgst);
            $(object).parent().parent().find(".cgst").val(gst.cgst);
            $(object).parent().parent().find(".igst").val(gst.igst);
            $(object).parent().parent().find(".amount").val(taxable);
            $(object).parent().parent().find(".taxable").val(gst.base_amount);


            calculateTotalAmount();
            calculateCreditnoteReturnTotalAmount();

        }

        function calculateTaxable(discount, amount) {
            var taxable = 0;
            if (discount > 0) {
                var discount_amount = amount * discount / 100 ;
                taxable = (amount - discount_amount)  ;
            }else{
                taxable = amount;
            }

            return parseFloat(taxable.toFixed(2));
        }

        function calculateGst(taxable) {
            var state_type = $('input[name=state_type]:checked', '.state_type').val();
            var sgst = 0;
            var cgst = 0;
            var igst = 0;

            if (taxable < 1000) {
                base_amount = parseFloat(taxable / 1.05);

            }else{
                base_amount = parseFloat(taxable / 1.12);
            }

            if (state_type == 1) {
                if (base_amount < 1000) {
                    sgst = parseFloat(base_amount * 2.5 / 100);
                    cgst = parseFloat(base_amount * 2.5 / 100);
                }else{
                    sgst = parseFloat(base_amount * 6 / 100) ;
                    cgst = parseFloat(base_amount * 6 / 100) ;
                }
            }else{
                if (base_amount < 1000) {
                    igst = parseFloat(base_amount * 5 / 100) ;
                }else{
                    igst = parseFloat(base_amount * 12 / 100) ;
                }
            }

            data = {
                "sgst":sgst.toFixed(2),
                "cgst":cgst.toFixed(2),
                "igst":igst.toFixed(2),
                "base_amount":base_amount.toFixed(2),
            }

            return(data);
        }

        function calculateTotalAmount(){
            var item_total_amount = 0;
            var gross_amount = 0;

            $(".amount").each(function(){
                var total_amount = parseFloat($(this).val());
                if (!isNaN(total_amount))
                {
                    item_total_amount +=  total_amount;
                }  
            });
            $("#item_total_amount").val(item_total_amount.toFixed(2));

            
            // returnAmount();
            
            calculateTotalDiscount();
            calculateTotalGst();

            var redeem_points = redeemPoint();
            if (redeem_points > 0) {
                gross_amount = (item_total_amount - redeem_points) ;
            }else{
                gross_amount = item_total_amount ;
            }
            // new
            $("#gross_amount").val(gross_amount.toFixed(2));
            $("#total_amount").val(gross_amount.toFixed(2));
        }

        function calculateTotalDiscount(){
            var total_discount = 0;

            $(".discount_amount").each(function(){
                discount_amount = parseFloat($(this).val());
                if (!isNaN(discount_amount))
                {
                    total_discount +=  discount_amount;
                }  
            });
           
            $("#total_discount").val(total_discount.toFixed(2));
        }

        

        function calculateTotalGst(){
            var total_sgst = 0;
            var total_cgst = 0;
            var total_igst = 0;

            $(".sgst").each(function(){
                sgst = parseFloat($(this).val());
                if (!isNaN(sgst))
                {
                    total_sgst += sgst;
                }  
            });

            $(".cgst").each(function(){
                cgst = parseFloat($(this).val());
                if (!isNaN(cgst))
                {
                    total_cgst += cgst;
                }  
            });

            $(".igst").each(function(){
                igst = parseFloat($(this).val());
                if (!isNaN(igst))
                {
                    total_igst += igst;
                }  
            });
        
            $("#total_sgst").val(total_sgst.toFixed(2));
            $("#total_cgst").val(total_cgst.toFixed(2));
            $("#total_igst").val(total_igst.toFixed(2));
        }
        

        // PL6o2XQKFKClsqHz
            // end gst funcation

        function redeemPoint(){
            var total_points = parseFloat($('#total_points').val());
            var redeem_points = parseFloat($('#redeem_points').val());

            if(total_points == "" || isNaN(total_points))
            {
                total_points = 0;   
            }
            if(redeem_points == "" || isNaN(redeem_points))
            {
                redeem_points = 0;   
            }

            // if (total_points < redeem_points) {
            //     $('#redeem_points').val('0');
            //     alert('Points not available');
            //     return false;
            // }

            if(redeem_points > total_points)
            {
                $('#redeem_points').val('0');
                alert('Your total points ' + total_points + ' and redeem points ' + redeem_points + ' not allowed.');
                return false;
            }

            return redeem_points;
            
        }

        

        function returnAmount(){
            const given_amount = parseFloat($('#given_amount').val());
            const total_amount = parseFloat($("#total_amount").val());
            const return_amount = parseFloat(given_amount - total_amount) ; 
            $("#return_amount").val(return_amount);
        }

        

        function validateForm() {
            var msg = "";
            // if($("#invoice_no").val() == "")
            // {
            //     msg = "Please enter customer name";
            //     validateModal(msg);
            //     return false;
            // }

            if($("#item_list tr").length == 0)
            {
                msg = "Please add at least 1 item";
                validateModal(msg);
                return false;
            }

            $(".item").each(function (){
                msg = "Please select item";
                validateModal(msg);
                return false;
            });

            // saveOrder();
        }

        function saveOrder() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#orderForm")[0]);
            $.ajax({
                type: "post",
                url: "save-order",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.status === 400) {
                        $('#order_err').html('');
                        $('#order_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) {
                            $('#order_err').append('<span>' + count++ + '. ' + err_value + '</span></br>');
                        });

                    } else {
                        if(response.status === 200){
                            generateInvoice(response.bill_id);
                        }
                            // $('#order_err').html('');
                            // window.location.reload();
                    }
                }
            });
        }


        // function printInvoice(){
        //     //var order_id = $('#printBtn').attr('order-id'); 
        //     const section = $("section");
        //     const modalBody = $("#invoiceModalPrint").detach();

        //     section.empty();
        //     section.append(modalBody);
        //     window.print();
            
        //     window.location.reload();
               
        // }

        function printInvoice(){
            var backup = document.body.innerHTML;
            var div_content = document.getElementById("invoiceModalPrint").innerHTML;
            document.body.innerHTML = div_content;
            window.print();
            document.body.innerHTML = backup;
            window.location.reload();
        }

        // function generateInvoice(bill_id) {
        //  $.ajax({
        //     type: "get",
        //     url: "generate-invoice/"+bill_id,
        //     dataType: "json",
        //     success: function (response) {

        //         if (response.status == 200) {
        //             $('#generateInvoiceModal').html(response.html);
        //             $('#generateInvoiceModal').modal('show');
        //             // window.location.reload();
        //         }
        //     }
        // });
    
        // }

    </script>
    <script>
        function myFun(params) {
            // alert("call");
            var backup = document.body.innerHTML;
            var divcon = document.getElementById(params).innerHTML;
            document.body.innerHTML = divcon;
            window.print();
            document.body.innerHTML = backup;
        }
    </script>

@endsection
