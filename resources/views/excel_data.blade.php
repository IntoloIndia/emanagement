@extends('layouts.app')
@section('page_title', 'Purchase Entry')
@section('content')

<div class="row">
    <h1>Excel item data </h1>
    <div class="col-6">
        <form action="{{url('admin/export-excel-data')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" id="file" class="form-control">
            <button class="btn btn-primary mt-2">save</button>
        </form>
    </div>
    <a href="{{url('admin/import-data')}}">export excel file</a>
</div>

@endsection

