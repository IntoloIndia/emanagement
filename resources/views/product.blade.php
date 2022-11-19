@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Button trigger modal -->
    
  
  <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="name" class="form-label">item name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter name">
                        {{-- <p id="dataname"></p> --}}
                    </div>
                    <div class="mb-2">
                        <label for="name" class="form-label">category</label>
                        <select class="form-select form-control" aria-label="Default select example" id="category" >
                            <option selected>category</option>
                            <option value="1">Man</option>
                            <option value="2">Women</option>
                            <option value="3">Kids</option>
                            </select>
                    </div>
                        <div class="mb-2">
                        <label for="name" class="form-label"> sub-category</label>
                        <select class="form-select form-control " aria-label="Default select example" id="sub-category">
                            <option selected>sub-category</option>
                            <option value="1">T-shart</option>
                            <option value="1">Jeens</option>
                            <option value="2">Sadhi</option>
                            <option value="2">kurthi</option>
                            <option value="3">Taf</option>
                            <option value="3">shoot</option>
                            </select>
                        </div>
                        <div class="mb-2">
                        <label for="name" class="form-label">size</label>
                        <select class="form-select form-control " aria-label="Default select example" id="size">
                            <option selected>size</option>
                            <option value="sm">sm</option>
                            <option value="md">md</option>
                            <option value="l">l</option>
                            <option value="xl">xl</option>
                            <option value="xll">xll</option>
                            </select>
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <input type="color" class="form-control" id="color">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <!-- {{-- <input type="text" class="form-control" id="colorname" value="dsfgdfg" disabled> --}} -->
                                <p id="colorname"></p>
                            </div>
                        </div>
                        </div>
                        </div>
                    <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary"onClick='saveData()'>Save</button>
            </form>
            </div>

            </div>
            </div>
        </div>
 </div>
</div>

<div class="row ">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
        <button type="button" id="addProduct" class="btn btn-primary btn-flat btn-sm mt-2"><i class="fas fa-plus"></i> Add</button>
    </div>
</div>

@endsection

@section('script')
{{-- //   <script src="{{asset('public/sdpl-assets/user/js/slider.js')}}"></script> --}}
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