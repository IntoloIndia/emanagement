@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('style')

    
@endsection

@section('content')

<!-- Button trigger modal -->
  
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
  {{-- end category modal  --}}

  {{-- sub category modal  --}}

  <div class="modal fade" id="staticBackdropsubcategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel"> sub-category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="sub_category_image" class="form-label">Category</label>
              <select class="form-select" aria-label="Default select example" id="category_id">
                <option selected>select category</option>
                <option value="1">Mans</option>
                <option value="2">Womens</option>
                <option value="3">Kids</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="sub_category_image" class="form-label">sub_category_image</label>
              <input type="file" class="form-control" id="sub_category_image" aria-describedby="emailHelp">
              </div>
            <div class="mb-3">
              <label for="sub-category" class="form-label"> sub-category</label>
              <input type="text" class="form-control" id="sub_category" placeholder="category name">
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

  {{-- end sub category modal  --}}
<div class="row">
  <div class="col-lg-6 col-md-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <div class="row">
          <div class="col-6">
            <b>Category</b>
          </div>
          <div class="col-6">
            <button type="button" class="btn btn-primary btn-sm float-right" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
              <i class="fas fa-plus"></i> Add 
            </button>
          </div>
        </div>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Sno</th>
              <th scope="col">Image</th>
              <th scope="col">Category</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tr>
            <td>1</td>
            <td><img src="assets/img/avatars/1.png" class="img-fluid" alt="" srcset="" width="35"></td>
            <td>name</td>
            <td>
              <button class="btn btn-primary btn-sm">Edit</button>
              <button class="btn btn-primary btn-sm">Delete</button>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td><img src="assets/img/avatars/7.png" class="img-fluid" alt="" srcset="" width="35"></td>
            <td>Mans</td>
            <td>
              {{-- <i class="fa-solid fa-pen-to-square"></i> --}}
              {{-- <i class="bi bi-pencil-square"></i> --}}
              {{-- <i class="bi bi-trash"></i> --}}
              <button class="btn btn-primary btn-sm">Edit</button>
              <button class="btn btn-primary btn-sm">Delete</button>
            </td>
          </tr>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  {{-- sub category div start// --}}
  <div class="col-lg-6 col-md-12 col-sm-12">
    <div class="card" style="height: 85vh">
      <div class="card-header">
        <div class="row">
          <div class="col-6">
            <b> Sub Category</b>
          </div>
          <div class="col-6">
            <button type="button" class="btn btn-primary btn-sm float-right" data-bs-toggle="modal" data-bs-target="#staticBackdropsubcategory">
              <i class="fas fa-plus"></i> Add 
            </button>
            
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-6">
                <b>Category</b>
              </div>
              <div class="col-6">
                <button class="btn btn-primary btn-sm float-right"> <i class="fas fa-plus"></i> Add</button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive" style="max-height: 200px">
           <table class="table">
          <thead>
            <tr>
              <th scope="col">Sno</th>
              <th scope="col">Image</th>
              <th scope="col">Subcategory </th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tr>
            <td>1</td>
            <td><img src="assets/img/avatars/1.png" class="img-fluid" alt="" srcset="" width="35"></td>
            <td>name</td>
            <td>
              <button class="btn btn-primary btn-sm">Edit</button>
              <button class="btn btn-primary btn-sm">Delete</button>
            </td>
          </tr>
          <tr>
            <td>1</td>
            <td><img src="assets/img/avatars/1.png" class="img-fluid" alt="" srcset="" width="35"></td>
            <td>name</td>
            <td>
              <button class="btn btn-primary btn-sm">Edit</button>
              <button class="btn btn-primary btn-sm">Delete</button>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td><img src="assets/img/avatars/7.png" class="img-fluid" alt="" srcset="" width="35"></td>
            <td>Mans</td>
            <td>
              {{-- <i class="fa-solid fa-pen-to-square"></i> --}}
              {{-- <i class="bi bi-pencil-square"></i> --}}
              {{-- <i class="bi bi-trash"></i> --}}
              <button class="btn btn-primary btn-sm">Edit</button>
              <button class="btn btn-primary btn-sm">Delete</button>
            </td>
          </tr>
          <tbody>
          </tbody>
        </table>
        </div>
          </div>
        </div>
        
      </div>
    </div>
  </div>
  {{-- sub category div end  --}}
</div>
@endsection


@section('script')
{{-- <script src="{{asset('public/sdpl-assets/user/js/slider.js')}}"></script> --}}
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
@endsection