@extends('layouts.app')
@section('page_title', 'Brand')

@section('content')
@include('layouts.common_modal')
<div class="row mb-2">
    <div class="col-12">
      <button type="button" id="addBrandBtn" class="btn btn-primary float-right btn-flat btn-sm mt-2"><i class="fas fa-plus"></i> Add</button>
    </div>
  </div>

  @endsection

  @section('script')
  <script>
        $(document).ready(function(){
            $(document).on('click','#addBrandBtn',function(e)
            {
                e.preventDefault();
                $('#brandModal').modal('show');
                $('#brand_err').html('');
                $('#brand_err').removeClass('alert alert-danger');
                $('#brandForm').trigger('reset');
                $('#saveBrandBtn').removeClass('hide');
                $('#updateBrandBtn').addClass('hide');
            });

            $(document).on('click','#saveBrandBtn', function (e) {
                e.preventDefault();
                // alert('dd')
                saveBarand();
                
            });
        });
  </script>
  @endsection