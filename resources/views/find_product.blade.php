@extends('layouts.app')
@section('page_title', 'Dashboard')
@section('content')

<div class="row">
    <div class="col-md-3">
        <input type="text" class="form-control form-control-sm float-right" id="findProductBarcode" placeholder="Search By Barcode">
    </div>
    <div class="col-md-3">
        <button type="button" id="searchByBarcode" class="btn btn-primary btn-sm mx-1 ">Search</button>
    </div>
    <div class="col-md-3">
        <select class="form-select form-select-sm" id="findProduct" style="height:30px">
            <option selected>Select...</option>
                @foreach ($style_no as $list)
                    <option value="{{$list->id}}">{{$list->style_no}}</option>
                @endforeach
        </select>
        {{-- <input type="text" class="form-control float-right" id="findProduct" placeholder="Find Product"> --}}
    </div>
    <div class="col-md-3">
        <button type="button" id="searchStyleNoBtn" class="btn btn-primary btn-sm mx-1 ">Search</button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div id="show_style_no">
    </div>
</div>


@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $(document).on('change','#findProduct',function (e) {
                e.preventDefault();
                var style_no = $('#findProduct option:selected').text();
                alert(style_no);
                searchStyleNo(style_no);
            });
        });

        function searchStyleNo(style_no) {
        $.ajax({
            type: "get",
            url: "search-style-no/"+style_no,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    $('#show_style_no').html("");
                    $('#show_style_no').append(response.html);
                }
            }
        });
    }  

    </script>

@endsection


