@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')

<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Size color</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/size">
          
              <div class="mb-3">
                <label for="size" class="form-label">Size</label>
                <input type="text" name="size" class="form-control" id="size"placeholder="size" >
              </div>
              
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="submitsize">save</button>
      </form>
      </div>
    </div>
  </div>
</div>
{{-- size modal end  --}}

{{-- color modal start  --}}

<div class="modal fade" id="staticBackdropcolor" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Color</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="/size">
          
              <div class="mb-3">
                <label for="color" class="form-label">color</label>
                <input type="color" name="color" class="form-control" id="color">
                <p id="color_code">#000000</p>
              </div>
              
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="submitcolor">save</button>
      </form>
      </div>
    </div>
  </div>
</div>

{{-- color modal end  --}}


<div class="row">
<div class="col-lg-6 col-md-6 col-sm-12">
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-6">
          <b>Size</b>
        </div>
        <div class="col-6">
          <button type="button" class="btn btn-primary btn-sm float-right" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Add size
          </button>
        </div>
      </div>
    </div>
        <div class="card-body">
          <b>Table</b>
    </div>
  </div>
</div>
{{-- start color div  --}}
<div class="col-lg-6 col-md-6 col-sm-12">
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-6">
          <b>Color</b>
        </div>
        <div class="col-6">
          <button type="button" class="btn btn-primary btn-sm float-right" data-bs-toggle="modal" data-bs-target="#staticBackdropcolor">
            Add color
          </button>
        </div>
      </div>
    </div>
        <div class="card-body">
          <b>Table</b>
    </div>
  </div>
  
</div>
<div class="row">
  <div class="col-12">
    <div style="background-color: red">div</div>
  </div>
</div>

</div>
@endsection

@section('script')
<script>
  $(document).ready(function(){
    $(document).on('click','#submitsize',function(){
      alert("submitsize")
    })
    $(document).on('click','#submitcolor',function(){
      alert("submitcolor")
    })
  })
</script>
@endsection

