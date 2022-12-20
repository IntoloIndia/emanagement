{{-- category modal of purchase entry --}}
@php
    use App\Models\Category;
    use App\Models\Country;
    use App\Models\Supplier;
    $countries = Country::all();
    $categories = Category::all();
    $suppliers = Supplier::all();

@endphp

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
                    <input type="hidden" name="category_id" id="category_id">
                    <div class="row mt-1" id="category_row">
                        <div class="col-md-4">
                            <label for="select_category" class="form-label">Category</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-select form-select-sm"  name="category_id" id="category_id">
                                <option selected>Choose...</option>
                                @foreach ($categories as $list)
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

<div class="modal fade" id="colorModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Color</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="colorForm">
                    @csrf
                    <div class="modal-body">
                        <div id="size_err"></div>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="Color" class="form-label">Color</label>
                            </div>
                            <div class="col-md-9">
                                {{-- <input type="color" name="color" id="color" class="form-control form-control-sm" placeholder="Color"> --}}
                                <input type="text" name="color" id="color" class="form-control form-control-sm" placeholder="Color">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveColorBtn" class="btn btn-primary btn-sm ">Save</button>
                        <button type="button" id="updateColorBtn" class="btn btn-primary btn-sm hide">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- style no modal of purchase entry --}}
<div class="modal fade" id="styleNoModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
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
                        <input type="hidden" name="supplier_id" id="supplier_id">
                        <div class="row " id="supplier_row">
                            <div class="col-md-4">
                                <label for="Supplier" class="form-label">Supplier</label>
                            </div>
                            <div class="col-md-8">
                                <select id="supplier_id" name="supplier_id" class="form-select form-select-sm">
                                    <option selected disabled >Select...</option>
                                    @foreach ($suppliers as $list)
                                        <option value="{{$list->id}}">{{ucwords($list->supplier_name)}}</option>
                                    @endforeach
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

{{-- <div class="modal fade" id="cityModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">City1</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cityForm">
                    @csrf
                    <div class="modal-body">
                        <div id="city_err"></div>

                        <div class="row mb-2">
                            <div class="col-md-5">
                                <label for="countryName" class="form-label">Country</label>
                                <select name="country_id" id="city_country_id" class="form-select form-select-sm" onchange="getStateByCountry(this.value);">
                                    <option selected disabled >Select...</option>
                                    @foreach ($countries as $list)
                                        @if ($list->id == MyApp::INDIA)
                                            <option selected value="{{$list->id}}">{{$list->country}}</option>
                                        @else
                                            <option  value="{{$list->id}}">{{$list->country}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-7">
                                <label for="stateName" class="form-label">State</label>
                                <select name="state_id" id="state_id" class="form-select form-select-sm">
                                    
                                </select>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-8">
                                <label for="cityName" class="form-label">City</label>
                                <input type="text" name="city" id="city" class="form-control form-control-sm" placeholder="City name">
                            </div>
                            <div class="col-md-4">
                                <label for="cityShort" class="form-label">Short</label>
                                <input type="text" name="city_short" id="city_short" class="form-control form-control-sm" placeholder="JBP">
                            </div>
                        </div>

                        <input type="hidden" name="city_id" id="city_id" value="">
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveCityBtn" class="btn btn-primary btn-sm ">Save </button>
                        <button type="button" id="updateCityBtn" class="btn btn-primary btn-sm hide">Update </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}


<div class="modal fade" id="cityModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">City</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cityForm">
                    @csrf
                    <div class="modal-body">
                        <div id="city_err"></div>

                        <div class="row mb-2">
                            <div class="col-md-5">
                                <input type="hidden" name="country_id" id="put_country_id" class="form-control form-control-sm" placeholder="Country">
                                {{-- <label for="countryName" class="form-label">Country</label>
                                <select name="country_id" id="city_country_id" class="form-select form-select-sm" onchange="getStateByCountry(this.value);">
                                    <option selected disabled >Select...</option>
                                    @foreach ($countries as $list)
                                        @if ($list->id == MyApp::INDIA)
                                            <option selected value="{{$list->id}}">{{$list->country}}</option>
                                        @else
                                            <option  value="{{$list->id}}">{{$list-city_id>country}}</option>
                                        @endif
                                    @endforeach
                                </select> --}}
                            </div>
                            <div class="col-md-7">
                                <input type="hidden" name="state_id" id="city_state_id" class="form-control form-control-sm" placeholder="State" class="required" value="Validate">
                                {{-- <label for="stateName" class="form-label">State</label>
                                <select name="state_id" id="state_id" class="form-select form-select-sm">
                                    
                                </select> --}}
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-8">
                                <label for="cityName" class="form-label">City</label>
                                <input type="text" name="city" id="city" class="form-control form-control-sm" placeholder="City name">
                            </div>
                            <div class="col-md-4">
                                <label for="cityShort" class="form-label">Short</label>
                                <input type="text" name="city_short" id="city_short" class="form-control form-control-sm" placeholder="JBP">
                            </div>
                        </div>

                        <input type="hidden" name="city_id" id="city_id" value="">
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveCityBtn" class="btn btn-primary btn-sm ">Save </button>
                        <button type="button" id="updateCityBtn" class="btn btn-primary btn-sm hide">Update </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


