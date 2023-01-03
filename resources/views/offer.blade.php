@extends('layouts.app')
@section('page_title', 'Dashboard')

@section('content')
{{-- model  --}}
<div class="modal fade" id="offerModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Offers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="offerForm">
                    @csrf
                        <div id="offer_err"></div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="" class="form-label">Brands</label>
                            </div>
                            <div class="col-md-8">
                                <select id="brand_id" name="brand_id" class="form-select form-select-sm">
                                    <option selected disabled >Choose...</option>
                                    @foreach ($allbrands as $list)
                                        <option value="{{$list->id}}">{{ucwords($list->brand_name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <label for="" class="form-label">Offer</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" name="discount_offer" id="discount_offer" class="form-control form-control-sm">
                            </div>
                        </div>
                   
                    {{-- <input type="hidden" name="admin_id" id="admin_id" value=""> --}}
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

<div class="row">
    <div class="col-md-4">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Offers</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0" style="height: 450px;">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Brands</th>
                            <th>Offers</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{$count = "";}}
                        @foreach ($offers as $list)
                            <tr>
                                <td>{{++$count}}</td>
                                <td>{{$list->brand_name}}</td>
                                <td>{{$list->discount_offer}}%</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm editOfferBtn mr-1" value="{{$list->id}}"><i class="fas fa-edit"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm deleteOfferBtn ml-1" value="{{$list->id}}"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
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