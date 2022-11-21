@extends('layouts.app')
@section('page_title', 'Manage Stock')

@section('style')
    <style>
    #colorinput{
        border: none;
    }
    </style>
@endsection;

@section('content')

    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <b>Category </b>
                </div>
                <div class="card-body">
                    <div class="responsiv-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Sno</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Qty</th>
                                    {{-- <th scope="col">Handle</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Jeans</td>
                                    <td>10</td>
                                    {{-- <td>@mdo</td> --}}
                                </tr>
                              
                            </tbody>
                        </table>
                    </div>  
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6"><b>Sub Categoty</b></div>
                        <div class="col-md-6">
                            <select id="category_id" name="category_id" class="form-select form-select-sm" >
                                <option selected disabled >Category</option>
                                {{-- @foreach ($categories as $key => $list)
                                    <option value="{{$list->id}}" >{{$list->name}}</option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="responsiv-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Sno</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Qty</th>
                                    {{-- <th scope="col">Handle</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Jeans</td>
                                    <td>10</td>
                                    {{-- <td>@mdo</td> --}}
                                </tr>
                              
                            </tbody>
                        </table>
                    </div>  
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-2"><b>Products</b></div>
                        <div class="col-md-3">
                            <select id="category_id" name="category_id" class="form-select form-select-sm" >
                                <option selected disabled >Choose...</option>
                                {{-- @foreach ($categories as $key => $list)
                                    <option value="{{$list->id}}" >{{$list->name}}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="sub_category_id" name="sub_category_id" class="form-select form-select-sm" >
                                <option selected disabled >Choose...</option>
                                {{-- @foreach ($categories as $key => $list)
                                    <option value="{{$list->id}}" >{{$list->name}}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="size_id" name="size_id" class="form-select form-select-sm" >
                                <option selected disabled >Choose...</option>
                                {{-- @foreach ($categories as $key => $list)
                                    <option value="{{$list->id}}" >{{$list->name}}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button id="assign_work_reset" class="btn btn-dark btn-sm mt-1" disabled>Reset</button>
                        </div>
                        <div class="col-md-1" >
                            <b><span id="assign_work_count" >450</span></b>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="responsiv-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Sno</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Qty</th>
                                    {{-- <th scope="col">Handle</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Jeans</td>
                                    <td>XL</td>
                                    <td>Red</td>
                                    <td>10</td>
                                    {{-- <td>@mdo</td> --}}
                                </tr>
                              
                            </tbody>
                        </table>
                    </div>  
                </div>
            </div>
        </div>

    </div>

@endsection;

@section('script')
    <script>

        $(document).ready(function () {

        });

    </script>
@endsection
