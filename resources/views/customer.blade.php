@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Customer</h3>
            </div>
            <div class="card-body table-responsive p-0" style="height: 350px;">
                {{-- <div class="col-md-12 mt-2">
                    <select class="form-select form-select-sm" name="customer_id" id="customer_id" >
                        <option selected="" disabled=""> Select name </option>
                        @foreach ($customers as $item)
                            <option value="{{$item->id}}">{{$item->mobile_no}}-{{$item->customer_name}}</option> 
                        @endforeach
                    </select>
                </div>
                <br> --}}
                <div class="row">
                    <div class="col-md-12 table-responsive" style="height: 200px;">
                        {{-- <table class="table table-striped table-head-fixed" id="customer_list" > --}}
                        <table class="table table-striped table-head-fixed" id="customer_list" >
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Customer</th>
                                    <th>Mobile</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $key => $list)
                                    <tr id="customer_row_id" customer-id="{{$list->id}}">
                                        <td>{{++$key}}</td>
                                        <td>{{ucwords($list->customer_name)}}</td>
                                        <td>{{$list->mobile_no}}</td>
                                    </tr>
                                @endforeach
                            </tbody> 
                        </table>    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customer Point</h3>
            </div>
            <div class="card-body table-responsive p-0" style="height: 350px;">
                <div class="col-md-12 mt-2">
                    <div id="customer_detail_list"></div>
                    {{-- <table class="table table-striped table-head-fixed" id="" >
                        <thead>
                            <tr>
                            <th>SN</th>
                            <th>Customer</th>
                            <th>Bill ID</th>
                            <th>Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customer_points as $key => $list)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{ucwords($list->customer_id)}}</td>
                                    <td>{{$list->bill_id}}</td>
                                    <td>{{$list->customer_points}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>    --}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    $(document).ready(function(){
        $(document).on('change','#customer_id', function(e){
            e.preventDefault();
            var customer_id = $(this).val();
            // alert(customer_id);
            // $('#project_invoice').html("");
            // $('#client_project_row').val(customer_id);
            getProjects(customer_id);
        });

        
        $(document).on('click','#customer_row_id', function(e){
            e.preventDefault();
            var customer_id = $(this).attr('customer-id');
            // alert(customer_id);
            CustomerDetail(customer_id);
            
             
        });

        // $(document).on('click','#client_project_row', function(e){
        //     e.preventDefault();
        //     var customer_id = $(this).val();
        //     // alert(customer_id);
        //      getCustomerPoints(customer_id);
        // });


    });

    function getProjects(customer_id) {
        $.ajax({
            type: "get",
            url: `get-customer/${customer_id}`,
            dataType: "json",
            success: function (response) {
               
                if(response.status == 200){
                    $('#customer_list').html("");
                    $('#customer_list').append(response.html);
                }
            }
        });
    } 

    function CustomerDetail(customer_id) {
        $.ajax({
            type: "get",
            url: `customer-detail/${customer_id}`,
            dataType: "json",
            success: function (response) {
               
                if(response.status == 200){
                    $('#customer_detail_list').html("");
                    $('#customer_detail_list').append(response.html);
                }
            }
        });
    } 
</script>

@endsection