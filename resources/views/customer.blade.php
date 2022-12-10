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
                <div class="col-md-12 mt-2">
                    <select class="form-select form-select-sm" name="customer_id" id="customer_id" >
                        <option selected="" disabled=""> Select name </option>
                        @foreach ($customers as $item)
                            <option value="{{$item->id}}">{{$item->mobile_no}}-{{$item->customer_name}}</option> 
                        @endforeach
                    </select>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 table-responsive" style="height: 200px;">
                        <table class="table table-striped table-head-fixed" id="customer_list" >
                            
                        </table>    
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
            getProjects(customer_id);
           
        });
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
</script>

@endsection