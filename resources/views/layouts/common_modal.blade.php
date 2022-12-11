{{-- category modal of purchase entry --}}
<div class="modal fade" id="categoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="categoryForm">
              @csrf
              <div class="modal-body">
                  <div id="category_err"></div>
                  <div class="row mt-1">
                      <div class="col-md-4">
                          <label for="categoryName" class="form-label">Category</label>
                      </div>
                      <div class="col-md-8">
                          <input type="text" name="category" id="category" placeholder="Category name" class="form-control form-control-sm">
                      </div>
                  </div>
                  <div class="row mt-1">
                    <div class="col-md-4">
                        <label for="category_img" class="form-label">image</label>
                    </div>
                    <div class="col-md-8">
                        <input type="file" name="category_img" id="category_img" class="form-control form-control-sm">
                    </div>
                    <div class="row mt-1"></div>
                      <div class="col-md-4"></div>
                    <div class="col-md-8">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                  <button type="button" id="saveCategoryBtn" class="btn btn-primary btn-sm ">Save </button>
                  <button type="button" id="updateCategoryBtn" class="btn btn-primary btn-sm hide">Update </button>
              </div>
          </form>
        </div>
    </div>
    </div>
</div>

  {{-- sub category modal of purchase entry --}}
  <div class="modal fade" id="subCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel"> Sub category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <form id="subcategoryForm">
              @csrf
              <div class="modal-body">
                  <div id="subcategory_err"></div>
                    <div class="row mt-1">
                        <div class="col-md-4">
                            <label for="select_category" class="form-label">Category</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-select form-select-sm"  name="category_id" id="category_id">
                                <option selected>Choose...</option>
                                @foreach ($Categories as $list)
                                    <option value="{{$list->id}}">{{ucwords($list->category)}}</option>
                                @endforeach
                            </select>
                        </div>
                  </div>
                  <div class="row mt-1">
                      <div class="col-md-4">
                          <label for="sub categoryName" class="form-label">Sub category</label>
                      </div>
                      <div class="col-md-8">
                          <input type="text" name="sub_category" id="sub_category" placeholder="Subcategory" class="form-control form-control-sm">
                      </div>
                  </div>
                  <div class="row mt-1">
                    <div class="col-md-4">
                        <label for="image" class="form-label">Image</label>
                    </div>
                    <div class="col-md-8">
                        <input type="file" name="sub_category_img" id="sub_category_img" class="form-control form-control-sm">
                    </div>
                    <div class="row mt-1"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                        </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                  <button type="button" id="savesubCategoryBtn" class="btn btn-primary btn-sm ">Save </button>
                  <button type="button" id="updatesubCategoryBtn" class="btn btn-primary btn-sm hide">Update </button>
              </div>
          </form>
      </div>
      </div>
    </div>
</div>
{{-- style no modal of purchase entry --}}
<div class="modal fade" id="styleNoModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Style No</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="styleNoForm">
                    @csrf
                    <div class="modal-body">
                        <div id="style_no_err"></div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="Supplier" class="form-label">Supplier</label>
                            </div>
                            <div class="col-md-8">
                                <select id="supplier_id" name="supplier_id" class="form-select form-select-sm">
                                    <option selected disabled >Select...</option>
                                    {{-- @foreach ($suppliers as $list)
                                        <option value="{{$list->id}}">{{ucwords($list->supplier_name)}}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-4">
                                <label for="styleNo" class="form-label">Style No</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="style_no" id="style_no" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="style_id" id="style_id" value="">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveStyleNoBtn" class="btn btn-primary btn-sm ">Save</button>
                        <button type="button" id="updateStyleNoBtn" class="btn btn-primary btn-sm hide">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- brnad modal --}}


<div class="modal fade" id="brandModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Add Brand</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="brandForm">
              @csrf
              <div class="modal-body">
                  <div id="brand_err"></div>
              
                  <div class="row">
                      <div class="col-md-4">
                          <label class="form-label">Brand</label>
                      </div>
                      <div class="col-md-8">
                          <input type="text" name="brand_name" id="brand_name" placeholder="Brand Name" class="form-control form-control-sm">
                      </div>
                  </div>
                </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                  <button type="button" id="saveBrandBtn" class="btn btn-primary btn-sm ">Save </button>
                  <button type="button" id="updateBrandBtn" class="btn btn-primary btn-sm hide">Update </button>
              </div>
          </form>
      </div>
      </div>
    </div>
</div>