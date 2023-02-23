@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')
    {{-- model  --}}
    <div class="modal fade" id="applyOfferModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Offer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="applyOfferForm">
                        @csrf
                        <div id="apply_offer_error"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="form-check product">
                                            <input class="form-check-input" type="radio" name="offer_section"
                                                id="product" value="{{ MyApp::PRODUCT }}" checked>
                                            <label class="form-check-label">
                                                <b>Product</b>
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="form-check store">
                                            <input class="form-check-input " type="radio" name="offer_section"
                                                id="store" value="{{ MyApp::STORE }}">
                                            <label class="form-check-label">
                                                <b>Store</b>
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label ">Offer Type</label>
                                <select name="offer_type" id="apply_offer_type" class="form-select select_chosen_100">
                                    <option selected value="0">Offer type</option>
                                    <option value="{{ MyApp::PERCENTAGE }}">PERCENTAGE</option>
                                    {{-- <option value="{{ MyApp::VALUES }}">VALUES</option>
                                    <option value="{{ MyApp::PICES }}">PICES</option>
                                    <option value="{{ MyApp::SLAB }}">SLAB</option> --}}
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div id="inner_html_offer_data" style="margin-top: 33px;">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2 hide_column">
                            <div class="col-md-5">
                                <div class="row ">
                                    <div class="col-md-12 mt-2">
                                        <select id="category_id" name="category_id"
                                            class="form-select form-select-sm select_chosen_100"
                                            onchange="getSubCategoryByCategory(this.value);">
                                            <option selected disabled value="0">Category</option>
                                            @foreach ($Categories as $list)
                                                <option value="{{ $list->id }}" size-type="{{ $list->size_type }}">
                                                    {{ ucwords($list->category) }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <select id="sub_category_id" name="sub_category_id"
                                            class="form-select form-select-sm select_chosen_100">
                                            <option selected disabled>Sub Category</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <select id="brand_id" name="brand_id"
                                            class="form-select form-select-sm select_chosen brand_id select_chosen_100">
                                            <option selected disabled>Brand</option>
                                            @foreach ($brands as $key => $list)
                                                <option value="{{ $list->id }}">{{ ucwords($list->brand_name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-7 mt-2">
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" name="barcode[]" class="form-control form-control-sm barcode">
                                        {{-- <input type="text" name="" id=""> --}}
                                    </div>
                                    {{-- <div class="col-md-2">
                                        <button class="btn btn-success btn-sm" id="add_input_box">Add</button>
                                    </div> --}}
                                </div>
                                <div id="newinput"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">From Date</label>
                                <input type="date" name="offer_from" id="offer_from" class="form-control form-control-sm"
                                    min="0" style="height: 5px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">To Date</label>
                                <input type="date" name="offer_to" id="offer_to" class="form-control form-control-sm"
                                    min="0" style="height: 5px;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Offer Strat Time</label>
                                <input type="time" name="offer_start_time" id="offer_start_time" class="form-control form-control-sm"
                                    min="0" style="height: 5px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Offer End Time</label>
                                <input type="time" name="offer_end_time" id="offer_end_time" class="form-control form-control-sm"
                                    min="0" style="height: 5px;">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="saveApplyOfferBtn" class="btn btn-primary btn-sm ">Save
                                Offer</button>
                            <button type="button" id="updateOfferBtn" class="btn btn-primary btn-sm hide">Update
                                Offer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    {{-- model  --}}


    <!-- Button trigger modal -->



    <!-- Modal -->
    <div class="modal fade" id="createModalOffer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Offer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createOfferForm">
                        <div id="create_offer_error"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label ">Offer Type</label>
                                <select name="offer_type" id="offer_type" class="form-select select_chosen_100">
                                    <option selected disabled>Offer type</option>
                                    <option value="{{ MyApp::PERCENTAGE }}">PERCENTAGE</option>
                                        {{-- <option value="{{ MyApp::VALUES }}">VALUES</option>
                                        <option value="{{ MyApp::PICES }}">PICES</option>
                                        <option value="{{ MyApp::SLAB }}">SLAB</option> --}}
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div id="inner_html">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="saveCreateOfferBtn" class="btn btn-primary btn-sm ">Create Offer</button>
                            <button type="button" id="updateCreateOfferBtn" class="btn btn-primary btn-sm hide">Update Create Offer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->

    <div class="hide">

        <div id="discount_offer_type" class="hide mt-3">
            <div class="row">
                <div class="col-md-10">
                    <label class="form-label">Purcentage</label>
                    <input type="number" name="discount_offer[]" id="discount_offer"
                        class="form-control form-control-sm" placeholder="discount_offer" min="0">
                </div>
                <div class="col-md-2"style="margin-Top:33px">
                    <button class="btn btn-info btn-sm" id="Purcentage_row"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            <div id="add_Percentage"></div>
        </div>
        <div id="value_offer_type" class="hide mt-3">
            <div class="row">
                <div class="col-md-5">
                    <label class="form-label">Amount</label>
                    <input type="text" name="summary[]" id="summary" class="form-control form-control-sm"
                        placeholder="Amount">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Purcentage</label>
                    <input type="text" name="discount_offer[]" id="discount_offer"
                        class="form-control form-control-sm" placeholder="discount_offer" min="0">
                </div>
                <div class="col-md-2"style="margin-Top:33px">
                    <button class="btn btn-info btn-sm" id="add_row"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            <div id="item_list"></div>
        </div>
        <div id="pices_offer_type" class="hide mt-3">
            <div class="row">
                <div class="col-md-5">
                    <label class="form-label">Pices</label>
                    <input type="text" name="summary[]" id="summary" class="form-control form-control-sm"
                        placeholder="Pices">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Free</label>
                    <input type="text" name="discount_offer[]" id="discount_offer"
                        class="form-control form-control-sm" placeholder="Free Pices">
                </div>
                <div class="col-md-2"style="margin-Top:33px">
                    <button class="btn btn-info btn-sm" id="add_row"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            <div id="item_list"></div>
        </div>
        <div id="slab_offer_type" class="hide mt-3">
            <div class="row">
                <div class="col-md-5">
                    <label class="form-label">Pices</label>
                    <input type="text" name="summary[]" id="summary" class="form-control form-control-sm"
                        placeholder="Pices">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Purcentage</label>
                    <input type="number" name="discount_offer[]" id="discount_offer"
                        class="form-control form-control-sm" placeholder="discount_offer" min="0">
                </div>
                <div class="col-md-2"style="margin-Top:33px">
                    <button class="btn btn-info btn-sm" id="add_row"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            <div id="item_list"></div>
        </div>

    </div>

    {{-- delete model  --}}
    <div class="modal fade" id="deleteapplyOfferModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Admin </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <center>
                        <h5>Are you sure?</h5>
                        <button type="button" id="yesDeleteOfferBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                        <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                        <hr>
                    </center>
                </div>
            </div>
        </div>
    </div>
    {{-- delete modal end  --}}

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <b>Offers Type</b>
                    <button class="btn btn-success btn-sm float-right ml-4" id="addOfferNew"><i class="fas fa-plus"></i>
                        Create Offer</button>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($offer_types_data as $key1 => $list)
                            @php
                                $offer_type = '';
                                if ($list->offer_type == MyApp::PERCENTAGE) {
                                    $offer_type = 'PERCENTAGE';
                                } elseif ($list->offer_type == MyApp::VALUES) {
                                    $offer_type = 'VALUES';
                                } elseif ($list->offer_type == MyApp::PICES) {
                                    $offer_type = 'PICES';
                                } elseif ($list->offer_type == MyApp::SLAB) {
                                    $offer_type = 'SLAB';
                                }
                                $offer_section = '';
                                if ($list->offer_section == MyApp::PRODUCT) {
                                    $offer_section = 'PRODUCT';
                                } else {
                                    $offer_section = 'STORE';
                                }
                                
                            @endphp
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class='card-title'>{{ $offer_type }}</h3>
                                    </div>
                                    <div class="card-body">
                                        @php
                                            $offers = getOffers($list->offer_type);
                                        @endphp
                                        @foreach ($offers as $item)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            @if ($list->offer_type == MyApp::PERCENTAGE)
                                                                <div class="row">
                                                                    <div class="col-md-9">
                                                                        <b
                                                                            style="font-size: 22px; color:red ">{{ $item->discount_offer }}%</b>
                                                                        <b style="color:red">Off</b>

                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <button type="button"
                                                                            class="btn btn-info btn-sm   editOfferBtn"
                                                                            value="{{ $item->id }}"><i
                                                                                class="fas fa-edit"></i></button>
                                                                    </div>
                                                                    {{-- <div class="col-md-1 ml-2">
                                                                            <button type="button"
                                                                                class="btn btn-danger btn-sm  deleteOfferBtn"
                                                                                value="{{ $item->id }}"><i class="fas fa-trash"></i>
                                                                        </div> --}}
                                                                </div>
                                                            @endif
                                                            @if ($list->offer_type == MyApp::VALUES)
                                                                <div class="row">
                                                                    <div class="col-md-4 text-center">
                                                                        <b
                                                                            style="font-size: 22px; color:rgb(44, 101, 155)">{{ ucwords($item->summary) }}</b>
                                                                    </div>
                                                                    <div class="col-md-4 text-center">
                                                                        <b
                                                                            style="font-size: 22px; color:red ">{{ $item->discount_offer }}%</b>
                                                                        <b style="color:red">Off</b>

                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <button type="button"
                                                                            class="btn btn-info btn-sm   editOfferBtn"
                                                                            value="{{ $item->id }}"><i
                                                                                class="fas fa-edit"></i></button>
                                                                    </div>
                                                                    {{-- <div class="col-md-2">
                                                                        <button type="button"
                                                                            class="btn btn-danger btn-sm  deleteOfferBtn"
                                                                            value="{{ $item->id }}"><i class="fas fa-trash"></i>
                                                                    </div> --}}
                                                                </div>
                                                            @endif
                                                            @if ($list->offer_type == MyApp::PICES)
                                                                <div class="row">
                                                                    <div class="col-md-8 text-center" style="">
                                                                        <small
                                                                            style="font-size: 18px; letter-spacing: 3px;">Buy
                                                                        </small><b
                                                                            style="font-size: 25px; color:red; letter-spacing: 5px;">{{ ucwords($item->summary) }}</b><small
                                                                            style="font-size: 18px; letter-spacing: 3px;">Get</small><b
                                                                            style="font-size: 25px; color:red; letter-spacing: 5px;">{{ ucwords($item->discount_offer) }}</b><small
                                                                            style="font-size: 18px; letter-spacing: 3px;">Free</small>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <button type="button"
                                                                            class="btn btn-info btn-sm   editOfferBtn"
                                                                            value="{{ $item->id }}"><i
                                                                                class="fas fa-edit"></i></button>
                                                                    </div>
                                                                    {{-- <div class="col-md-2">
                                                                        <button type="button"
                                                                            class="btn btn-danger btn-sm  deleteOfferBtn"
                                                                            value="{{ $item->id }}"><i class="fas fa-trash"></i>
                                                                    </div> --}}
                                                                </div>
                                                            @endif
                                                            @if ($list->offer_type == MyApp::SLAB)
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <b class="text-center"
                                                                            style="font-size: 22px; color:red">{{ ucwords($item->summary) }}pcs</b>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <b class="text-center"
                                                                            style="font-size: 22px; color:red">{{ ucwords($item->discount_offer) }}%</b>
                                                                        {{-- <b style="font-size: 22px; color:red">Free</b> --}}
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <button type="button"
                                                                            class="btn btn-info btn-sm   editOfferBtn"
                                                                            value="{{ $item->id }}"><i
                                                                                class="fas fa-edit"></i></button>
                                                                    </div>
                                                                    {{-- <div class="col-md-2">
                                                                        <button type="button"
                                                                            class="btn btn-danger btn-sm  deleteOfferBtn"
                                                                            value="{{ $item->id }}"><i class="fas fa-trash"></i>
                                                                    </div> --}}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <b>Apply Offer</b>
                    <button class="btn btn-primary btn-sm float-right ml-4" id="addOffer"><i class="fas fa-plus"></i>
                        Apply Offer</button>
                    {{-- <button class="btn btn-info btn-sm float-right ml-4" id="get_time"><i class="fas fa-plus"></i>
                        Get time </button> --}}
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($apply_offers as $key1 => $list)
                            @php
                                $offer_type = '';
                                if ($list->offer_type == MyApp::PERCENTAGE) {
                                    $offer_type = 'PERCENTAGE';
                                } elseif ($list->offer_type == MyApp::VALUES) {
                                    $offer_type = 'VALUES';
                                } elseif ($list->offer_type == MyApp::PICES) {
                                    $offer_type = 'PICES';
                                } elseif ($list->offer_type == MyApp::SLAB) {
                                    $offer_type = 'SLAB';
                                }
                                $offer_section = '';
                                if ($list->offer_section == MyApp::PRODUCT) {
                                    $offer_section = 'PRODUCT';
                                } else {
                                    $offer_section = 'STORE';
                                }
                                
                            @endphp
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header" style="background-color:#A3E4D7">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <h3 class='card-title'>{{ $offer_type }}</h3>
                                                <b style="font-size: 20px;" class="ml-5">{{ $list->id }}</b>

                                            </div>
                                            <div class="col-md-2">
                                                <button type="button"
                                                    class="btn btn-outline-primary btn-sm dropdown-toggle dropdown-toggle-split"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="visually-hidden">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    @if ($list->status == MyApp::ACTIVE)
                                                        <li><button class="dropdown-item  offerStatusUpdateBtn"
                                                                value="{{ $list->id }}">Deactive</button></li>
                                                    @else
                                                        <li><button class="dropdown-item  offerStatusUpdateBtn"
                                                                value="{{ $list->id }}">Active</button></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-md-12 text-center">
                                                <b style="font-size: 20px;">{{ $offer_section }}</b>
                                            </div>
                                        </div>
                                        
                                        @foreach (explode(',', $list->offer_type_id) as $offer_type_id)
                                            @php
                                                $offer = getOfferData($offer_type_id);
                                            @endphp

                                            {{-- <li class="list-group-item">{{ $offer->discount_offer }}%</li> --}}

                                            @if ($list->offer_type == MyApp::PERCENTAGE)
                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                        <b style="color:red">{{ $offer->discount_offer }}% off
                                                        </b>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($list->offer_type == MyApp::VALUES)
                                                <div class="row">
                                                    <div class="col-md-12 text-center"
                                                        style="letter-spacing: 1px; font-size:18px">
                                                        <b
                                                            style="font-size: 18px; color:rgb(44, 101, 155)">{{$offer->summary}}</b>
                                                        <b
                                                            style="font-size: 18px; color:red ">{{ $offer->discount_offer }}%</b>
                                                        <b style="color:red">Off</b>
                                                    </div>
                                                    
                                                </div>
                                            @endif
                                            @if ($list->offer_type == MyApp::PICES)
                                                <div class="row">
                                                    <div class="col-md-12 text-center"
                                                        style="letter-spacing: 1px; font-size:18px">
                                                        <span>Buy
                                                        </span><b>{{ ucwords($offer->summary) }}</b>
                                                        <samp>Get</samp><b>{{ ucwords($offer->discount_offer) }}</b>
                                                        <span>Free</span>
                                                    </div>
                                                </div>
                                            @endif
                                            @if ($list->offer_type == MyApp::SLAB)
                                                <div class="row">
                                                    <div class="col-md-6 text-center">
                                                        <b
                                                            style="font-size: 18px; color:rgb(44, 101, 155)">{{ $offer->summary }}</b>
                                                    </div>
                                                    <div class="col-md-6 text-center">
                                                        <b
                                                            style="font-size: 18px; color:red ">{{ $offer->discount_offer }}%</b>
                                                        <b style="color:red">Off</b>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        <div class="row" style="font-size: 20px">
                                            <div class="col-md-6">
                                                {{-- <small>Brand Name</small><br> --}}
                                                <b>{{ ucwords($list->brand_name) }}</b>
                                            </div>
                                            <div class="col-md-6">
                                                {{-- <small>Sub Category Name</small><br> --}}
                                                <b class="float-right">{{ ucwords($list->sub_category) }}</b>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($list->status == MyApp::ACTIVE)
                                        <div class="card-footer" style="background-color:#A3E4D7">
                                            <div class="row" style="colo">
                                                <div class="col-md-6"><small><b>From Date</b></small></b></div>
                                                <div class="col-md-6 text-end"><small><b>To Date</b></small></b></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <b>{{ date('d-m-Y', strtotime($list->offer_from)) }}</b>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <b>{{ date('d-m-Y', strtotime($list->offer_to)) }}</b>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="card-footer"style="background-color:#BDC3C7">
                                            <div class="row" style="colo">
                                                <div class="col-md-6"><small><b>From Date</b></small></b></div>
                                                <div class="col-md-6 text-end"><small><b>To Date</b></small></b></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <b>{{ date('d-m-Y', strtotime($list->offer_from)) }}</b>
                                                </div>
                                                <div class="col-md-6 text-end">
                                                    <b>{{ date('d-m-Y', strtotime($list->offer_to)) }}</b>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    </div>
                
                </div>
            </div>
        </div>
    </div>
    {{-- </div>
    </div> --}}
    </div>

    {{-- <div class="row">
        @foreach ($offers as $list)
            @php
                $offer_type = '';
                if ($list->offer_type == MyApp::PERCENTAGE) {
                    $offer_type = 'PERCENTAGE';
                } elseif ($list->offer_type == MyApp::VALUES) {
                    $offer_type = 'VALUES';
                } elseif ($list->offer_type == MyApp::PICES) {
                    $offer_type = 'PICES';
                } elseif ($list->offer_type == MyApp::SLAB) {
                    $offer_type = 'SLAB';
                }
                $offer_section = '';
                if ($list->offer_section == MyApp::PRODUCT) {
                    $offer_section = 'PRODUCT';
                } else {
                    $offer_section = 'STORE';
                }
                
            @endphp
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class='card-title'>{{ $offer_type }}</h3>
                        {{-- <button class="editOfferBtn float-right"  value="{{$list->id}}"><i class="fas fa-edit"></i></button> --}}
    {{-- </div>
                    <div class="card-body">
                        <div>
                            <div class="row m-0">
                                <div class="col-md-12 text-center" style="font-size: 18px">
                                    <b>{{ $offer_section }}</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">

                                    @if ($list->offer_type == MyApp::PERCENTAGE)
                                        <div class="row">
                                            <div class="col-md-10 float-end">
                                                <b style="font-size: 22px; color:red">{{ $list->discount_offer }}%</b>
                                            </div>
                                            <div class="col-md-2 float-end"><b style="font-size: 22px; color:red">Off</b>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <b class="float-left">{{ $list->sub_category }}</b>
                                            </div>
                                            <div class="col-md-6">
                                                <b class="float-right">{{ ucwords($list->brand_name) }}</b>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($list->offer_type == MyApp::VALUES)
                                        <div class="row">
                                            <div class="col-md-4">
                                                <b
                                                    style="font-size: 22px; color:rgb(44, 101, 155)">{{ ucwords($list->summary) }}</b>
                                            </div>
                                            <div class="col-md-4">
                                                <b class="text-center"
                                                    style="font-size: 22px; color:red ">{{ $list->discount_offer }}%</b>
                                            </div>
                                            <div class="col-md-4"><b style="font-size: 22px; color:red">Off</b></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <b class="float-left">{{ ucwords($list->sub_category) }}</b>

                                            </div>
                                            <div class="col-md-6">
                                                <b class="float-right">{{ ucwords($list->brand_name) }}</b>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($list->offer_type == MyApp::PICES)
                                        <div class="row">
                                            <div class="col-md-4">
                                                <b class="text-center"
                                                    style="font-size: 22px; color:red">{{ ucwords($list->summary) }}pcs</b>
                                            </div>
                                            <div class="col-md-4">

                                            </div>
                                            <div class="col-md-4">
                                                <b class="text-center"
                                                    style="font-size: 22px; color:red">{{ ucwords($list->discount_offer) }}</b>
                                                <b style="font-size: 22px; color:red">Free</b>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <b class="float-left">{{ $list->sub_category }}</b>
                                            </div>
                                            <div class="col-md-6">
                                                <b class="float-right">{{ ucwords($list->brand_name) }}</b>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($list->offer_type == MyApp::SLAB)
                                        <div class="row">
                                            <div class="col-md-4" style="font-size: 22px; color:rgb(44, 101, 155)">
                                                <b>{{ ucwords($list->summary) }}</b>
                                            </div>
                                            <div class="col-md-4">
                                                <b style="font-size: 22px; color:red ">{{ $list->discount_offer }}%</b>
                                            </div>
                                            <div class="col-md-4">
                                                <b style="font-size: 22px; color:rgb(44, 101, 155)">Off</b>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <b class="float-left">{{ $list->sub_category }}</b>
                                            </div>
                                            <div class="col-md-6">
                                                <b class="float-right">{{ ucwords($list->brand_name) }}</b>
                                            </div>
                                        </div>
                                    @endif



                                </div>
                            </div>
                        </div> --}}
    {{-- <hr> --}}
    {{-- <div class="row mt-2">
                        @foreach (explode(',', $list->style_no_id) as $style_no_id)
                            <div class="col-md-4 mt-1">
                                    @php
                                        $style_name = getStyleNO($style_no_id);
                                    @endphp
                                    <li class="list-group-item">{{$style_name}}</li>
                            </div>
                        @endforeach
                    </div> --}}
    {{-- </div>
                    @if ($list->status == MyApp::ACTIVE)
                        <div class="card-footer" data-bs-toggle="collapse" href="#collapseExample_{{ $list->id }}"
                            role="button" aria-expanded="false" aria-controls="collapseExample"
                            style="background-color:#A3E4D7">
                        @else
                            <div class="card-footer" data-bs-toggle="collapse"
                                href="#collapseExample_{{ $list->id }}" role="button" aria-expanded="false"
                                aria-controls="collapseExample" style="background-color:#BDC3C7">
                    @endif
                    <div class="row">
                        <div class="col-md-6"><small><b>From Date</b></small></b></div>
                        <div class="col-md-6 text-end"><small><b>To Date</b></small></b></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"><b>{{ date('d-m-Y', strtotime($list->offer_from)) }}</b></div>
                        <div class="col-md-6 text-end"><b>{{ date('d-m-Y', strtotime($list->offer_to)) }}</b></div>
                    </div>
                </div> --}}
    {{-- end footer --}}
    {{-- <div class="collapse" id="collapseExample_{{ $list->id }}">
                    <div class="card card-body table-responsive">
                        <table class="table">
                            <tbody>
                                @foreach (explode(',', $list->style_no_id) as $key => $style_no_id)
                                    @php
                                        $result = getStyleNO($style_no_id);
                                    @endphp
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $result }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div> --}}
    {{-- @endforeach --}}
    {{-- </div> --}}

    {{-- purcentage offer row add  --}}
    <div class="hide">
        <div id="item_row_purcentage">
            <div class="row" id="delete_item">
                <div class="col-md-10">
                    <input type="number" name="discount_offer[]" id="discount_offer"
                        class="form-control form-control-sm" min="0">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm delete_row"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>
    </div>
    {{-- purcentage offer row add  --}}

    {{-- slab offer row add  --}}
    <div class="hide">
        <div id="item_row">
            <div class="row" id="delete_item">
                <div class="col-md-5">
                    <input type="text" name="summary[]" id="summary" class="form-control form-control-sm">
                </div>
                <div class="col-md-5">
                    <input type="number" name="discount_offer[]" id="discount_offer"
                        class="form-control form-control-sm" min="0">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm delete_row"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>
    </div>
    {{-- slab offer row add  --}}

    {{-- add barcode row  --}}
    <div class="hide">
        <div id="add_node">
            <div class="row" id="row">
                <div class="col-md-10">
                    <input type="text" name="barcode[]" class="form-control form-control-sm barcode">
                    {{-- <input type="text" name="" id=""> --}}
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm remove-field"><i
                            class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>
    </div>
    {{-- add barcode row  --}}



@endsection
@section('script')
    <script>
        $(document).ready(function() {

            // setTimeout(() => {
            //     alert("call");
            //     // offerEnd();
            // }, 10000);
         

            $(document).on('click', '#addOffer', function(e) {
                e.preventDefault();
                $('#applyOfferModal').modal('show');
                $('#apply_offer_error').html('');
                $('#apply_offer_error').removeClass('alert alert-danger');
                $("#applyOfferForm").trigger("reset");
                $(".select_chosen_100").chosen({
                    width: '100%'
                });
                $('#saveApplyOfferBtn').removeClass('hide');
                $('#updateOfferBtn').addClass('hide');
            });

            // create offers 
            $(document).on('click', '#addOfferNew', function(e) {
                e.preventDefault();
                $('#createModalOffer').modal('show');
                $('#create_offer_error').html('');
                $('#create_offer_error').removeClass('alert alert-danger');
                $("#createOfferForm").trigger("reset");
                $(".select_chosen_100").chosen({
                    width: '100%'
                });
                $('#saveCreateOfferBtn').removeClass('hide');
                $('#updateCreateOfferBtn').addClass('hide');
            });


            $(document).on('click', '#saveCreateOfferBtn', function(e) {
                e.preventDefault();
                saveCreateOffers();
            });


            $(document).on('click', '#saveApplyOfferBtn', function(e) {
                e.preventDefault();
                // alert("call");
                saveApplyOffer();
            });



            $(document).on('click', '#add_row', function(e) {
                e.preventDefault();
                addItem();

            });

            $(document).on('click', '#Purcentage_row', function(e) {
                e.preventDefault();
                addPercentage();

            });

            $(document).on('change', '.barcode', function(e) {
                e.preventDefault();
                var barcode = $('.barcode').val();
                // alert(barcode);
                addBarcode();

            });

            $(document).on('click', '.remove-field', function(e) {
                e.preventDefault();
                $(this).parents("#row").remove();

            });

            $(document).on('click', '.delete_row', function(e) {
                e.preventDefault();
                $(this).parents("#delete_item").remove();
            });

            $(document).on('click', '.editOfferBtn', function(e) {
                e.preventDefault();
                const offer_id = $(this).val();
                // alert(offer_id);
                editOffer(offer_id);

            });

            $(document).on('click', '#updateCreateOfferBtn', function(e) {
                e.preventDefault();
                const offer_id = $(this).val();
                updateOffer(offer_id);
            });

            $(document).on('click', '.deleteOfferBtn', function(e) {
                e.preventDefault();
                const offer_id = $(this).val();
                // alert(offer_id);
                $('#deleteapplyOfferModal').modal('show');
                $('#yesDeleteOfferBtn').val(offer_id);
            });

            $(document).on('click', '#yesDeleteOfferBtn', function(e) {
                e.preventDefault();
                const offer_id = $(this).val();
                deleteOffer(offer_id);
            });

            $(document).on('change', '#store', function(e) {
                e.preventDefault();
                $('.hide_column').addClass('hide');
            });


            $(document).on('change', '#product', function(e) {
                e.preventDefault();

                $('.hide_column').removeClass('hide');
            });

            $(document).on('click', '.offerStatusUpdateBtn', function(e) {
                e.preventDefault();
                const apply_offer_id = $(this).val();
                // alert(apply_offer_id);
                applyOfferUpdateStatus(apply_offer_id);
            });



            $(document).on('change', '#offer_type', function(e) {
                var offer_type = $(this).val();
                createOfferType(offer_type);


            });


            $(document).on('change', '#apply_offer_type', function(e) {
                var offer_type = $(this).val();
                getOfferType(offer_type);

            });
            
            // $(document).on('click', '#get_time', function(e) {
            //     var time = new Date();
            //         getTime =time.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
            //         alert(getTime);
            // });

        });


        function addItem() {
            $('#item_list').append($('#item_row').html());
        }

        function addPercentage() {
            $('#add_Percentage').append($('#item_row_purcentage').html());
        }


        function addBarcode() {
            $('#newinput').append($("#add_node").html());
        }


        function createOfferType(offer_type) {
            // alert(offer_type);
            $('#inner_html').html('');
            if (offer_type == 1) {
                $('#inner_html').append($('#discount_offer_type').html());

            } else if (offer_type == 2) {
                $('#inner_html').append($('#value_offer_type').html());

            } else if (offer_type == 3) {
                $('#inner_html').append($('#pices_offer_type').html());

            } else if (offer_type == 4) {
                $('#inner_html').append($('#slab_offer_type').html());
            }

        }


        function saveCreateOffers() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#createOfferForm")[0]);
            $.ajax({
                type: "post",
                url: "save-create-offer",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    if (response.status === 400) {
                        $('#create_offer_error').html('');
                        $('#create_offer_error').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function(key, err_value) {
                            $('#create_offer_error').append('<span>' + count++ + '. ' + err_value +
                                '</span></br>');
                        });

                    } else {
                        $('#create_offer_error').html('');
                        $('#createOfferModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }


        function saveApplyOffer() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#applyOfferForm")[0]);
            $.ajax({
                type: "post",
                url: "save-offer-apply",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    if (response.status === 400) {
                        $('#apply_offer_error').html('');
                        $('#apply_offer_error').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function(key, err_value) {
                            $('#apply_offer_error').append('<span>' + count++ + '. ' + err_value +
                                '</span></br>');
                        });

                    } else {
                        $('#apply_offer_error').html('');
                        $('#applyOfferModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }




        function editOffer(offer_id) {
            $.ajax({
                type: "get",
                url: "edit-offer/" + offer_id,
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        $('#createModalOffer').modal('show');
                        $('#create_offer_error').html('');
                        $('#create_offer_error').removeClass('alert alert-danger');
                        $("#offerForm").trigger("reset");
                        $('#saveCreateOfferBtn').addClass('hide');
                        $('#updateCreateOfferBtn').removeClass('hide');
                        createOfferType(response.offer.offer_type);
                        if (response.offer.offer_type == 1) {
                            $('#offer_type').val(response.offer.offer_type);
                            $('#summary').val(response.offer.summary);
                            $('#discount_offer').val(response.offer.discount_offer);
                            $('#Purcentage_row').addClass('hide');

                        }
                        if (response.offer.offer_type == 2) {
                            $('#offer_type').val(response.offer.offer_type);
                            $('#summary').val(response.offer.summary);
                            $('#discount_offer').val(response.offer.discount_offer);
                            $('#add_row').addClass('hide');
                        }
                        if (response.offer.offer_type == 3) {
                            $('#offer_type').val(response.offer.offer_type);
                            $('#summary').val(response.offer.summary);
                            $('#discount_offer').val(response.offer.discount_offer);
                            $('#add_row').addClass('hide');
                        }
                        if (response.offer.offer_type == 4) {
                            $('#offer_type').val(response.offer.offer_type);
                            $('#summary').val(response.offer.summary);
                            $('#discount_offer').val(response.offer.discount_offer);
                            $('#add_row').addClass('hide');
                        }


                        $('#updateCreateOfferBtn').val(response.offer.id);
                    }
                }
            });
        }

        function updateOffer(offer_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#createOfferForm")[0]);
            $.ajax({
                type: "post",
                url: "update-offer/" + offer_id,
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 400) {
                        $('#create_offer_error').html('');
                        $('#create_offer_error').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function(key, err_value) {
                            $('#create_offer_error').append('<span>' + count++ + '. ' + err_value +
                                '</span></br>');
                        });

                    } else {
                        $('#create_offer_error').html('');
                        $('#createModalOffer').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        function deleteOffer(offer_id) {
            $.ajax({
                type: "get",
                url: "delete-offer/" + offer_id,
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        window.location.reload();
                    }
                }
            });
        }


        function getOfferType(offer_type) {
            $.ajax({
                type: "get",
                url: "offer-type/" + offer_type,
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        console.log(response);
                        $('#inner_html_offer_data').html('');
                        $('#inner_html_offer_data').append(response.html);
                    }
                }
            });
        }


        function applyOfferUpdateStatus(apply_offer_id) {
            $.ajax({
                type: "get",
                url: "applye_offer_update_status/" + apply_offer_id,
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    if (response.status == 200) {
                        window.location.reload();
                    }
                }
            });
        }

        // function offersEnd(){
        //     var offer_time  = $(this).val();
        //     setTimeout(() => {
        //         alert("end offers");
        //     }, 10);
        // }

    </script>
@endsection
