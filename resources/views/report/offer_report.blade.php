@extends('layouts.app')
@section('page_title', 'Offer Report')
@section('style')
    <style>
    </style>
@endsection

@section('content-header')
    <div class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="m-0"><b>Offer Report</b></h3>
            </div>
            <div class="col-sm-6">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                    {{-- <button type="button" id="purchaseExcelEntry" class="btn btn-info btn-flat btn-sm "><i class="fas fa-plus"></i> Purchase Excel Entry</button> --}}
                    {{-- <button type="button" id="purchaseEntry" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-plus"></i> Purchase Entry</button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6"><b>Offers</b></div>
                        <div class="col-md-6">
                            <select  name="offer_type" id="offer_type" class="form-select select_chosen_100">
                                <option selected disabled>Offer Type</option>
                                <option value="{{MyApp::PERCENTAGE}}">PERCENTAGE</option>
                                <option value="{{MyApp::VALUES}}">VALUES</option>
                                <option value="{{MyApp::PICES}}">PICES</option>
                                <option value="{{MyApp::SLAB}}">SLAB</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class='card-body table-responsive' style='height: 500px;'>

                    @foreach ($offers as $list)
                        
                        @php
                            $offer_type = '';
                            if ($list->offer_type==MyApp::PERCENTAGE) {
                                $offer_type = 'PERCENTAGE';
                            } else if ($list->offer_type==MyApp::VALUES) {
                                $offer_type = 'VALUES';
                            }elseif ($list->offer_type==MyApp::PICES) {
                                $offer_type = 'PICES';
                            }elseif ($list->offer_type==MyApp::SLAB) {
                                $offer_type = 'SLAB';
                            } 
                            
                        @endphp
                        <div class='card card-outline card-primary' >
                            <div class='card-header'>
                                <h3 class='card-title'>{{$offer_type}}</h3>
                            </div>
                            <div class='card-body'>
                                <div class="row m-0">
                                    <div class="col-md-12 text-center" style="font-size: 18px">
                                        <b>{{($list->offer_section == MyApp::PRODUCT) ? 'PRODUCT' : 'STORE'}}</b>                           
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-md-4">
                                        <b style="font-size: 22px; color:red;">{{ucwords($list->summary)}}</b>
                                    </div>
                                    <div class="col-md-4">
                                        <b style="font-size: 22px; color:red;">{{$list->discount_offer}}%</b>
                                    </div>
                                    <div class="col-md-4">
                                        <b style="font-size: 22px; color:red;">Off</b>
                                    </div>
                                </div>
                            </div>
                            <div class='card-footer  ' style="background-color:#A3E4D7">
                                <div class='row'>
                                    <div class='col-md-6'>
                                        <span><b>{{date('d-m-Y',strtotime($list->offer_from))}}</b></span></b>
                                    </div>
                                    <div class='col-md-6 text-end'>
                                        <span><b>{{date('d-m-Y',strtotime($list->offer_to))}}</b></span></b>
                                    </div>
                                </div>
                            </div>
                        </div>
                   
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9"><b>Offers</b></div>
                        <div class="col-md-3">
                            <select  name="offer_type" id="offer_type" class="form-select select_chosen_100">
                                <option selected disabled>Category</option>
                                
                            </select>
                        </div>
                    </div>
                </div>
                <div class='card-body table-responsive' style='height: 500px;'>
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Brand</th>
                                <th>Style No</th>
                            </tr>
                        </thead>
                        @php
                            $count = 0;
                        @endphp
                        <tbody>
                            @foreach ($bill_invoice_items as $list)
                                <tr class="row_filter search_data" city-id="{{$list->id}}">
                                    <td>{{++$count}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    
                                    {{-- <td>{{($list->state_type == MyApp::WITH_IN_STATE) ? "Within State":"Inter State" }}</td>
                                    <td >{{$list->supplier_code}}</td>
                                    <td>{{ucwords($list->supplier_name)}}</td>
                                    <td>{{$list->mobile_no}}</td>
                                    <td>{{$list->phone_no}}</td>
                                    <td>{{$list->gst_no}}</td>
                                    <td class="text-center">{{$list->payment_days}}</td>
                                    <td>{{ucwords($list->state)}}</td>
                                    <td>{{ucwords($list->city)}}</td> --}}
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $(".select_chosen_100").chosen({ width: '100%' });

        });
    </script>
@endsection
