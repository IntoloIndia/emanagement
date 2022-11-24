@extends('layouts.app')
@section('page_title', 'Barcode')

@section('content')
    <h1>Barcode</h1>

    <div class="row">

        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <b>Product Barcodes</b>
                </div>
                <div class="card-body">

                    <div class="row">
                        @foreach ($products as $list)
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <img src="{{$list->barcode}}"><br/>
                                    <span>{{$list->product_code}}</span> <br/>
                                    <span>  Size -  {{strtoupper($list->size)}} , Rs - {{$list->price}}</span> 
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- <div class="responsiv-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Sno</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Barcode</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $list)
                                    <tr>
                                        <td>1</td>
                                        <td>Jeans</td>
                                        <td>{{$list->barcode}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>  --}}

                </div>
            </div>
        </div>

    </div>

@endsection

@section('script')

@endsection

