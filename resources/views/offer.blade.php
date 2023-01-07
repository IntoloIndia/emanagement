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
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-8">
                                        <div class="form-check product offset-2">
                                            <input class="form-check-input" type="radio" name="exampleRadios" id="product" value="product" checked>
                                            <label class="form-check-label" id="">
                                                <b>Product</b>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check store">
                                            <input class="form-check-input " type="radio" name="exampleRadios" id="store" value="store" >
                                            <label class="form-check-label" id="" >
                                                <b>Store</b>
                                            </label>
                                        </div>
                                    </div>                            
                                </div> 
                            </div>
                        </div>
                        <div class="row mt-2 brand_id">
                            <div class="col-md-6">
                                <label class="form-label brand_id">Brands</label>
                            </div>
                            <div class="col-md-6 style_no_id">
                                <label class="form-label">Style No</label>
                            </div>
                        </div>
                        <div class="row mb-4 ">
                            <div class="col-md-6">
                                <select id="brand_id" name="brand_id" class="form-select form-select-sm select_chosen brand_id" >
                                    <option selected disabled>Brand</option>
                                    @foreach ($brands as $key => $list)
                                        <option value="{{$list->id}}">{{ucwords($list->brand_name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select name="style_no_id" id="style_no_id" class="form-select form-select-sm style_no_id">
                                    <option selected disabled >Style No</option>
                                    @foreach ($get_style_no as $key => $list)
                                        <option value="{{$list->id}}" >{{$list->style_no}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> 

                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="" class="form-label">Percent</label>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">From Date</label>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">To Date</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="number" name="discount_offer" id="discount_offer" class="form-control form-control-sm" min="0" style="height: 5px;">
                            </div>
                            <div class="col-md-4">
                                <input type="date" name="offer_from" id="offer_from" class="form-control form-control-sm" min="0" style="height: 5px;">
                            </div>
                            <div class="col-md-4">
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
{{-- model  --}}

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
    <button class="btn btn-primary btn-sm float-right" id="addOffer"><i class="fas fa-plus"></i>Add</button>
   </div>
</div>

<div class="card mt-3">
    <div class="card-header"><h5><strong>Offers</strong></h5></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="card mt-2">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6"><small><b>From Date</b></small></b></div>
                            <div class="col-md-6 text-end"><small><b>To Date</b></small></b></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><b>1/12/2023</b></div>
                            <div class="col-md-6 text-end"><b>12/12/2023</b></div>
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
            </div>  
            {{-- second card --}}
            <div class="col-md-3">
                <div class="card mt-2">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6"><small><b>From Date</b></small></b></div>
                            <div class="col-md-6 text-end"><small><b>To Date</b></small></b></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><b>10/12/2023</b></div>
                            <div class="col-md-6 text-end"><b>15/12/2023</b></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-12 text-red" ><strong style="font-size:25px;"> 10% Off</strong></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12 text-center"><b>All Product</b></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




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
                $('#saveOfferBtn').removeClass('hide');
                $('#updateOfferBtn').addClass('hide');
            });

            $(document).on('click','#saveOfferBtn', function (e) {
                e.preventDefault();
                // alert("call");
                saveOffer();
            });
            
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