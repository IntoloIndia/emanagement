@extends('layouts.app')
@section('page_title', 'Dashboard')


@section('content')

<div class="row">
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-sm float-right" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    Add category
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="category_image" class="form-label">category_image</label>
              <input type="file" class="form-control" id="category_image" aria-describedby="emailHelp">
              </div>
            <div class="mb-3">
              <label for="category" class="form-label">category</label>
              <input type="text" class="form-control" id="category" placeholder="category name">
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<div class="row mt-2">
  <div class="col-lg-2 col-md-3 col-sm-12">
    <div class="card">
      <div class="card-header">
        name
      </div>
      <div class="card-body">
        <img src="../../user-img.jpg" alt="image not found" srcset="">
      </div>
    </div>
  </div>
  <div class="col-lg-2 col-md-3 col-sm-12">
    <div class="card">
      <div class="card-header">
        name
      </div>
      <div class="card-body">
        <img src="" alt="" srcset="">
      </div>
    </div>
  </div>
</div>
</div>
@endsection


@section('script')
<script>
    function saveData(e){
        // e.preventDefault()
        let name = document.getElementById('name').value;
        // dataname.innerHTML= name
        let color = document.getElementById('color').value;
        let size = document.getElementById('size').value;
        let category = document.getElementById('category').value;
        let subCategory = document.getElementById('sub-category').value;
        document.getElementById('colorname').innerHTML = color;
        // colorname.innerHTML = "hello"
        let  data = {name,color,size,category,subCategory} 
        alert(JSON.stringify(data))
    }
</script>
<script src="{{asset('public/sdpl-assets/user/js/slider.js')}}"></script>
@endsection