@extends('layouts.app')
@section('page_title', 'Brand Report')
@section('style')
    <style>
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><b>Brand Report</b></div>
    </div>
    {{-- @php
    echo "<pre>";
        print_r($free_brands);
    @endphp --}}
   
    @foreach ($free_brands as $item) 
        @if(!(empty($item)))
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        @php
                            $get_brands = getBrands($item->brand_id);
                            
                            
                        @endphp
                        {{-- <div class="card-header">{{$item['brand_name']}}</div>   --}}

                        <div class="card-body">
                            <table class='table table-striped table-head-fixed'>
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Brand</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                      @foreach ($get_brands as $brands)
                                          
                                      {{-- <td> {{$brands['sub_category']}}</td> --}}
                                      <td>{{$item['brand_name']}}</td>
                                      @endforeach
                                        
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div> 
                    
            </div>
        @endif
    @endforeach
   
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
    });
</script>
    
@endsection