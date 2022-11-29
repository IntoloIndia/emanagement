@extends('layouts.app')
@section('page_title', 'Country State City')

@section('style')
  
@endsection

@section('content')
    {{-- Country Modal --}}
    <div class="modal fade" id="countryModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Country </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="countryForm">
                        @csrf
                        <div class="modal-body">
                            <div id="country_err"></div>
                            <div class="row mb-2">
                                <div class="col-md-8">
                                    <label for="countryName" class="form-label">Country Name</label>
                                    <input type="text" name="country" id="country" class="form-control form-control-sm" placeholder="India">
                                </div>
                                <div class="col-md-4">
                                    <label for="countryShort" class="form-label">Short</label>
                                    <input type="text" name="country_short" id="country_short" class="form-control form-control-sm" placeholder="IN">
                                </div>
                            </div>
                            
                            <input type="hidden" name="country_id" id="country_id" value="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="saveCountryBtn" class="btn btn-primary btn-sm ">Save </button>
                            <button type="button" id="updateCountryBtn" class="btn btn-primary btn-sm hide">Update </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- state modal --}}
    <div class="modal fade" id="stateModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">State</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="stateForm">
                        @csrf
                        <div class="modal-body">
                            <div id="state_err"></div>

                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <label for="countryName" class="form-label">Country</label>
                                    <select name="country_id" id="state_country_id" class="form-select form-select-sm">
                                        <option selected disabled >Choose...</option>
                                        @foreach ($countries as $list)
                                            @if ($list->id == MyApp::INDIA)
                                                <option selected value="{{$list->id}}">{{$list->country}}</option>
                                                @else
                                                <option  value="{{$list->id}}">{{$list->country}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="stateName" class="form-label">State</label>
                                    <input type="text" name="state" id="state" class="form-control form-control-sm" placeholder="State name">
                                </div>
                                <div class="col-md-2">
                                    <label for="stateShort" class="form-label">Short</label>
                                    <input type="text" name="state_short" id="state_short" class="form-control form-control-sm" placeholder="MP">
                                </div>

                            </div>

                            <input type="hidden" name="update_state_id" id="update_state_id" value="">
                           
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="saveStateBtn" class="btn btn-primary btn-sm ">Save </button>
                            <button type="button" id="updateStateBtn" class="btn btn-primary btn-sm hide">Update </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Delete </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <center>
                        <h5>Are you sure?</h5>
                        <button type="button" id="yesDeleteBtn"  class="btn btn-primary btn-sm mx-1 ">Yes</button>
                    </center>
                </div>
            </div>
        </div>
    </div>
   
    {{-- country --}}
    <div class="row">
        <div class="col-md-6">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Countries</h3>

                    <div class="card-tools">
                        <div class="row ">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                                <button type="button" id="addCountry" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-plus"></i> Add</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0" >
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Country</th>
                                <th>Short</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($countries->isEmpty())
        
                                <div class="alert alert-warning text-light my-2" role="alert">
                                    <span>Country is not available to add new country click add button</span>
                                </div>
                            @else
                                {{$count = "";}}
                                @foreach ($countries as $item)
                                    <tr>
                                        <td>{{++$count}}</td>
                                        <td>{{ucwords($item->country)}}</td>
                                        <td>{{strtoupper($item->country_short)}}</td>
                                        <td>
                                            @if ($item->id != MyApp::INDIA)
                                                <button type="button" class="btn btn-secondary btn-sm editCountryBtn" value="{{$item->id}}"><i class="fas fa-edit"></i></button>
                                                <button type="button" class="btn btn-danger btn-sm deleteBtn" module-type="{{MyApp::COUNTRY}}" value="{{$item->id}}"><i class="fas fa-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif 
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mt-2">

                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3 col-lg-4 col-xl-4">
                            <h3 class="card-title">States</h3>
                        </div>
                        <div class=" col-md-6 col-lg-6 col-xl-5">
                            <select id="country_id" name="country_id" class="form-select form-select-sm">
                                <option selected disabled>Choose...</option>
                                @foreach ($countries as $key => $list)
                                    <option value="{{$list->id}}" >{{$list->country}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-lg-2 col-xl-3">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                                <button type="button" id="addState" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-plus"></i> Add</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0" >
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>State</th>
                                <th>Short</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($states->isEmpty())
                                <div class="alert alert-warning text-light my-2" role="alert">
                                    <span>State is not available to add new state click add button</span>
                                </div>
                            @else
                                {{$count = "";}}
                                @foreach ($states as $item)
                                    <tr>
                                        <td>{{++$count}}</td>
                                        <td>{{ucwords($item->state)}}</td>
                                        <td>{{strtoupper($item->state_short)}}</td>
                                        <td>
                                            <button type="button" class="btn btn-secondary btn-sm editStateBtn" value="{{$item->id}}"><i class="fas fa-edit"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm deleteBtn" module-type="{{MyApp::STATE}}" value="{{$item->id}}"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif 
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="card">

                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4 ">
                            <h3 class="card-title">Cities</h3>
                        </div>
                        <div class=" col-md-3 ">
                            <select name="country_id" class="form-select form-select-sm">
                                <option selected disabled>Choose...</option>
                                {{-- @foreach ($countries as $key => $list)
                                    <option value="{{$list->id}}" >{{$list->country}}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class=" col-md-3 ">
                            <select  name="country_id" class="form-select form-select-sm">
                                <option selected disabled>Choose...</option>
                                {{-- @foreach ($countries as $key => $list)
                                    <option value="{{$list->id}}" >{{$list->country}}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="col-md-2 ">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                                <button type="button" id="addCity" class="btn btn-primary btn-flat btn-sm "><i class="fas fa-plus"></i> Add</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive p-0" >
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>City</th>
                                <th>Short</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($states->isEmpty())
                                <div class="alert alert-warning text-light my-2" role="alert">
                                    <span>City is not available to add new city click add button</span>
                                </div>
                            @else
                                {{$count = "";}}
                                @foreach ($cities as $item)
                                    <tr>
                                        <td>{{++$count}}</td>
                                        <td>{{ucwords($item->city)}}</td>
                                        <td>{{strtoupper($item->city_short)}}</td>
                                        <td>
                                            <button type="button" class="btn btn-secondary btn-sm editCityBtn" value="{{$item->id}}"><i class="fas fa-edit"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm deleteBtn" module-type="{{MyApp::CITY}}" value="{{$item->id}}"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif 
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>


@endsection

@section('script')
    <script>
        $(document).ready(function () {

        });

        $(document).on('click','#addCountry', function (e) {
            e.preventDefault();
            $('#countryModal').modal('show');
            $('#country_err').html('');
            $('#country_err').removeClass('alert alert-danger');
            $("#countryForm").trigger( "reset"); 
            $('#saveCountryBtn').removeClass('hide');
            $('#updateCountryBtn').addClass('hide');
        });

        $(document).on('click','#saveCountryBtn', function (e) {
            e.preventDefault();
            manageCountry();
        });

        $(document).on('click','.editCountryBtn', function (e) {
            e.preventDefault();
            const country_id = $(this).val();
            editCountry(country_id);
        });

        $(document).on('click','#updateCountryBtn', function (e) {
            e.preventDefault();
            manageCountry();
        });

        // delete
        $(document).on('click','.deleteBtn', function (e) {
            e.preventDefault();
            const module_type = $(this).attr('module-type');
            const country_id = $(this).val();
            $('#deleteModal').modal('show');
            $('#yesDeleteBtn').val(country_id);

            $('#yesDeleteBtn').attr('delete-type', module_type);
        });

        $(document).on('click','#yesDeleteBtn', function (e) {
            e.preventDefault();
            const delete_type = $(this).attr('delete-type');
            const id = $(this).val();
            if (delete_type == '{{MyApp::COUNTRY}}') {
                deleteCountry(id);
            }else if(delete_type == '{{MyApp::STATE}}'){
                deleteState(id);
            }else if(delete_type == '{{MyApp::CITY}}'){
                deleteCity(id);
            }
        });


        $(document).on('click','#addState', function (e) {
            e.preventDefault();
            $('#stateModal').modal('show');
            $('#state_err').html('');
            $('#state_err').removeClass('alert alert-danger');
            $("#stateForm").trigger( "reset"); 
            $('#saveStateBtn').removeClass('hide');
            $('#updateStateBtn').addClass('hide');
        });

        $(document).on('click','#saveStateBtn', function (e) {
            e.preventDefault();
            manageState();
        });

        $(document).on('click','.editStateBtn', function (e) {
            e.preventDefault();
            const state_id = $(this).val();
            editState(state_id);
        });

        $(document).on('click','#updateStateBtn', function (e) {
            e.preventDefault();
            manageState();
        });

        $(document).on('click','#addCity', function (e) {
            e.preventDefault();
            $('#cityModal').modal('show');
            $('#city_err').html('');
            $('#city_err').removeClass('alert alert-danger');
            $("#cityForm").trigger( "reset"); 
            $('#saveCityBtn').removeClass('hide');
            $('#updateCityBtn').addClass('hide');

            const country_id = $('#city_country_id').val();
            getStateByCountry(country_id);
        });

        $(document).on('click','#saveCityBtn', function (e) {
            e.preventDefault();
            manageCity();
        });

        $(document).on('click','.editCityBtn', function (e) {
            e.preventDefault();
            const city_id = $(this).val();
            $('#state_id').html('');
            editCity(city_id);
        });

        $(document).on('click','#updateCityBtn', function (e) {
            e.preventDefault();
            manageCity();
        });

        

        function manageCountry(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#countryForm")[0]);
            $.ajax({
                type: "post",
                url: "manage-country",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    //console.log(response);
                    if(response.status === 400)
                    {
                        $('#country_err').html('');
                        $('#country_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) { 
                            $('#country_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                        });

                    }else{
                        $('#country_err').html('');
                        $('#countryModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        function editCountry(category_id){
            $.ajax({
                type: "get",
                url: "edit-country/"+category_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        $('#countryModal').modal('show');
                        $('#country_err').html('');
                        $('#country_err').removeClass('alert alert-danger');
                        $("#countryForm").trigger( "reset" ); 
                        $('#saveCountryBtn').addClass('hide');
                        $('#updateCountryBtn').removeClass('hide');
                        $('#country').val(response.country.country);
                        $('#country_short').val(response.country.country_short);
                        $('#country_id').val(response.country.id);
                        //$('#updateAdminBtn').val(response.admin.id);
                    }
                }
            });
        }

        function deleteCountry(country_id){
            $.ajax({
                type: "get",
                url: "delete-country/"+country_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        window.location.reload();
                    }
                }
            });
        }

        function manageState(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#stateForm")[0]);
            $.ajax({
                type: "post",
                url: "manage-state",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    //console.log(response);
                    if(response.status === 400)
                    {
                        $('#state_err').html('');
                        $('#state_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) { 
                            $('#state_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                        });

                    }else{
                        $('#state_err').html('');
                        $('#stateModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        function editState(state_id){
            $.ajax({
                type: "get",
                url: "edit-state/"+state_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        $('#stateModal').modal('show');
                        $('#state_err').html('');
                        $('#state_err').removeClass('alert alert-danger');
                        $("#stateForm").trigger( "reset" ); 
                        $('#saveStateBtn').addClass('hide');
                        $('#updateStateBtn').removeClass('hide');
                        $('#state_country_id').val(response.state.country_id);
                        $('#state').val(response.state.state);
                        $('#state_short').val(response.state.state_short);
                        $('#update_state_id').val(response.state.id);
                        //$('#updateAdminBtn').val(response.admin.id);
                    }
                }
            });
        }

        function deleteState(state_id){
            $.ajax({
                type: "get",
                url: "delete-state/"+state_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        window.location.reload();
                    }
                }
            });
        }

        function manageCity(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#cityForm")[0]);
            $.ajax({
                type: "post",
                url: "manage-city",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    //console.log(response);
                    if(response.status === 400)
                    {
                        $('#city_err').html('');
                        $('#city_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) { 
                            $('#city_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                        });

                    }else{
                        $('#city_err').html('');
                        $('#cityModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        function editCity(city_id){
            $.ajax({
                type: "get",
                url: "edit-city/"+city_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        $('#cityModal').modal('show');
                        $('#city_err').html('');
                        $('#city_err').removeClass('alert alert-danger');
                        $("#cityForm").trigger( "reset" ); 
                        $('#saveCityBtn').addClass('hide');
                        $('#updateCityBtn').removeClass('hide');
                        $('#city_country_id').val(response.city.country_id);
                        $('#state_id').html(response.states);
                        $('#city').val(response.city.city);
                        $('#city_short').val(response.city.city_short);
                        $('#city_id').val(response.city.id);

                    }
                }
            });
        }

        function deleteCity(city_id){
            $.ajax({
                type: "get",
                url: "delete-city/"+city_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        window.location.reload();
                    }
                }
            });
        }


    </script>
@endsection