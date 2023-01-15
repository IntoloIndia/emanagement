@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')
{{-- model  --}}
<div class="modal fade" id="offerModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Offer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="offerForm">
                    @csrf
                        <div id="offer_err"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="form-check product">
                                            <input class="form-check-input" type="radio" name="offer_on" id="product" value="1" checked>
                                            <label class="form-check-label" id="">
                                                <b>Product</b>
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="form-check store">
                                            <input class="form-check-input " type="radio" name="offer_on" id="store" value="2" >
                                            <label class="form-check-label" id="" >
                                                <b>Store</b>
                                            </label>
                                        </div>
                                    </li>
                                  </ul>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label ">Offer Type</label>
                                <select  name="offer_type" id="offer_type" class="form-select select_chosen_100">
                                    <option selected disabled>Offer type</option>
                                    <option value="{{MyApp::PERCENTAGE}}">PERCENTAGE</option>
                                    <option value="{{MyApp::VALUES}}">VALUES</option>
                                    <option value="{{MyApp::PICES}}">PICES</option>
                                    <option value="{{MyApp::SLAB}}">SLAB</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div id="inner_html">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-md-12 mt-2">
                                        <select id="category_id" name="category_id" class="form-select form-select-sm select_chosen_100" onchange="getSubCategoryByCategory(this.value);">
                                            <option selected disabled value="0">Category</option>
                                            @foreach ($Categories as $list)
                                            <option value="{{$list->id}}" size-type="{{$list->size_type}}"> {{ucwords($list->category)}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <select id="sub_category_id" name="sub_category_id" class="form-select form-select-sm select_chosen_100">
                                            <option selected disabled >Sub Category</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <select id="brand_id" name="brand_id" class="form-select form-select-sm select_chosen brand_id select_chosen_100" >
                                            <option selected disabled>Brand</option>
                                            @foreach ($brands as $key => $list)
                                                <option value="{{$list->id}}">{{ucwords($list->brand_name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                               
                            </div>
                            <div class="col-md-7 mt-2">
                                <select name="style_no_id[]" id="style_no_id" data-placeholder="Select Style no" class="form-select form-select-sm  select_chosen_100" multiple="">
                                    @foreach ($get_style_no as $key => $list)
                                        <option value="{{$list->id}}" >{{$list->style_no}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                      
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">From Date</label>
                                <input type="date" name="offer_from" id="offer_from" class="form-control form-control-sm" min="0" style="height: 5px;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">To Date</label>
                                <input type="date" name="offer_to" id="offer_to" class="form-control form-control-sm" min="0" style="height: 5px;">
                            </div>
                        </div> 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveOfferBtn" class="btn btn-primary btn-sm ">Save Offer</button>
                        <button type="button" id="updateOfferBtn" class="btn btn-primary btn-sm hide">Update Offer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="hide">

    <div id="purcentage_offer" class="hide mt-3">
        <div class="row">
            <div class="col-md-12">
                <label class="form-label">Purcentage</label>
                <input type="number" name="purcentage"  class="form-control form-control-sm" placeholder="percentage" min="0" >
            </div>
        </div>
    </div>
    <div id="value_offer" class="hide mt-3">
        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Amount</label>
                <input type="text"  name="summary"   class="form-control form-control-sm" placeholder="summary">
            </div>
            <div class="col-md-6">
                <label class="form-label">Purcentage</label>
                <input type="text"   name="purcentage"   class="form-control form-control-sm" placeholder="purcentage" min="0">
            </div>
        </div>
    </div>
    <div id="pices_offer" class="hide mt-3">
        <div class="row">
            <div class="col-md-12">
                <label class="form-label">Pices</label>
                <input type="text"   name="summary"   class="form-control form-control-sm" placeholder="summary">
                <span class="">But 1 get 1 free</span>
            </div>
        </div>
    </div>
    <div id="slab_offer" class="hide mt-3">
        <div class="row">
            <div class="col-md-6">
                <label class="form-label">Pices</label>
                <input type="text"   name="summary"   class="form-control form-control-sm" placeholder="summary">

            </div>
            <div class="col-md-6">
                <label class="form-label">Purcentage</label>
                <input type="number"  name="purcentage"   class="form-control form-control-sm" placeholder="purcentage" min="0">
            </div>
        </div>
    </div>

</div>
{{-- model  --}}


<!-- Button trigger modal -->
  <!-- Modal -->
  

{{-- delete model  --}}
<div class="modal fade" id="deleteOfferModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Delete Admin </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                    <h5>Are you sure?</h5>
                        <button type="button" id="yesDeleteOfferBtn" class="btn btn-primary btn-sm mx-1 ">Yes</button>
                        <button type="button" class="btn btn-secondary mx-1 btn-sm" data-bs-dismiss="modal">No</button>
                    <hr>
                </center>
            </div>
        </div>
    </div>
</div>

{{-- delete model  --}}

<div class="row">
    <div class="col-md-12">
        {{-- <button class="btn btn-success btn-sm float-right ml-4" id="addOfferNew"><i class="fas fa-plus"></i>  Create Offer</button> --}}
        <button class="btn btn-primary btn-sm float-right " id="addOffer"><i class="fas fa-plus"></i>Apply Offer</button>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header"><h5><strong>Offers</strong></h5></div>
    <div class="card-body">
        <div class="row">
            {{-- <div class="col-md-3">
                       
                <div class="card mt-2">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6"><small><b>From Date</b></small></b></div>
                            <div class="col-md-6 text-end"><small><b>To Date</b></small></b></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><b></b></div>
                            <div class="col-md-6 text-end"><b>{{$list->offer_to}}</b></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-12 text-red" ><strong style="font-size:25px;"> 25% Off</strong></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6"><b>Jara</b></div>
                            <div class="col-md-6 text-end"><b> A-1145</b></div>
                        </div>
                    </div>
                </div>
              
            </div>   --}}
            {{-- second card --}}

            @foreach ($offers as $list)  
                @if($list->status == MyApp::ACTIVE)   
                    <div class="col-md-3">
                        <div class="card mt-2" style="background-color:rgb(131, 218, 17)">
                            <div class="card-header" style="background-color:rgb(131, 218, 17)">
                                <div class="row">
                                    <div class="col-md-6"><small><b>From Date</b></small></b></div>
                                    <div class="col-md-6 text-end"><small><b>To Date</b></small></b></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6"><b>{{date('d-m-Y',strtotime($list->offer_from))}}</b></div>
                                    <div class="col-md-6 text-end"><b>{{date('d-m-Y',strtotime($list->offer_to))}}</b></div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-12 text-red" ><strong style="font-size:25px;"> {{$list->purcentage}} % Off</strong></div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    @if($list->offer_on == 1)
                                        <div class="col-md-6"><b>{{$list->brand_name}}</b></div>
                                    <div class="col-md-6 text-end"><b>{{$list->style_no}}</b></div>
                                    @else
                                        <div class="col-md-12 text-center"><b>Store</b></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                <div class="col-md-3">
                    <div class="card mt-2" style="background-color: lightgray">
                        <div class="card-header" style="background-color: lightgray">
                            <div class="row">
                                <div class="col-md-6"><small><b>From Date</b></small></b></div>
                                <div class="col-md-6 text-end"><small><b>To Date</b></small></b></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><b>{{date('d-m-Y',strtotime($list->offer_from))}}</b></div>
                                <div class="col-md-6 text-end"><b>{{date('d-m-Y',strtotime($list->offer_to))}}</b></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-12 text-red" ><strong style="font-size:25px;"> {{$list->discount_offer}} % Off</strong></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                @if($list->offer_on == 1)
                                    <div class="col-md-6"><b>{{$list->brand_name}}</b></div>
                                <div class="col-md-6 text-end"><b>{{$list->style_no}}</b></div>
                                @else
                                    <div class="col-md-12 text-center"><b>Store</b></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

<div class="row">
    @foreach ($offers as $list)
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <div class="card-header">
                    @if ($list->offer_type==MyApp::PERCENTAGE)
                        <b>PERCENTAGE</b>
                    @endif
                    @if($list->offer_type==MyApp::VALUES)
                        <b>VALUES</b>
                    @endif
                
                    @if($list->offer_type==MyApp::PICES)
                        <b>PICES</b>
                    @endif
                
                    @if($list->offer_type==MyApp::SLAB)
                        <b>SLAB</b>
                    @endif
            </div>
            <div class="card-body">
                {{-- <div class="row">
                    <div class="col-md-6">
                        Date:15/01/2022
                    </div>
                    <div class="col-md-6">
                        Date:16/01/2022
                    </div>
                </div> --}}
                <div>
                    <div class="row m-0">
                        <div class="col-md-12 text-center" style="font-size: 18px">
                            <b>{{ucwords($list->brand_name)}}</b>
                        </div>
                    </div>
                    {{-- <hr> --}}
                    <div class="row">
                        <div class="col-md-12 text-center"style="font-size: 22px; color:red ">
                            @if ($list->offer_type==MyApp::PERCENTAGE)
                                <b class="text-center">{{$list->purcentage}}%</b>
                                <b class="text-center">Discount</b>
                            @endif
                            @if($list->offer_type==MyApp::VALUES)
                                <b class="float-left">{{ucwords($list->summary)}}</b>
                                <b class="text-center">{{$list->purcentage}}%</b>
                                <b class="float-right ">Discount</b>
                            @endif
                        
                            @if($list->offer_type==MyApp::PICES)
                            <b class="text-center">{{ucwords($list->summary)}}</b>
                            @endif
                        
                            @if($list->offer_type==MyApp::SLAB)
                            <b class="float-left">{{ucwords($list->summary)}}</b>
                            <b class="text-center">{{$list->purcentage}}%</b>
                            <b class="float-right ">Discount</b>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- <hr> --}}
                <div class="row mt-2">
                    @foreach(explode(',', $list->style_no_id) as $item)
                        <div class="col-md-4 mt-1">
                            {{-- <ul class="list-group"> --}}
                                <li class="list-group-item">{{$item}}</li>
                            {{-- </ul> --}}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-6"><small><b>From Date</b></small></b></div>
                <div class="col-md-6 text-end"><small><b>To Date</b></small></b></div>
            </div>
            <div class="row">
                <div class="col-md-6"><b>{{date('d-m-Y',strtotime($list->offer_from))}}</b></div>
                <div class="col-md-6 text-end"><b>{{date('d-m-Y',strtotime($list->offer_to))}}</b></div>
            </div>
        </div>
     </div>
    </div>
    @endforeach
</div>



{{-- <div class="row">
    @foreach ($allOffersType as $list)
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                @if ($list->offer_type==MyApp::PERCENTAGE)
                    <b>PERCENTAGE</b>
                @endif
                @if($list->offer_type==MyApp::VALUES)
                    <b>VALUES</b>
                @endif
            
                @if($list->offer_type==MyApp::PICES)
                    <b>PICES</b>
                @endif
            
                @if($list->offer_type==MyApp::SLAB)
                    <b>SLAB</b>
                @endif
            
                {{-- <button type="button" class="btn btn-danger btn-sm float-right ml-3" value="{{$list->id}}"><i class="fas fa-trash"></i></button> --}}
                {{-- <button type="button" class="btn btn-info btn-sm float-right" value="{{$list->id}}"><i class="fas fa-edit"></i></button>
            </div>
            <div class="card-body">
                <div class="row">
                   <div class="col-md-6">
                        <p> {{$list->summary}}</p>
                   </div>
                   <div class="col-md-6" >
                        <p class="float-right">{{$list->purcentage}}% Discount</p>
                   </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div> --}} 



@endsection
@section('script')
<script>
    $(document).ready(function () {
        $(document).on('click','#addOffer', function (e) {
            e.preventDefault();
            $('#offerModal').modal('show');
            $('#offer_err').html('');
            $('#offer_err').removeClass('alert alert-danger');
            $("#offerForm").trigger("reset"); 
            $(".select_chosen_100").chosen({ width: '100%' });
            $('#saveOfferBtn').removeClass('hide');
            $('#updateOfferBtn').addClass('hide');
            });

            // $(document).on('click','#addOfferNew', function (e) {
            //     e.preventDefault();
            //     $('#offerModalNew').modal('show');
            //     $('#offer_err').html('');
            //     $('#offer_err').removeClass('alert alert-danger');
            //     $("#offerDataForm").trigger("reset"); 
            //     $('#saveOfferBtn').removeClass('hide');
            //     $('#updateOfferBtn').addClass('hide');
            // });

            // $(document).on('click','#saveOfferBtn', function (e) {
            //     e.preventDefault();
            //     // alert("call");
            //     saveCreateOffer();
            // });
            $(document).on('click','#saveOfferBtn', function (e) {
                e.preventDefault();
                // alert("call");
                saveOffer();
            });

            // $(document).on('change','#style_no_id', function (e) {
                // e.preventDefault();
              
            // });
            
            $(document).on('click','.editOfferBtn', function (e) {
                e.preventDefault();
                const offer_id = $(this).val();
                editOffer(offer_id);
            });

            $(document).on('click','#updateOfferBtn', function (e) {
                e.preventDefault();
                const offer_id = $(this).val();
                updateOffer(offer_id);
            });
            
            $(document).on('click','.deleteOfferBtn', function (e) {
                e.preventDefault();
                const offer_id = $(this).val();
                alert(offer_id);
                $('#deleteOfferModal').modal('show');
                $('#yesDeleteOfferBtn').val(offer_id);
            });

            $(document).on('click','#yesDeleteOfferBtn', function (e) {
                e.preventDefault();
                const offer_id = $(this).val();
                deleteOffer(offer_id);
            });

            $(document).on('change','.store', function (e) {
                e.preventDefault();
                // alert("fg");
               $('.brand_id').addClass('hide');
               $('.style_no_id').addClass('hide');
            });

            $(document).on('change','.product', function (e) {
                e.preventDefault();
                // alert("fg");
               $('.brand_id').removeClass('hide');
               $('.style_no_id').removeClass('hide');
            });

            $(document).on('change','#offer_type', function (e) {
                var offer_type = $(this).val();
                $('#inner_html').html('');
                if(offer_type ==1){
                    // $('#purcentage_offer').removeClass('hide');
                    $('#inner_html').append($('#purcentage_offer').html());

                    // $('#pices_offer').addClass('hide');
                    // $('#value_offer').addClass('hide');
                    // $('#slab_offer').addClass('hide');
                }
                else if(offer_type ==2){
                    $('#inner_html').append($('#value_offer').html());
                    // $('#value_offer').removeClass('hide');
                    // $('#pices_offer').addClass('hide');
                    // $('#purcentage_offer').addClass('hide');
                    // $('#slab_offer').addClass('hide');
                }
                else if(offer_type ==3){
                    $('#inner_html').append($('#pices_offer').html());
                    // $('#pices_offer').removeClass('hide');
                    // $('#purcentage_offer').addClass('hide');
                    // $('#value_offer').addClass('hide');
                    // $('#slab_offer').addClass('hide');
                }
                else if(offer_type ==4){
                    $('#inner_html').append($('#slab_offer').html());
                    // $('#slab_offer').removeClass('hide');
                    // $('#pices_offer').addClass('hide');
                    // $('#value_offer').addClass('hide');
                    // $('#purcentage_offer').addClass('hide');
                }
              
            });

        });

        function saveOffer(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#offerForm")[0]);
            $.ajax({
                type: "post",
                url: "save-offer",
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    if(response.status === 400)
                    {
                        $('#offer_err').html('');
                        $('#offer_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) { 
                            $('#offer_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                        });

                    }else{
                        $('#offer_err').html('');
                        $('#offerModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }


        // function saveCreateOffer(){
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });

        //     var formData = new FormData($("#offerDataForm")[0]);
        //     $.ajax({
        //         type: "post",
        //         url: "save-create-offer",
        //         data: formData,
        //         dataType: "json",
        //         cache: false,
        //         contentType: false, 
        //         processData: false, 
        //         success: function (response) {
        //             if(response.status === 400)
        //             {
        //                 $('#offer_err').html('');
        //                 $('#offer_err').addClass('alert alert-danger');
        //                 var count = 1;
        //                 $.each(response.errors, function (key, err_value) { 
        //                     $('#offer_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
        //                 });

        //             }else{
        //                 $('#offer_err').html('');
        //                 $('#offerModalNew').modal('hide');
        //                 window.location.reload();
        //             }
        //         }
        //     });
        // }

        function editOffer(offer_id){
            $.ajax({
                type: "get",
                url: "edit-offer/"+offer_id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 200){
                        $('#offerModal').modal('show');
                        $('#offer_err').html('');
                        $('#offer_err').removeClass('alert alert-danger');
                        $("#offerForm").trigger( "reset" ); 
                        $('#saveOfferBtn').addClass('hide');
                        $('#updateOfferBtn').removeClass('hide');
                        $('#brand_id').val(response.offer.brand_id);
                        $('#style_no_id').val(response.offer.style_no_id);
                        $('#discount_offer').val(response.offer.discount_offer);

                        $('#updateOfferBtn').val(response.offer.id);
                    }
                }
            });
        }

        function updateOffer(offer_id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData($("#offerForm")[0]);
            $.ajax({
                type: "post",
                url: "update-offer/"+offer_id,
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false, 
                processData: false, 
                success: function (response) {
                    if(response.status === 400)
                    {
                        $('#offer_err').html('');
                        $('#offer_err').addClass('alert alert-danger');
                        var count = 1;
                        $.each(response.errors, function (key, err_value) { 
                            $('#offer_err').append('<span>' + count++ +'. '+ err_value+'</span></br>');
                        });

                    }else{
                        $('#offer_err').html('');
                        $('#offerModal').modal('hide');
                        window.location.reload();
                    }
                }
            });
        }

        function deleteOffer(offer_id){
            $.ajax({
                type: "get",
                url: "delete-offer/"+offer_id,
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