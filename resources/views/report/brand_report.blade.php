@extends('layouts.app')
@section('page_title', 'Brand Report')
@section('style')
    <style>
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-2">
                    <b>Brand Report </b>
                </div>
                
                <div class="col-md-2">
                    <select id="month_id" name="month_id" class="form-select form-select-sm select_chosen" >
                        <option selected disabled >Month</option>
                        @foreach ($months as  $list)
                            @if ($selected_month == $list->id)
                            <option  selected value="{{$list->id}}" >{{ucwords($list->month)}}</option>
                            @else
                            <option  value="{{$list->id}}" >{{ucwords($list->month)}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="brand_id" name="brand_id" class="form-select form-select-sm select_chosen" >
                        <option selected disabled >Brand</option>
                        @foreach ($all_brand as  $list)
                            <option value="{{$list->id}}" >{{ucwords($list->brand_name)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    {{-- @php
        echo "<pre>";
        print_r($brands);
    @endphp --}}
   
    
    <div class="row">
        @foreach ($brands as $key=> $list) 

        {{-- @php
            $count = checkBrandSales($list->id);
        @endphp --}}

        @if(!(empty($list)))
                <div class="col-md-12">
                    <div class="card row_filter" brand-id="{{$list['brand_id']}}">                        
                        <div class="card-header"><b>{{ucwords($list->brand_name)}}</b></div>  
                       
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-striped table-head-fixed table-sm">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Style no</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Size</th>
                                        <th>Mrp</th>
                                        {{-- <th>Amount</th> --}}
                                        {{-- <th>Dis. Amount</th>
                                        <th>Dis. Percentage</th>
                                        <th>CGST</th>
                                        <th>SGST</th>
                                        <th>IGST</th>                                      --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $qty = 0;
                                        $total = 0;
                                    @endphp
                                    @foreach ($brand_detail[$key] as $key1=> $item)   
                                        @php
                                            $qty = $qty + $item->qty ;
                                            $total = $total + $item->amount ;
                                        @endphp 
                                      {{-- @if(!(empty($list)))                                      
                                         <tr>                               
                                             {{-- { <td> {{$item}}</td>  --}} 
                                             <td> {{++$key1}}</td>
                                            <td>{{$item->sub_category}}</td>
                                            <td>{{$item->sub_category}}</td>
                                            <td>{{$item->qty}}</td>
                                             <td>{{$item->size}}</td>
                                            <td>{{$item->price}}</td>
                                            {{-- <td>{{$item->amount}}</td> --}}
                                            {{-- <td>{{$item->discount_amount}}</td> --}}
                                            {{-- <td>{{$item->discount_percentage}}</td>
                                            <td>{{$item->sgst}}</td>
                                            <td>{{$item->cgst}}</td>
                                            <td>{{$item->igst}}</td>  --}}
                                        </tr>
                                    @endforeach 
                                </tbody>
                                <tfoot class="bg-dark">
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="">Total</td>
                                        <td colspan="2"><b>{{$qty}}</b></td>
                                        <td colspan=""><b>{{$total}}</b></td>
                                        
                                    </tr>
                                </tfoot>
                            </table>
                            </div>
                        </div>
                    </div>
                </div> 
                @endif
                @endforeach
            </div>
           
   
@endsection
@section('script')
<script>
    $(document).ready(function () {
        
        $(document).on('change','#from_date',function (e) {
            e.preventDefault();
            $from_date = $(this).val();            
            // alert($from_date);
            // brandReport($from_date);

        })
        $(".select_chosen").chosen({ width: '100%' });
            $(document).on('change','#brand_id', function (e) {
                e.preventDefault();
                const brand_id = $(this).val();
                // alert(brand_id);
                var row = $('.row_filter');
                row.hide()
                row.each(function(i, el) {
                    if($(el).attr('brand-id') == brand_id) {
                        $(el).show();
                    }
                });
            });

            $(document).on('change','#month_id', function (e) {
                var  month_id = $(this).val();
                var url = "brand-report";
                location.replace(`${url}/${month_id}`);
                
              
            });
            
     });

          
</script>
    
@endsection